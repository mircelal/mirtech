<?php
declare(strict_types=1);

/** SEO slug (AZ hərfləri → latın). */
function slugify(string $text): string
{
    $text = mb_strtolower(trim($text), 'UTF-8');
    $map = [
        'ə' => 'e', 'ı' => 'i', 'ö' => 'o', 'ü' => 'u', 'ğ' => 'g', 'ş' => 's', 'ç' => 'c',
        'á' => 'a', 'é' => 'e', 'í' => 'i', 'ó' => 'o', 'ú' => 'u', 'ñ' => 'n',
    ];
    $text = strtr($text, $map);
    $text = preg_replace('/[^a-z0-9]+/u', '-', $text) ?? '';
    $text = trim($text, '-');
    return $text !== '' ? $text : 'item';
}

function projectSlug(array $project, ?string $lang = null): string
{
    if (!empty($project['slug']) && is_string($project['slug'])) {
        return slugify($project['slug']);
    }
    $name = function_exists('localized')
        ? localized($project, 'name', $lang)
        : ($project['name'] ?? 'project');
    return slugify((string)$name);
}

/** Nisbi yol: project/12-elektron-kitab-platformasi */
function projectUrlPath(array $project, ?string $lang = null): string
{
    $id = (int)($project['id'] ?? 0);
    return 'project/' . $id . '-' . projectSlug($project, $lang);
}

function routesEnabledLangCodes(): array
{
    static $codes = null;
    if ($codes !== null) {
        return $codes;
    }
    $codes = [];
    foreach (enabledLangs() as $l) {
        $c = (string)($l['code'] ?? '');
        if ($c !== '') {
            $codes[] = $c;
        }
    }
    return $codes;
}

function routesNormalizeRoute(string $path): string
{
    $path = trim(str_replace('\\', '/', $path), '/');
    if ($path === '' || $path === 'index.php') {
        return '';
    }

    if (preg_match('#^project(?:\.php)?$#i', $path)) {
        return 'project';
    }
    if (preg_match('#^project/(\d+)(?:-[^/]*)?$#i', $path, $m)) {
        $_GET['id'] = (int)$m[1];
        return 'project';
    }
    if (preg_match('#^project\.php$#i', $path)) {
        return 'project';
    }

    return match ($path) {
        'projects.php', 'projects' => 'projects',
        'technologies.php', 'technologies', 'tech' => 'technologies',
        'calculator.php', 'calculator' => 'calculator',
        default => $path,
    };
}

/**
 * @return array{route: string, params: array<string, mixed>, langFromPath: ?string}
 */
function routesParseRequest(): array
{
    $uri = $_SERVER['REQUEST_URI'] ?? '/';
    $path = trim(normalizeWebPath(parse_url($uri, PHP_URL_PATH) ?: '/'), '/');
    $segments = $path === '' ? [] : explode('/', $path);

    $langFromPath = null;
    $def = defaultLang();
    if ($segments !== [] && in_array($segments[0], routesEnabledLangCodes(), true)) {
        if ($segments[0] !== $def) {
            $langFromPath = $segments[0];
            $_GET['lang'] = $langFromPath;
        }
        array_shift($segments);
    }

    $query = [];
    parse_str(parse_url($uri, PHP_URL_QUERY) ?? '', $query);
    unset($query['lang']);

    $route = '';
    if ($segments === []) {
        $route = '';
    } elseif ($segments[0] === 'projects') {
        $route = 'projects';
    } elseif ($segments[0] === 'technologies') {
        $route = 'technologies';
    } elseif ($segments[0] === 'calculator') {
        $route = 'calculator';
    } elseif ($segments[0] === 'project' && isset($segments[1])) {
        $route = 'project';
        if (preg_match('#^(\d+)#', $segments[1], $m)) {
            $query['id'] = (int)$m[1];
            $_GET['id'] = (int)$m[1];
        }
    }

    return [
        'route' => $route,
        'params' => $query,
        'langFromPath' => $langFromPath,
    ];
}

