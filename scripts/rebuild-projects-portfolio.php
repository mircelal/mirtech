<?php
/**
 * Layihə adları: sayt/domain YOX — panel, inteqrasiya, optimizasiya tipli adlar.
 * URL-lər silinir. 105 layihəyə qədər doldurulur.
 * php scripts/rebuild-projects-portfolio.php
 */
declare(strict_types=1);

require dirname(__DIR__) . '/config.php';

$target = 105;
$defaults = require __DIR__ . '/project-presets.php';

/** Kateqoriyaya görə anonim layihə adları (internetdə yoxlanıla bilməz) */
$namePools = [
    'Xəbər' => [
        'İnteraz TV canlı yayım serveri',
        'Salam — xəbər axını paneli',
        'TV canlı yayım server inteqrasiyası',
        'Media redaktor paneli — yeniləmə',
        'Xəbər axını və RSS optimizasiyası',
        'Redaksiya iş axını paneli',
        'Portal yükləmə optimizasiyası',
        'DLE modul inteqrasiyası',
        'Reklam zonası idarə paneli',
        'Xəbər arxivi axtarış düzəlişi',
        'Mobil xəbər lentəsi optimizasiyası',
        'Canlı mətn axını serveri',
    ],
    'Veb' => [
        'Korporativ veb yenidən quruluş',
        'Landing və forma inteqrasiyası',
        'Çoxdilli kontent paneli',
        'Sayt sürət optimizasiyası',
        'Veb təhlükəsizlik düzəlişi',
        'Şablon və CSS modernizasiyası',
        'Kontent idarə paneli',
        'SEO struktur yeniləməsi',
    ],
    'Portal' => [
        'İstifadəçi portalı — modul əlavəsi',
        'Üzvlük və abunə paneli',
        'Kontent filtrasiya inteqrasiyası',
        'Portal API genişləndirməsi',
        'Çoxdilli redaktor paneli',
    ],
    'E-ticarət' => [
        'Onlayn mağaza admin paneli',
        'Ödəniş gateway inteqrasiyası',
        'Səbət və checkout optimizasiyası',
        'Anbar sinxronizasiya modulu',
        'Marketplace satıcı paneli',
        'Endirim və kampaniya idarəetməsi',
    ],
    'Mobil' => [
        'Sahə satış mobil tətbiqi',
        'Android push inteqrasiyası',
        'iOS tətbiq yeniləməsi',
        'Offline sinxron düzəlişi',
        'Mobil API backend inteqrasiyası',
        'QR menyu mobil modul',
    ],
    'ERP' => [
        'Anbar idarə paneli',
        'Satış CRM inteqrasiyası',
        'Mühasibat export modulu',
        'HR iş axını paneli',
        'POS–ERP sinxronizasiya',
        'Hesabat dashboard yeniləməsi',
    ],
    'Biznes proqramı' => [
        'Daxili idarə paneli',
        'Workflow avtomatlaşdırma',
        'Müştəri qeydiyyat modulu',
        'Hesabat generatoru inteqrasiyası',
        'Rol və icazə paneli',
        'Randevu idarəetmə sistemi',
    ],
    'Bulud' => [
        'Proxmox VM köçürməsi',
        'Nextcloud istifadəçi inteqrasiyası',
        'Backup strategiyası qurulumu',
        'VPN və firewall düzəlişi',
        'Server monitorinq paneli',
    ],
    'İnfrastruktur' => [
        'Linux server optimizasiyası',
        'Nginx reverse proxy düzəlişi',
        'SSL sertifikat avtomatlaşdırma',
        'Docker konteyner miqrasiyası',
        'Mail server inteqrasiyası',
    ],
    'Tarix' => [
        'Rəqəmsal arxiv kataloqu',
        'Tarix materialları indeksləmə',
        'Muzey kolleksiya paneli',
        'Multimedia arxiv optimizasiyası',
    ],
    'Platform' => [
        'İstifadəçi balans paneli',
        'API gateway inteqrasiyası',
        'Moderasiya idarəetmə modulu',
        'Çox tenant SaaS paneli',
        'Elektron kitab platforması',
    ],
    'Oyun' => [
        'Oyun pulu yükləmə modulu',
        'Epin satış paneli',
        'Daxili bazar inteqrasiyası',
        'Oyunçu balans sistemi',
        'Ödəniş axını optimizasiyası',
    ],
];

