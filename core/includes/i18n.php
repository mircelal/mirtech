<?php
declare(strict_types=1);

require_once __DIR__ . '/i18n-defaults.php';

/** @var string|null */
$GLOBALS['_mirtech_lang'] = null;

/** @var array<string, string>|null */
$GLOBALS['_mirtech_strings'] = null;

function isAdminRequest(): bool
{
    $script = str_replace('\\', '/', $_SERVER['SCRIPT_NAME'] ?? '');
    return str_contains($script, '/admin/');
}

function readLanguagesMeta(): array
{
    static $meta = null;
    static $loadedMtime = null;
    $path = DATA_PATH . '/languages.json';
    $mtime = is_file($path) ? (int)filemtime($path) : 0;
    if ($meta !== null && $loadedMtime === $mtime) {
        return $meta;
    }
    if (!is_file($path)) {
        $meta = [
            ['code' => 'en', 'name' => 'English', 'native' => 'English', 'enabled' => true, 'default' => true],
        ];
        $loadedMtime = $mtime;
        return $meta;
    }
    $raw = json_decode(file_get_contents($path) ?: '[]', true);
    $meta = is_array($raw) ? $raw : [];
    $loadedMtime = $mtime;
    return $meta;
}

function enabledLangs(): array
{
    return array_values(array_filter(readLanguagesMeta(), fn($l) => !empty($l['enabled'])));
}

function defaultLang(): string
{
    foreach (readLanguagesMeta() as $l) {
        if (!empty($l['default'])) {
            return (string)$l['code'];
        }
    }
    return 'en';
}

function isValidLang(string $code): bool
{
    foreach (enabledLangs() as $l) {
        if (($l['code'] ?? '') === $code) {
            return true;
        }
    }
    return false;
}

function initLang(): void
{
    if (isAdminRequest()) {
        return;
    }
    if ($GLOBALS['_mirtech_lang'] !== null) {
        return;
    }

    $parsed = routesParseRequest();
    $lang = null;

    if (!empty($_GET['lang']) && is_string($_GET['lang'])) {
        $candidate = strtolower(trim($_GET['lang']));
        if (isValidLang($candidate)) {
            $lang = $candidate;
            $_SESSION['site_lang'] = $lang;
        }
    }
    if ($lang === null && $parsed['langFromPath'] !== null) {
        $lang = $parsed['langFromPath'];
        $_SESSION['site_lang'] = $lang;
    }
    // Default dil URL-də prefiks yoxdur (/projects) — admin default; brauzer Accept-Language yox
    if ($lang === null && $parsed['langFromPath'] === null && !isset($_GET['lang'])) {
        $lang = defaultLang();
        $_SESSION['site_lang'] = $lang;
    }
    if ($lang === null && !empty($_SESSION['site_lang']) && isValidLang((string)$_SESSION['site_lang'])) {
        $lang = (string)$_SESSION['site_lang'];
    }
    if ($lang === null) {
        $lang = defaultLang();
    }

    $GLOBALS['_mirtech_lang'] = $lang;
    loadLangPack($lang);
}

function currentLang(): string
{
    if ($GLOBALS['_mirtech_lang'] === null) {
        initLang();
    }
    return $GLOBALS['_mirtech_lang'] ?? defaultLang();
}

function loadLangPack(string $lang): void
{
    $path = DATA_PATH . '/lang/' . $lang . '.json';
    if (is_file($path)) {
        $data = json_decode(file_get_contents($path) ?: '{}', true);
        $GLOBALS['_mirtech_strings'] = is_array($data) ? $data : [];
        return;
    }
    $GLOBALS['_mirtech_strings'] = i18nDefaultStrings($lang);
}

function langStrings(): array
{
    if ($GLOBALS['_mirtech_strings'] === null) {
        loadLangPack(currentLang());
    }
    return $GLOBALS['_mirtech_strings'] ?? [];
}

function t(string $key, array $replace = []): string
{
    $strings = langStrings();
    $text = $strings[$key] ?? i18nDefaultStrings(defaultLang())[$key] ?? $key;
    foreach ($replace as $k => $v) {
        $text = str_replace('{' . $k . '}', (string)$v, $text);
    }
    return $text;
}

function localized(array $entity, string $field, ?string $lang = null): string
{
    $lang = $lang ?? currentLang();
    $def = defaultLang();
    $tr = $entity['translations'] ?? [];
    if (is_array($tr)) {
        if (!empty($tr[$lang][$field]) || (isset($tr[$lang][$field]) && $tr[$lang][$field] === '0')) {
            $val = $tr[$lang][$field];
            return is_string($val) ? $val : (string)$val;
        }
        if ($lang !== $def && !empty($tr[$def][$field])) {
            return (string)$tr[$def][$field];
        }
    }
    if (isset($entity[$field]) && is_string($entity[$field])) {
        return $entity[$field];
    }
    return '';
}

/** @return array<int, string> */
function localizedList(array $entity, string $field, ?string $lang = null): array
{
    $lang = $lang ?? currentLang();
    $def = defaultLang();
    $tr = $entity['translations'] ?? [];
    $list = null;
    if (is_array($tr)) {
        if (isset($tr[$lang][$field]) && is_array($tr[$lang][$field])) {
            $list = $tr[$lang][$field];
        } elseif ($lang !== $def && isset($tr[$def][$field]) && is_array($tr[$def][$field])) {
            $list = $tr[$def][$field];
        }
    }
    if ($list === null && isset($entity[$field]) && is_array($entity[$field])) {
        $list = $entity[$field];
    }
    return is_array($list) ? array_values(array_map('strval', $list)) : [];
}

