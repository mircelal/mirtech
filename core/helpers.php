<?php
declare(strict_types=1);

// Default demo password: admin1234 — change in production (see README)
if (!defined('ADMIN_PASSWORD_HASH')) {
    define('ADMIN_PASSWORD_HASH', '$2y$10$6wtxHGRtDxZT.s2iWdqf8.B2MnMcRAIsLBy9/6GVhBeEztrYVP4sG');
}
if (!defined('PROJECT_IMAGE_MAX_BYTES')) {
    define('PROJECT_IMAGE_MAX_BYTES', 3 * 1024 * 1024);
}
if (!defined('PROJECT_IMAGE_TYPES')) {
    define('PROJECT_IMAGE_TYPES', ['image/jpeg', 'image/png', 'image/webp', 'image/gif']);
}
if (!defined('PROJECT_VENDOR_NAME')) {
    define('PROJECT_VENDOR_NAME', 'MirTech');
}
if (!defined('PROJECT_REPO_URL')) {
    define('PROJECT_REPO_URL', 'https://github.com/mircelal/mirtech');
}
if (!defined('ADMIN_PROJECTS_PER_PAGE')) {
    define('ADMIN_PROJECTS_PER_PAGE', 20);
}

function baseUrl(): string
{
    static $base = null;
    if ($base !== null) {
        return $base;
    }

    $doc = rtrim(str_replace('\\', '/', $_SERVER['DOCUMENT_ROOT'] ?? ''), '/');
    $public = rtrim(str_replace('\\', '/', PUBLIC_PATH), '/');
    $root = rtrim(str_replace('\\', '/', ROOT_PATH), '/');

    // Standart: document root = public/ → təmiz URL (/projects.php)
    if ($doc !== '' && $doc === $public) {
        $base = '';
        return $base;
    }

    // Layihə kökü docroot + .htaccess → public/ URL-də görünmür
    if ($doc !== '' && $doc === $root) {
        $base = '';
        return $base;
    }

    // Alt-qovluq quraşdırması (məs. example.com/mirtech/)
    if ($doc !== '' && str_starts_with($public, $doc . '/')) {
        $base = rtrim(substr($public, strlen($doc)), '/');
    } elseif ($doc !== '' && str_starts_with($root, $doc . '/')) {
        $base = rtrim(substr($root, strlen($doc)), '/');
    } else {
        $base = '';
    }

    return $base;
}

/** /public/projects.php → /projects.php (köhnə və ya səhv linklər) */
function normalizeWebPath(string $path): string
{
    $path = '/' . ltrim(str_replace('\\', '/', $path), '/');
    if (str_starts_with($path, '/public/')) {
        return substr($path, 7) ?: '/';
    }
    if ($path === '/public') {
        return '/';
    }
    return $path;
}

function asset(string $path): string
{
    return baseUrl() . '/' . ltrim($path, '/');
}

function fontsStylesheetUrl(): string
{
    return 'https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,400;0,500;0,600;0,700;1,400&family=Outfit:wght@500;600;700;800&display=swap';
}

function url(string $path = ''): string
{
    if (function_exists('siteUrl') && !isAdminRequest()) {
        return siteUrl($path);
    }
    return baseUrl() . '/' . ltrim($path, '/');
}

/** Absolute path under public/ for uploaded media (e.g. uploads/projects/x.jpg). */
function publicFilePath(string $relative): string
{
    return PUBLIC_PATH . '/' . ltrim(str_replace('\\', '/', $relative), '/');
}

function publicFileExists(string $relative): bool
{
    return $relative !== '' && is_file(publicFilePath($relative));
}

function readJson(string $file): array
{
    $path = DATA_PATH . '/' . $file;
    if (!is_file($path)) {
        return [];
    }
    $raw = file_get_contents($path);
    $data = json_decode($raw ?: '[]', true);
    return is_array($data) ? $data : [];
}

function writeJson(string $file, array $data): bool
{
    $path = DATA_PATH . '/' . $file;
    $json = json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    return file_put_contents($path, $json) !== false;
}

function isLoggedIn(): bool
{
    return !empty($_SESSION['admin_logged_in']);
}

function requireAuth(): void
{
    if (!isLoggedIn()) {
        header('Location: login.php');
        exit;
    }
}

function nextId(array $items): int
{
    $max = 0;
    foreach ($items as $item) {
        $id = (int)($item['id'] ?? 0);
        if ($id > $max) {
            $max = $id;
        }
    }
    return $max + 1;
}

