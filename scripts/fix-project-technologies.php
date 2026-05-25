<?php
/**
 * Layihə texnologiyalarını işin məzmununa uyğunlaşdırır.
 * php scripts/fix-project-technologies.php
 */
declare(strict_types=1);

require dirname(__DIR__) . '/config.php';

/** Layihə adına görə dəqiq stack */
$byName = [
    'Elektron kitab platforması' => ['PHP', 'Laravel', 'Vue.js', 'MySQL', 'Redis', 'Linux'],
    'Oyun pulu və bazar sistemi' => ['PHP', 'Laravel', 'Vue.js', 'MySQL', 'Redis', 'Linux'],
    'Xəbər portalı — redaktor paneli' => ['PHP', 'DLE', 'MySQL', 'Linux', 'Nginx'],
    'İnteraz TV canlı yayım serveri' => ['Linux', 'Ubuntu', 'Nginx', 'Docker', 'Grafana', 'Prometheus', 'Bash'],
    'Salam — xəbər axını paneli' => ['PHP', 'DLE', 'MySQL', 'Linux', 'Nginx'],
    'Azefinance Mail Server' => ['Linux', 'Ubuntu', 'Nginx', 'Docker', 'Bash', 'WireGuard'],
    'Azefinance Bulud' => ['Proxmox VE', 'Nextcloud', 'Linux', 'Ubuntu', 'Docker', 'Nginx'],
    'COO ERP' => ['PHP', 'Laravel', 'Vue.js', 'MySQL', 'Linux'],
    'COO POS' => ['PHP', 'Laravel', 'MySQL', 'Linux', 'REST API'],
    'COO Scanner' => ['PHP', 'Laravel', 'MySQL', 'Linux'],
    'COO Sales' => ['PHP', 'Laravel', 'Vue.js', 'MySQL', 'Linux'],
    'COO HRM' => ['PHP', 'Laravel', 'MySQL', 'Linux'],
    'Nextcloud & Proxmox' => ['Proxmox VE', 'Nextcloud', 'Linux', 'Ubuntu', 'Docker', 'Nginx', 'Grafana'],
    'Topdan satış — anbar proqramı' => ['PHP', 'Laravel', 'MySQL', 'Linux'],
    'Onlayn lüğət — AI ilə söz izahları' => ['Python', 'OpenAI', 'REST API', 'PostgreSQL', 'Linux'],
    'Backend və idarəetmə sistemi' => ['PHP', 'Laravel', 'Vue.js', 'MySQL', 'Redis', 'Linux'],
    'Çoxplatformalı POS və kiosk' => ['PHP', 'Laravel', 'MySQL', 'Linux', 'REST API'],
];

/** Açar söz qaydaları (ad + təsvir, prioritet yüksək) */
$keywordRules = [
    ['keys' => ['canlı yayım', 'tv yayım', 'yayım server', 'canlı mətn axını', 'mətn axını server', 'stream server', 'rtmp', 'hls'], 'tech' => ['Linux', 'Ubuntu', 'Nginx', 'Docker', 'Grafana', 'Prometheus', 'Bash']],
    ['keys' => ['mail server', 'poçt server', 'smtp', 'korporativ poçt'], 'tech' => ['Linux', 'Ubuntu', 'Nginx', 'Docker', 'Bash', 'WireGuard']],
    ['keys' => ['proxmox', 'nextcloud', 'vm ', 'virtualizasiya', 'bulud köçür'], 'tech' => ['Proxmox VE', 'Nextcloud', 'Linux', 'Ubuntu', 'Docker', 'Nginx']],
    ['keys' => ['monitorinq', 'grafana', 'prometheus', 'backup', 'firewall', 'vpn', 'wireguard'], 'tech' => ['Linux', 'Ubuntu', 'Docker', 'Grafana', 'Prometheus', 'Nginx', 'Bash']],
    ['keys' => ['wordpress', 'woo'], 'tech' => ['PHP', 'WordPress', 'MySQL', 'Linux', 'Nginx']],
    ['keys' => ['dle', 'datalife'], 'tech' => ['PHP', 'DLE', 'MySQL', 'Linux', 'Nginx']],
    ['keys' => ['flutter', 'android', 'ios', 'mobil tətbiq', 'pwa', 'push bildiriş'], 'tech' => ['Flutter', 'Kotlin', 'Android', 'REST API', 'Linux']],
    ['keys' => ['erp', 'crm', 'anbar', 'pos', 'satış panel', 'mühasibat', 'hr '], 'tech' => ['PHP', 'Laravel', 'Vue.js', 'MySQL', 'Linux']],
    ['keys' => ['e-ticarət', 'mağaza', 'səbət', 'marketplace', 'onlayn satış'], 'tech' => ['PHP', 'Laravel', 'MySQL', 'Redis', 'Linux', 'Nginx']],
    ['keys' => ['openai', 'süni intellekt', ' ai ', 'machine learning', 'pytorch', 'tensorflow'], 'tech' => ['Python', 'OpenAI', 'REST API', 'PostgreSQL', 'Linux']],
    ['keys' => ['oyun', 'epin', 'ucc', 'bazar yeri', 'oyunçu'], 'tech' => ['PHP', 'Laravel', 'Vue.js', 'MySQL', 'Redis', 'Linux']],
    ['keys' => ['desktop', 'c++', 'windows proqram'], 'tech' => ['C++', 'Linux', 'REST API']],
];