/** @return array<int, array<string, mixed>> */
function localizedTimeline(array $entity, ?string $lang = null): array
{
    $lang = $lang ?? currentLang();
    $def = defaultLang();
    $tr = $entity['translations'] ?? [];
    if (is_array($tr) && !empty($tr[$lang]['timeline']) && is_array($tr[$lang]['timeline'])) {
        return $tr[$lang]['timeline'];
    }
    if (is_array($tr) && $lang !== $def && !empty($tr[$def]['timeline'])) {
        return $tr[$def]['timeline'];
    }
    return is_array($entity['timeline'] ?? null) ? $entity['timeline'] : [];
}

/** @return array<int, array<string, mixed>> */
function localizedStats(array $entity, ?string $lang = null): array
{
    $lang = $lang ?? currentLang();
    $def = defaultLang();
    $tr = $entity['translations'] ?? [];
    if (is_array($tr) && !empty($tr[$lang]['stats']) && is_array($tr[$lang]['stats'])) {
        return $tr[$lang]['stats'];
    }
    if (is_array($tr) && $lang !== $def && !empty($tr[$def]['stats'])) {
        return $tr[$def]['stats'];
    }
    return is_array($entity['stats'] ?? null) ? $entity['stats'] : [];
}

function siteUrl(string $path = '', ?string $lang = null): string
{
    return queryUrl($path, [], $lang);
}

/** URL with query string; SEO-friendly path (/projects, /project/1-slug, /en/...). */
function queryUrl(string $path, array $params = [], ?string $lang = null): string
{
    if (preg_match('#^project\.php$#i', ltrim($path, '/')) || $path === 'project') {
        $id = (int)($params['id'] ?? $_GET['id'] ?? 0);
        if ($id > 0) {
            return routesBuildUrl('project', array_merge(['id' => $id], $params), $lang);
        }
    }
    return routesBuildUrl($path, $params, $lang);
}

function langUrl(string $targetLang, ?string $path = null): string
{
    if ($path === null) {
        $req = routesParseRequest();
        return routesBuildUrl($req['route'], $req['params'], $targetLang);
    }
    if (str_contains($path, '?')) {
        [$p, $qs] = explode('?', $path, 2);
        $params = [];
        parse_str($qs, $params);
        return routesBuildUrl($p, $params, $targetLang);
    }
    return routesBuildUrl($path, [], $targetLang);
}

function getSettingsLocalized(?string $lang = null): array
{
    static $cache = [];
    $lang = $lang ?? currentLang();
    if (isset($cache[$lang])) {
        return $cache[$lang];
    }
    $raw = readJson('settings.json');
    $def = defaultLang();
    $tr = $raw['translations'][$lang] ?? [];
    $fallback = $raw['translations'][$def] ?? [];
    $merged = $raw;
    foreach (['tagline', 'hero_eyebrow', 'hero_title', 'hero_title_highlight', 'hero_subtitle'] as $k) {
        if (!empty($tr[$k])) {
            $merged[$k] = $tr[$k];
        } elseif (!empty($fallback[$k])) {
            $merged[$k] = $fallback[$k];
        }
    }
    if (!empty($tr['stats'])) {
        $merged['stats'] = $tr['stats'];
    } elseif (!empty($fallback['stats'])) {
        $merged['stats'] = $fallback['stats'];
    }
    if (!empty($tr['why'])) {
        $merged['why'] = $tr['why'];
    } elseif (!empty($fallback['why'])) {
        $merged['why'] = $fallback['why'];
    }
    if (!empty($tr['included'])) {
        $merged['included'] = $tr['included'];
    } elseif (!empty($fallback['included'])) {
        $merged['included'] = $fallback['included'];
    }
    $cache[$lang] = $merged;
    return $merged;
}

function techCategoryLabel(string $cat): string
{
    $key = 'tech.cat.' . $cat;
    $label = t($key);
    return $label !== $key ? $label : $cat;
}

function projectStatusLabel(string $status): string
{
    $key = 'status.' . $status;
    $label = t($key);
    return $label !== $key ? $label : $status;
}

function hreflangLinks(): string
{
    if (isAdminRequest()) {
        return '';
    }
    $uri = $_SERVER['REQUEST_URI'] ?? '/';
    $path = normalizeWebPath(parse_url($uri, PHP_URL_PATH) ?: '/');
    $doc = rtrim(str_replace('\\', '/', $_SERVER['DOCUMENT_ROOT'] ?? ''), '/');
    $root = rtrim(str_replace('\\', '/', ROOT_PATH), '/');
    if ($doc !== '' && $doc !== $root && str_starts_with($root, $doc . '/')) {
        $prefix = rtrim(substr($root, strlen($doc)), '/');
        if ($prefix !== '' && str_starts_with($path, $prefix)) {
            $path = substr($path, strlen($prefix)) ?: '/';
        }
    }
    $req = routesParseRequest();

    $html = '';
    foreach (enabledLangs() as $l) {
        $code = $l['code'] ?? '';
        if ($code === '') {
            continue;
        }
        $href = absoluteUrl(routesBuildUrl($req['route'], $req['params'], $code));
        $html .= '<link rel="alternate" hreflang="' . htmlspecialchars($code) . '" href="' . htmlspecialchars($href) . '">' . "\n";
    }
    $html .= '<link rel="alternate" hreflang="x-default" href="' . htmlspecialchars(absoluteUrl(routesBuildUrl($req['route'], $req['params'], defaultLang()))) . '">';
    return $html;
}

function calcLangPack(): array
{
    $all = langStrings();
    $calc = [];
    foreach ($all as $k => $v) {
        if (str_starts_with($k, 'calc.')) {
            $calc[$k] = $v;
        }
    }
    return $calc;
}