function uploadProjectImage(array $file, ?string $oldPath = null): ?string
{
    if (($file['error'] ?? UPLOAD_ERR_NO_FILE) === UPLOAD_ERR_NO_FILE) {
        return $oldPath ?: null;
    }
    if (($file['error'] ?? UPLOAD_ERR_OK) !== UPLOAD_ERR_OK) {
        return null;
    }
    if (($file['size'] ?? 0) > PROJECT_IMAGE_MAX_BYTES) {
        return null;
    }
    $finfo = finfo_open(FILEINFO_MIME_TYPE);
    $mime = finfo_file($finfo, $file['tmp_name']);
    finfo_close($finfo);
    if (!in_array($mime, PROJECT_IMAGE_TYPES, true)) {
        return null;
    }
    if (!is_dir(UPLOADS_PATH)) {
        mkdir(UPLOADS_PATH, 0755, true);
    }
    $ext = match ($mime) {
        'image/jpeg' => 'jpg',
        'image/png' => 'png',
        'image/webp' => 'webp',
        'image/gif' => 'gif',
        default => 'jpg',
    };
    $name = 'proj_' . bin2hex(random_bytes(8)) . '.' . $ext;
    $dest = UPLOADS_PATH . '/' . $name;
    if (!move_uploaded_file($file['tmp_name'], $dest)) {
        return null;
    }
    if ($oldPath) {
        $oldFull = publicFilePath($oldPath);
        if (is_file($oldFull)) {
            @unlink($oldFull);
        }
    }
    return 'uploads/projects/' . $name;
}

function deleteProjectImage(?string $path): void
{
    if (!$path) {
        return;
    }
    $full = publicFilePath($path);
    if (is_file($full)) {
        @unlink($full);
    }
}

function saveLead(array $lead): array
{
    $leads = readJson('leads.json');
    $lead['id'] = nextId($leads);
    $lead['created_at'] = date('Y-m-d H:i:s');
    $mail = sendLeadNotificationEmail($lead);
    $lead['email_sent'] = $mail['ok'];
    if (!$mail['ok'] && !empty($mail['error'])) {
        $lead['email_error'] = $mail['error'];
    }
    array_unshift($leads, $lead);
    writeJson('leads.json', $leads);

    return [
        'id' => $lead['id'],
        'email_sent' => $mail['ok'],
        'email_error' => $mail['error'],
    ];
}

function techCategoryOrder(): array
{
    return ['languages', 'web', 'mobile', 'database', 'devops', 'infra', 'systems', 'cloud', 'ai'];
}

function sortByOrder(array $items): array
{
    usort($items, fn($a, $b) => ($a['sort'] ?? 0) <=> ($b['sort'] ?? 0));
    return $items;
}

function isFeatured(array $item): bool
{
    return !empty($item['featured']);
}

function getFeaturedItems(array $items, int $limit): array
{
    $items = sortByOrder($items);
    $featured = array_values(array_filter($items, 'isFeatured'));
    if (count($featured) >= $limit) {
        return array_slice($featured, 0, $limit);
    }
    $ids = array_column($featured, 'id');
    foreach ($items as $item) {
        if (count($featured) >= $limit) {
            break;
        }
        if (!in_array($item['id'] ?? null, $ids, true)) {
            $featured[] = $item;
        }
    }
    return $featured;
}

function homepageLimits(): array
{
    $s = readJson('settings.json');
    $hp = $s['homepage'] ?? [];
    return [
        'projects' => max(1, min(12, (int)($hp['projects_limit'] ?? 6))),
        'technologies' => max(1, min(20, (int)($hp['technologies_limit'] ?? 10))),
        'services' => max(1, min(8, (int)($hp['services_limit'] ?? 4))),
    ];
}

function filterProjects(array $projects, ?string $status, ?string $category, ?string $q): array
{
    return array_values(array_filter($projects, function ($p) use ($status, $category, $q) {
        if ($status && ($p['status'] ?? '') !== $status) {
            return false;
        }
        $cat = function_exists('localized') ? localized($p, 'category') : ($p['category'] ?? '');
        if ($category && strcasecmp($cat, $category) !== 0) {
            return false;
        }
        if ($q) {
            $name = function_exists('localized') ? localized($p, 'name') : ($p['name'] ?? '');
            $desc = function_exists('localized') ? localized($p, 'desc') : ($p['desc'] ?? '');
            $hay = mb_strtolower($name . ' ' . $desc . ' ' . $cat);
            if (!str_contains($hay, mb_strtolower($q))) {
                return false;
            }
        }
        return true;
    }));
}

function paginate(array $items, int $page, int $perPage): array
{
    $total = count($items);
    $totalPages = max(1, (int)ceil($total / $perPage));
    $page = max(1, min($page, $totalPages));
    $offset = ($page - 1) * $perPage;
    return [
        'items' => array_slice($items, $offset, $perPage),
        'total' => $total,
        'page' => $page,
        'per_page' => $perPage,
        'total_pages' => $totalPages,
    ];
}

function projectCategories(array $projects): array
{
    $cats = [];
    foreach ($projects as $p) {
        $c = trim(function_exists('localized') ? localized($p, 'category') : ($p['category'] ?? ''));
        if ($c !== '') {
            $cats[$c] = true;
        }
    }
    $list = array_keys($cats);
    sort($list, SORT_NATURAL | SORT_FLAG_CASE);
    return $list;
}

function statColorClass(string $color): string
{
    return match ($color) {
        'teal' => 'accent-teal',
        'amber' => 'accent-amber',
        'purple' => 'accent-purple',
        default => '',
    };
}