$categoryTech = [
    'Xəbər' => ['PHP', 'DLE', 'MySQL', 'Linux', 'Nginx'],
    'Veb' => ['PHP', 'Laravel', 'Vue.js', 'MySQL', 'Linux', 'Nginx'],
    'Portal' => ['PHP', 'Laravel', 'Vue.js', 'MySQL', 'Linux', 'Nginx'],
    'E-ticarət' => ['PHP', 'Laravel', 'MySQL', 'Redis', 'Linux', 'Nginx'],
    'Mobil' => ['Flutter', 'Kotlin', 'Android', 'REST API', 'Linux'],
    'ERP' => ['PHP', 'Laravel', 'Vue.js', 'MySQL', 'Linux'],
    'Biznes proqramı' => ['PHP', 'Laravel', 'MySQL', 'Linux'],
    'Bulud' => ['Proxmox VE', 'Linux', 'Ubuntu', 'Docker', 'Nginx', 'Grafana'],
    'İnfrastruktur' => ['Proxmox VE', 'Nextcloud', 'Linux', 'Ubuntu', 'Docker', 'Nginx'],
    'Tarix' => ['PHP', 'MySQL', 'Linux', 'Nginx'],
    'Platform' => ['PHP', 'Laravel', 'Vue.js', 'MySQL', 'Redis', 'Linux'],
    'Oyun' => ['PHP', 'Laravel', 'Vue.js', 'MySQL', 'Redis', 'Linux'],
];

/** Xəbər layihələrində DLE olmamalı olanlar (yayım/infra) */
$noDlePatterns = ['canlı yayım', 'yayım server', 'canlı mətn', 'mətn axını server', 'tv canlı', 'stream', 'mail server', 'proxmox', 'nextcloud', 'monitorinq', 'firewall'];

$featurePresets = [
    'broadcast' => ['RTMP/HLS axın konfiqurasiyası', 'Yayım monitorinqi', 'Ehtiyat axın (failover)', 'Gecikmə optimallaşdırması', 'Server resurs planlaması', 'Xəbərdarlıq və loglar'],
    'dle' => ['Xəbər lentəsi', 'Redaktor paneli', 'Axtarış optimallaşdırması', 'Reklam zonaları', 'Mobil uyğunlaşma', 'Keş və performans'],
    'laravel' => ['İdarə paneli', 'REST API', 'Rol əsaslı giriş', 'Hesabat modulu', 'Mobil uyğun interfeys', 'Təhlükəsizlik'],
    'infra' => ['Virtual maşınlar', 'Backup strategiyası', 'Monitorinq', 'SSL və firewall', 'Şəbəkə segmentasiyası', 'Sənədləşmə'],
    'mail' => ['SMTP/IMAP konfiqurasiyası', 'Spam filtrasiyası', 'İstifadəçi qutuları', 'Şifrələnmiş bağlantı', 'Ehtiyat nüsxə', 'Admin təlimi'],
    'mobile' => ['Android və iOS', 'Push bildiriş', 'API inteqrasiyası', 'Offline rejim', 'Təhlükəsiz giriş'],
    'erp' => ['CRM pipeline', 'Anbar idarəetməsi', 'Hesabat dashboard', 'Rol əsaslı giriş', 'API inteqrasiyaları'],
    'ecommerce' => ['Məhsul kataloqu', 'Səbət və checkout', 'Ödəniş inteqrasiyası', 'Admin panel', 'Hesabat'],
];

function matchKeywords(string $hay, array $rules): ?array
{
    $h = mb_strtolower($hay);
    foreach ($rules as $rule) {
        foreach ($rule['keys'] as $k) {
            if (str_contains($h, mb_strtolower($k))) {
                return $rule['tech'];
            }
        }
    }
    return null;
}