/** Sayt URL-i (nisbi, / ilə). */
function routesBuildUrl(string $route, array $params = [], ?string $lang = null): string
{
    $route = routesNormalizeRoute($route);
    $lang = $lang ?? currentLang();
    $def = defaultLang();

    if ($route === 'project' || str_starts_with($route, 'project/')) {
        $id = (int)($params['id'] ?? 0);
        if ($id <= 0 && preg_match('#^project/(\d+)#', $route, $m)) {
            $id = (int)$m[1];
        }
        $project = $id > 0 ? getProjectById($id) : null;
        $segment = $project ? projectUrlPath($project, $lang) : ('project/' . max(0, $id));
        unset($params['id']);
    } else {
        $segment = $route;
    }

    $parts = [];
    if ($lang !== $def) {
        $parts[] = $lang;
    }
    if ($segment !== '') {
        $parts[] = $segment;
    }

    $path = implode('/', $parts);
    $url = baseUrl();
    if ($path === '') {
        $url = ($url === '' ? '/' : $url . '/');
    } else {
        $url = $url . '/' . $path;
        // Dil prefiksi tək başına (/en) — Apache DirectorySlash ilə uyğun
        if (count($parts) === 1 && in_array($parts[0], routesEnabledLangCodes(), true)) {
            $url .= '/';
        }
    }

    unset($params['lang'], $params['id']);
    $params = array_filter($params, static fn($v) => $v !== null && $v !== '');

    if ($params !== []) {
        $url .= (str_contains($url, '?') ? '&' : '?') . http_build_query($params);
    }

    return $url;
}

/** Brauzerin sorğuladığı yol (daxili rewrite deyil). */
function routesBrowserPath(): string
{
    $theRequest = $_SERVER['THE_REQUEST'] ?? '';
    if (preg_match('#\s(\S+)#', $theRequest, $m)) {
        $raw = explode('?', $m[1], 2)[0];
        return normalizeWebPath($raw);
    }
    return normalizeWebPath(parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH) ?: '/');
}

/** Köhnə .php URL → 301 təmiz URL (yalnız brauzer .php istəyəndə). */
function routesRedirectLegacy(): void
{
    if (isAdminRequest()) {
        return;
    }

    $browserPath = routesBrowserPath();
    $uri = $_SERVER['REQUEST_URI'] ?? '';
    $query = [];
    parse_str(parse_url($uri, PHP_URL_QUERY) ?? '', $query);

    if (preg_match('#/project\.php$#i', $browserPath)) {
        $id = (int)($query['id'] ?? $_GET['id'] ?? 0);
        if ($id > 0) {
            $project = getProjectById($id);
            if ($project) {
                $lang = !empty($query['lang']) && isValidLang((string)$query['lang'])
                    ? (string)$query['lang'] : null;
                unset($query['id'], $query['lang']);
                header('Location: ' . routesBuildUrl('project', array_merge(['id' => $id], $query), $lang), true, 301);
                exit;
            }
        }
    }

    $legacyFiles = [
        '/index.php' => '',
        '/projects.php' => 'projects',
        '/technologies.php' => 'technologies',
        '/calculator.php' => 'calculator',
    ];

    foreach ($legacyFiles as $legacyPath => $route) {
        if ($browserPath === $legacyPath || str_ends_with($browserPath, $legacyPath)) {
            $lang = !empty($query['lang']) && isValidLang((string)$query['lang']) ? (string)$query['lang'] : null;
            unset($query['lang']);
            header('Location: ' . routesBuildUrl($route, $query, $lang), true, 301);
            exit;
        }
    }

    // ?lang=en → /en/... (yalnız dil prefiksi URL-də yoxdursa)
    if (!empty($query['lang']) && isValidLang((string)$query['lang'])) {
        $parsed = routesParseRequest();
        if ($parsed['langFromPath'] === null) {
            $lang = (string)$query['lang'];
            unset($query['lang']);
            $merged = array_merge($parsed['params'], $query);
            $target = routesBuildUrl($parsed['route'], $merged, $lang);
            $targetPath = normalizeWebPath(parse_url($target, PHP_URL_PATH) ?: '/');
            if ($targetPath !== $browserPath) {
                header('Location: ' . $target, true, 301);
                exit;
            }
        }
    }
}

/** Layihə səhifəsində slug uyğunsuzdursa 301. */
function routesRedirectCanonicalProject(array $project): void
{
    if (isAdminRequest()) {
        return;
    }
    $expectedPath = normalizeWebPath(parse_url(routesBuildUrl('project', ['id' => (int)($project['id'] ?? 0)]), PHP_URL_PATH) ?: '/');
    $browserPath = routesBrowserPath();
    $norm = static fn(string $p) => rtrim(strtolower(rawurldecode($p)), '/') ?: '/';
    if ($norm($expectedPath) !== $norm($browserPath)) {
        header('Location: ' . routesBuildUrl('project', ['id' => (int)($project['id'] ?? 0)]), true, 301);
        exit;
    }
}

function routesApplyLangFromPath(): void
{
    if (isAdminRequest()) {
        return;
    }
    $parsed = routesParseRequest();
    if ($parsed['langFromPath'] !== null) {
        $_SESSION['site_lang'] = $parsed['langFromPath'];
        $GLOBALS['_mirtech_lang'] = $parsed['langFromPath'];
    }
}