function siteContact(): array
{
    $settings = readJson('settings.json');
    $contact = $settings['contact'] ?? [];
    $waRaw = $contact['whatsapp_raw'] ?? '994707232128';
    return [
        'contact' => $contact,
        'whatsapp_raw' => $waRaw,
        'whatsapp_link' => 'https://wa.me/' . $waRaw,
    ];
}

function projectUrl(array $project): string
{
    return url('project.php?id=' . (int)($project['id'] ?? 0));
}

function getProjectById(int $id): ?array
{
    foreach (readJson('projects.json') as $p) {
        if ((int)($p['id'] ?? 0) === $id) {
            return $p;
        }
    }
    return null;
}

function getAllProjects(): array
{
    return sortByOrder(readJson('projects.json'));
}

/** @return array<int, array<string, mixed>> */
function technologyMap(): array
{
    $map = [];
    foreach (readJson('technologies.json') as $t) {
        $map[(int)($t['id'] ?? 0)] = $t;
    }
    return $map;
}

function resolveProjectTechnologies(array $project): array
{
    $names = $project['technologies'] ?? [];
    if (!is_array($names)) {
        return [];
    }
    $allTech = readJson('technologies.json');
    $byName = [];
    foreach ($allTech as $t) {
        $byName[mb_strtolower($t['name'])] = $t;
        $short = mb_strtolower(str_replace(['.', ' '], '', $t['name']));
        $byName[$short] = $t;
    }
    $out = [];
    foreach ($names as $name) {
        $name = trim((string)$name);
        if ($name === '') {
            continue;
        }
        $key = mb_strtolower($name);
        $keyShort = mb_strtolower(str_replace(['.', ' '], '', $name));
        $out[] = $byName[$key] ?? $byName[$keyShort] ?? [
            'name' => $name,
            'icon' => 'fa-code',
            'icon_type' => 'solid',
            'brand' => '',
        ];
    }
    return $out;
}

function relatedProjects(array $current, int $limit = 3): array
{
    $all = getAllProjects();
    $cat = $current['category'] ?? '';
    $related = array_values(array_filter($all, function ($p) use ($current, $cat) {
        return (int)($p['id'] ?? 0) !== (int)($current['id'] ?? 0)
            && ($p['category'] ?? '') === $cat;
    }));
    if (count($related) < $limit) {
        $relatedIds = array_map(fn($r) => (int)($r['id'] ?? 0), $related);
        foreach ($all as $p) {
            $pid = (int)($p['id'] ?? 0);
            if ($pid === (int)($current['id'] ?? 0) || in_array($pid, $relatedIds, true)) {
                continue;
            }
            $related[] = $p;
            $relatedIds[] = $pid;
            if (count($related) >= $limit) {
                break;
            }
        }
    }
    return array_slice($related, 0, $limit);
}

function parseLines(string $text): array
{
    return array_values(array_filter(array_map('trim', preg_split('/\r\n|\r|\n/', $text))));
}

function parseTechnologiesInput(string $text): array
{
    $parts = preg_split('/[\r\n,]+/', $text);
    return array_values(array_filter(array_map('trim', $parts ?: [])));
}

function parseTimelineFromPost(): array
{
    $titles = $_POST['tl_title'] ?? [];
    $descs = $_POST['tl_desc'] ?? [];
    $progress = $_POST['tl_progress'] ?? [];
    $statuses = $_POST['tl_status'] ?? [];
    $timeline = [];
    $count = max(count($titles), count($descs), count($progress), count($statuses));
    for ($i = 0; $i < $count; $i++) {
        $title = trim((string)($titles[$i] ?? ''));
        if ($title === '') {
            continue;
        }
        $timeline[] = [
            'title' => $title,
            'desc' => trim((string)($descs[$i] ?? '')),
            'progress' => max(0, min(100, (int)($progress[$i] ?? 0))),
            'status' => in_array($statuses[$i] ?? '', ['done', 'active', 'pending'], true)
                ? $statuses[$i] : 'pending',
        ];
    }
    return $timeline;
}

function parseStatsFromPost(): array
{
    $labels = $_POST['st_label'] ?? [];
    $values = $_POST['st_value'] ?? [];
    $maxs = $_POST['st_max'] ?? [];
    $stats = [];
    $count = max(count($labels), count($values), count($maxs));
    for ($i = 0; $i < $count; $i++) {
        $label = trim((string)($labels[$i] ?? ''));
        if ($label === '') {
            continue;
        }
        $stats[] = [
            'label' => $label,
            'value' => trim((string)($values[$i] ?? '')),
            'max' => max(1, (int)($maxs[$i] ?? 100)),
        ];
    }
    return $stats;
}

function projectOverallProgress(array $project): int
{
    if (isset($project['progress_overall'])) {
        return max(0, min(100, (int)$project['progress_overall']));
    }
    $timeline = $project['timeline'] ?? [];
    if (!$timeline) {
        return match ($project['status'] ?? '') {
            'completed' => 100,
            'ongoing' => 65,
            'started' => 25,
            default => 0,
        };
    }
    $sum = 0;
    foreach ($timeline as $step) {
        $sum += (int)($step['progress'] ?? 0);
    }
    return (int)round($sum / count($timeline));
}