function shouldNotUseDle(string $hay): bool
{
    $h = mb_strtolower($hay);
    foreach ($GLOBALS['noDlePatterns'] as $p) {
        if (str_contains($h, $p)) {
            return true;
        }
    }
    return false;
}

function pickFeatures(array $tech, string $name, string $desc, string $cat): array
{
    $h = mb_strtolower($name . ' ' . $desc);
    if (preg_match('/canlı yayım|yayım server|tv canlı|canlı mətn axını|mətn axını server/i', $h)) {
        return $GLOBALS['featurePresets']['broadcast'];
    }
    if (str_contains($h, 'mail') || str_contains($h, 'poçt')) {
        return $GLOBALS['featurePresets']['mail'];
    }
    if (preg_match('/proxmox|nextcloud|vm |infrastruktur|bulud|server quruluş/i', $h)) {
        return $GLOBALS['featurePresets']['infra'];
    }
    if (in_array('Flutter', $tech, true) || $cat === 'Mobil') {
        return $GLOBALS['featurePresets']['mobile'];
    }
    if ($cat === 'ERP' || str_contains($h, 'erp') || str_contains($h, 'crm') || str_contains($h, 'anbar')) {
        return $GLOBALS['featurePresets']['erp'];
    }
    if ($cat === 'E-ticarət' || str_contains($h, 'mağaza') || str_contains($h, 'səbət')) {
        return $GLOBALS['featurePresets']['ecommerce'];
    }
    if (in_array('DLE', $tech, true)) {
        return $GLOBALS['featurePresets']['dle'];
    }
    return $GLOBALS['featurePresets']['laravel'];
}

$projects = readJson('projects.json');
$fixed = 0;
$mismatches = [];

foreach ($projects as $i => $p) {
    $name = trim($p['name'] ?? '');
    $desc = trim($p['desc'] ?? '');
    $cat = $p['category'] ?? 'Veb';
    $hay = $name . ' ' . $desc . ' ' . $cat;
    $oldTech = $p['technologies'] ?? [];

    if (isset($byName[$name])) {
        $newTech = $byName[$name];
    } elseif ($kw = matchKeywords($hay, $keywordRules)) {
        $newTech = $kw;
    } elseif ($cat === 'Xəbər' && shouldNotUseDle($hay)) {
        $newTech = ['Linux', 'Ubuntu', 'Nginx', 'Docker', 'Grafana', 'Bash'];
    } else {
        $newTech = $categoryTech[$cat] ?? $categoryTech['Veb'];
    }

    // Xəbər + yayım: DLE/PHP silinsin
    if (shouldNotUseDle($hay) && (in_array('DLE', $newTech, true) || (in_array('PHP', $newTech, true) && !str_contains(mb_strtolower($hay), 'portal') && !str_contains(mb_strtolower($hay), 'redaktor')))) {
        $newTech = matchKeywords($hay, $keywordRules) ?? ['Linux', 'Ubuntu', 'Nginx', 'Docker', 'Grafana', 'Prometheus', 'Bash'];
    }

    $newTech = array_values(array_unique($newTech));

    if ($oldTech !== $newTech) {
        $fixed++;
        if (count($mismatches) < 15) {
            $mismatches[] = "{$name}: " . implode(', ', $oldTech) . ' → ' . implode(', ', $newTech);
        }
    }

    $projects[$i]['technologies'] = $newTech;
    $projects[$i]['features'] = pickFeatures($newTech, $name, $desc, $cat);

    // Canlı yayım / server işləri səhvən «Xəbər» qategoriyasındadırsa düzəlt
    if ($cat === 'Xəbər' && shouldNotUseDle($hay)) {
        $projects[$i]['category'] = 'İnfrastruktur';
    }
}

writeJson('projects.json', $projects);

echo "Düzəldilən layihə: {$fixed} / " . count($projects) . PHP_EOL;
echo "Nümunə dəyişikliklər:\n";
foreach ($mismatches as $m) {
    echo "  - {$m}\n";
}

// Yoxlama: yayım layihələrində DLE qalmayıb
$bad = 0;
foreach ($projects as $p) {
    $h = mb_strtolower(($p['name'] ?? '') . ' ' . ($p['desc'] ?? ''));
    if ((str_contains($h, 'yayım') || str_contains($h, 'canlı')) && in_array('DLE', $p['technologies'] ?? [], true)) {
        $bad++;
        echo "XƏTA qaldı: " . $p['name'] . PHP_EOL;
    }
}
echo $bad === 0 ? "Yayım layihələrində DLE yoxdur — OK\n" : "";