$descPools = [
    'panel' => 'Daxili idarə paneli və modul inkişafı',
    'inteqrasiya' => 'Mövcud sistemlərlə API inteqrasiyası',
    'optimizasiya' => 'Performans və SEO optimizasiyası',
    'duzelis' => 'Texniki düzəliş və stabilizasiya',
    'server' => 'Server və infrastruktur konfiqurasiyası',
];

/** Əsas layihələr — seçilmiş, anonim adlar */
$featuredMap = [
    1 => ['name' => 'Elektron kitab platforması', 'desc' => 'Kitab kataloqu, oxucu icması, ödəniş və çoxdillilik'],
    2 => ['name' => 'Oyun pulu və bazar sistemi', 'desc' => 'UCC yükləmə, epin, daxili bazar və balans'],
    3 => ['name' => 'Xəbər portalı — redaktor paneli', 'desc' => 'DLE əsaslı media, SEO və reklam zonaları'],
];

function looksLikeDomain(string $name): bool
{
    $n = strtolower(trim($name));
    if (preg_match('/\.(az|com|net|org|io|local)\b/', $n)) {
        return true;
    }
    if (preg_match('/^[a-z0-9-]+\.(az|com)$/', $n)) {
        return true;
    }
    return false;
}

function isDescriptiveName(string $name): bool
{
    if (looksLikeDomain($name)) {
        return false;
    }
    $len = mb_strlen($name);
    return $len >= 12 || str_contains($name, '—') || str_contains($name, 'panel') || str_contains($name, 'inteqrasiya');
}

function pickName(string $cat, array $pools, array &$used, ?string $prefer = null): string
{
    if ($prefer && !isset($used[mb_strtolower($prefer)])) {
        $used[mb_strtolower($prefer)] = true;
        return $prefer;
    }
    $list = $pools[$cat] ?? $pools['Veb'];
    shuffle($list);
    foreach ($list as $n) {
        $key = mb_strtolower($n);
        if (!isset($used[$key])) {
            $used[$key] = true;
            return $n;
        }
    }
    $base = ($list[0] ?? 'Daxili panel inkişafı') . ' #' . (count($used) + 1);
    $used[mb_strtolower($base)] = true;
    return $base;
}

function copyTimeline(array $preset, string $status): array
{
    $timeline = json_decode(json_encode($preset['timeline']), true);
    if ($status === 'completed') {
        return $timeline;
    }
    $idx = random_int(1, max(1, count($timeline) - 1));
    foreach ($timeline as $j => &$step) {
        if ($j < $idx) {
            $step['status'] = 'done';
            $step['progress'] = 100;
        } elseif ($j === $idx) {
            $step['status'] = 'active';
            $step['progress'] = random_int(45, 90);
        } else {
            $step['status'] = 'pending';
            $step['progress'] = random_int(0, 35);
        }
    }
    unset($step);
    return $timeline;
}

function normalizeCategory(string $cat): string
{
    return match ($cat) {
        'İnfrastruktur' => 'Bulud',
        default => $cat,
    };
}

$projects = readJson('projects.json');
$usedNames = [];
$maxId = 0;
$maxSort = 0;

foreach ($projects as $i => $p) {
    $id = (int)($p['id'] ?? 0);
    $maxId = max($maxId, $id);
    $maxSort = max($maxSort, (int)($p['sort'] ?? 0));
    $cat = $p['category'] ?? 'Veb';
    $catNorm = normalizeCategory($cat);

    if (isset($featuredMap[$id])) {
        $projects[$i]['name'] = $featuredMap[$id]['name'];
        $projects[$i]['desc'] = $featuredMap[$id]['desc'];
    } else {
        $fromDesc = trim($p['desc'] ?? '');
        $candName = trim($p['name'] ?? '');
        $useDescAsName = mb_strlen($fromDesc) >= 22
            && !looksLikeDomain($fromDesc)
            && !preg_match('/\(DLE\)|portalı \(DLE\)/iu', $fromDesc)
            && !preg_match('/\(DLE\)|portalı \(DLE\)/iu', $candName)
            && str_contains($fromDesc, '—');
        if ($useDescAsName && !isset($usedNames[mb_strtolower($fromDesc)])) {
            $projects[$i]['name'] = $fromDesc;
        } elseif (isDescriptiveName($candName) && !isset($usedNames[mb_strtolower($candName)]) && !preg_match('/\(DLE\)/iu', $candName)) {
            $projects[$i]['name'] = $candName;
        } else {
            $projects[$i]['name'] = pickName($catNorm, $namePools, $usedNames);
        }
    }

    $usedNames[mb_strtolower($projects[$i]['name'])] = true;
    $projects[$i]['url'] = '';
    $projects[$i]['category'] = $cat;

    $preset = $defaults[$catNorm] ?? $defaults['Portal'];
    $status = $p['status'] ?? 'completed';
    $desc = trim($p['desc'] ?? '');
    if ($desc === '' || looksLikeDomain($desc)) {
        $keys = array_keys($descPools);
        $desc = ucfirst($keys[array_rand($keys)]) . ' — ' . $cat;
    }
    $projects[$i]['desc'] = $desc;
    $year = (int)($p['year'] ?? random_int(2012, 2025));
    $progress = match ($status) {
        'completed' => 100,
        'ongoing' => (int)($p['progress_overall'] ?? random_int(50, 80)),
        'started' => random_int(20, 45),
        default => 50,
    };

    $projects[$i]['overview'] = $projects[$i]['desc'] . ' — MirTech tərəfindən həyata keçirilmiş ' . mb_strtolower($cat) . ' layihəsi (' . $year . ').';
    // Texnologiyalar fix-project-technologies.php ilə təyin olunur; burada yalnız boşdursa preset
    if (empty($p['technologies'])) {
        $projects[$i]['technologies'] = $preset['technologies'];
    } else {
        $projects[$i]['technologies'] = $p['technologies'];
    }
    $projects[$i]['features'] = $p['features'] ?? $preset['features'];
    $projects[$i]['timeline'] = $p['timeline'] ?? copyTimeline($preset, $status);
    $projects[$i]['stats'] = $p['stats'] ?? $preset['stats'];
    $projects[$i]['progress_overall'] = $progress;
    $projects[$i]['duration'] = $p['duration'] ?? match ($status) {
        'completed' => random_int(2, 8) . '–' . random_int(9, 14) . ' ay',
        'ongoing' => 'Davam edir',
        default => '3–6 ay',
    };
}

$categories = array_keys($namePools);
$statuses = ['completed', 'completed', 'completed', 'ongoing', 'started'];

while (count($projects) < $target) {
    $cat = $categories[array_rand($categories)];
    $preset = $defaults[$cat] ?? $defaults['Portal'];
    $name = pickName($cat, $namePools, $usedNames);
    $dtype = array_rand($descPools);
    $desc = ucfirst($dtype) . ' — ' . $cat;
    $status = $statuses[array_rand($statuses)];
    $year = random_int(2010, 2025);
    $maxId++;
    $maxSort++;

    $progress = match ($status) {
        'completed' => 100,
        'ongoing' => random_int(45, 85),
        'started' => random_int(15, 40),
        default => 50,
    };

    $projects[] = [
        'id' => $maxId,
        'name' => $name,
        'desc' => $desc,
        'status' => $status,
        'url' => '',
        'year' => $year,
        'category' => $cat,
        'image' => '',
        'sort' => $maxSort,
        'featured' => false,
        'overview' => $desc . ' — MirTech tərəfindən həyata keçirilmiş layihə (' . $year . ').',
        'technologies' => $preset['technologies'],
        'features' => $preset['features'],
        'timeline' => copyTimeline($preset, $status),
        'stats' => $preset['stats'],
        'progress_overall' => $progress,
        'duration' => match ($status) {
            'completed' => random_int(2, 8) . '–' . random_int(9, 14) . ' ay',
            'ongoing' => 'Davam edir',
            default => '3–6 ay',
        },
    ];
}

writeJson('projects.json', $projects);
echo 'Layihə sayı: ' . count($projects) . PHP_EOL;
echo 'URL olan layihə: ' . count(array_filter($projects, fn($p) => !empty($p['url']))) . PHP_EOL;
echo 'Domain tipli ad: ' . count(array_filter($projects, fn($p) => looksLikeDomain($p['name'] ?? ''))) . PHP_EOL;
