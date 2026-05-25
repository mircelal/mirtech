<?php
require dirname(__DIR__) . '/config.php';

$defaults = [
    'Tarix' => [
        'technologies' => ['PHP', 'MySQL', 'Linux', 'Nginx'],
        'features' => ['Arxiv və kataloq', 'Axtarış', 'Kateqoriyalar', 'Multimedia', 'SEO'],
        'timeline' => [
            ['title' => 'Struktur', 'desc' => 'Kontent arxitekturası', 'progress' => 100, 'status' => 'done'],
            ['title' => 'İnkişaf', 'desc' => 'Backend və UI', 'progress' => 100, 'status' => 'done'],
            ['title' => 'Kontent', 'desc' => 'Arxiv və indeks', 'progress' => 100, 'status' => 'done'],
            ['title' => 'Deploy', 'desc' => 'Hosting və SEO', 'progress' => 100, 'status' => 'done'],
        ],
        'stats' => [
            ['label' => 'Material', 'value' => '500', 'max' => 1000],
            ['label' => 'Kateqoriya', 'value' => '20', 'max' => 30],
            ['label' => 'Performans', 'value' => '88', 'max' => 100],
        ],
    ],
    'Xəbər' => [
        'technologies' => ['PHP', 'DLE', 'MySQL', 'Linux', 'Nginx'],
        'features' => ['Xəbər lentəsi', 'Redaktor paneli', 'SEO strukturu', 'Reklam zonaları', 'Mobil uyğunlaşma'],
        'timeline' => [
            ['title' => 'Analiz & UX', 'desc' => 'Wireframe və texniki tapşırıq', 'progress' => 100, 'status' => 'done'],
            ['title' => 'DLE & şablon', 'desc' => 'Modul və dizayn', 'progress' => 100, 'status' => 'done'],
            ['title' => 'Kontent & SEO', 'desc' => 'Struktur və performans', 'progress' => 100, 'status' => 'done'],
            ['title' => 'Deploy & Dəstək', 'desc' => 'Hosting, monitorinq', 'progress' => 100, 'status' => 'done'],
        ],
        'stats' => [
            ['label' => 'Səhifə performansı', 'value' => '90', 'max' => 100],
            ['label' => 'Kateqoriya', 'value' => '12', 'max' => 20],
            ['label' => 'Modul', 'value' => '8', 'max' => 10],
        ],
    ],
    'Portal' => [
        'technologies' => ['PHP', 'Laravel', 'Vue.js', 'MySQL', 'Linux'],
        'features' => ['Çoxdilli kontent', 'Redaktor paneli', 'Axtarış və filtrasiya', 'Reklam zonaları', 'SEO strukturu'],
        'timeline' => [
            ['title' => 'Analiz & UX', 'desc' => 'Wireframe və texniki tapşırıq', 'progress' => 100, 'status' => 'done'],
            ['title' => 'Backend & API', 'desc' => 'Kontent və istifadəçi modulları', 'progress' => 100, 'status' => 'done'],
            ['title' => 'Frontend', 'desc' => 'Responsive UI və performans', 'progress' => 100, 'status' => 'done'],
            ['title' => 'Deploy & Dəstək', 'desc' => 'Hosting, monitorinq', 'progress' => 100, 'status' => 'done'],
        ],
        'stats' => [
            ['label' => 'Səhifə performansı', 'value' => '92', 'max' => 100],
            ['label' => 'Gündəlik sorğu', 'value' => '45K', 'max' => 50],
            ['label' => 'Modul sayı', 'value' => '18', 'max' => 20],
        ],
    ],
    'Mobil' => [
        'technologies' => ['Kotlin', 'Flutter', 'Android', 'iOS', 'REST API', 'Linux'],
        'features' => ['Android & iOS', 'Offline sinxron', 'Push bildiriş', 'API inteqrasiyası', 'Təhlükəsiz giriş'],
        'timeline' => [
            ['title' => 'Analiz & UX', 'desc' => 'Wireframe və API müqaviləsi', 'progress' => 100, 'status' => 'done'],
            ['title' => 'Mobil inkişaf', 'desc' => 'Android / iOS / desktop', 'progress' => 100, 'status' => 'done'],
            ['title' => 'ERP inteqrasiya', 'desc' => 'REST API və test', 'progress' => 80, 'status' => 'active'],
            ['title' => 'Store & deploy', 'desc' => 'Yayım və monitorinq', 'progress' => 50, 'status' => 'pending'],
        ],
        'stats' => [
            ['label' => 'Platforma', 'value' => '5', 'max' => 6],
            ['label' => 'Modul', 'value' => '6', 'max' => 10],
            ['label' => 'Sinxron', 'value' => '95', 'max' => 100],
        ],
    ],
    'Biznes proqramı' => [
        'technologies' => ['PHP', 'MySQL', 'Linux'],
        'features' => ['Veb panel', 'CRUD əməliyyatları', 'Hesabat', 'İstifadəçi rolları', 'Mobil brauzer'],
        'timeline' => [
            ['title' => 'Tələblər', 'desc' => 'Firma proseslərinin sadələşdirilməsi', 'progress' => 100, 'status' => 'done'],
            ['title' => 'İnkişaf', 'desc' => 'Panel və modullar', 'progress' => 100, 'status' => 'done'],
            ['title' => 'Təlim', 'desc' => 'Ofis komandasına təhvil', 'progress' => 100, 'status' => 'done'],
            ['title' => 'Dəstək', 'desc' => 'Kiçik yeniləmələr', 'progress' => 100, 'status' => 'done'],
        ],
        'stats' => [
            ['label' => 'Modul', 'value' => '5', 'max' => 8],
            ['label' => 'İstifadəçi', 'value' => '15', 'max' => 50],
            ['label' => 'Tamamlanma', 'value' => '100', 'max' => 100],
        ],
    ],
    'ERP' => [
        'technologies' => ['PHP', 'Laravel', 'Vue.js', 'MySQL', 'Linux'],
        'features' => ['CRM pipeline', 'Anbar idarəetməsi', 'Hesabat dashboard', 'Rol əsaslı giriş', 'API inteqrasiyaları'],
        'timeline' => [
            ['title' => 'ERP analizi', 'desc' => 'Biznes proseslərinin modelləşdirilməsi', 'progress' => 100, 'status' => 'done'],
            ['title' => 'Core modullar', 'desc' => 'Satış, anbar, müştəri', 'progress' => 100, 'status' => 'done'],
            ['title' => 'Hesabat & BI', 'desc' => 'Qrafik panel və export', 'progress' => 80, 'status' => 'active'],
            ['title' => 'Mobil əlavə', 'desc' => 'Flutter idarə paneli', 'progress' => 30, 'status' => 'pending'],
        ],
        'stats' => [
            ['label' => 'Avtomatlaşma', 'value' => '78', 'max' => 100],
            ['label' => 'Aktiv modul', 'value' => '12', 'max' => 15],
            ['label' => 'İstifadəçi', 'value' => '240', 'max' => 300],
        ],
    ],
    'Bulud' => [
        'technologies' => ['Proxmox', 'Nextcloud', 'Linux', 'PHP', 'Python'],
        'features' => ['Virtualizasiya', 'Fayl sinxronizasiyası', 'Backup strategiyası', 'VPN & təhlükəsizlik', 'Monitorinq'],
        'timeline' => [
            ['title' => 'İnfrastruktur', 'desc' => 'Proxmox cluster', 'progress' => 100, 'status' => 'done'],
            ['title' => 'Nextcloud', 'desc' => 'Daxili bulud', 'progress' => 70, 'status' => 'active'],
            ['title' => 'Təhlükəsizlik', 'desc' => 'Firewall, SSL, 2FA', 'progress' => 50, 'status' => 'active'],
            ['title' => 'Sənədləşmə', 'desc' => 'Admin təlimi', 'progress' => 20, 'status' => 'pending'],
        ],
        'stats' => [
            ['label' => 'Uptime hədəfi', 'value' => '99.5', 'max' => 100],
            ['label' => 'VM sayı', 'value' => '24', 'max' => 30],
            ['label' => 'Saxlama (TB)', 'value' => '18', 'max' => 20],
        ],
    ],
];

$projects = readJson('projects.json');
foreach ($projects as $i => $p) {
    $cat = $p['category'] ?? 'Veb';
    $preset = $defaults[$cat] ?? $defaults['Portal'];
    $status = $p['status'] ?? 'ongoing';
    $progress = match ($status) {
        'completed' => 100,
        'ongoing' => 68,
        'started' => 35,
        default => 50,
    };
    if ($status === 'ongoing' && !empty($preset['timeline'])) {
        foreach ($preset['timeline'] as $j => $step) {
            if ($step['status'] === 'active') {
                $progress = (int)round((($j + 0.5) / count($preset['timeline'])) * 100);
                break;
            }
        }
    }

    if (empty($projects[$i]['overview'])) {
        $projects[$i]['overview'] = ($p['desc'] ?? '') . ' — MirTech tərəfindən hazırlanmış layihə.';
    }
    $projects[$i]['technologies'] = $p['technologies'] ?? $preset['technologies'];
    $projects[$i]['features'] = $p['features'] ?? $preset['features'];
    $projects[$i]['timeline'] = $p['timeline'] ?? $preset['timeline'];
    $projects[$i]['stats'] = $p['stats'] ?? $preset['stats'];
    $projects[$i]['progress_overall'] = $p['progress_overall'] ?? $progress;
    $projects[$i]['duration'] = $p['duration'] ?? match ($status) {
        'completed' => '6–12 ay',
        'ongoing' => 'Davam edir',
        default => '3–6 ay',
    };
}

writeJson('projects.json', $projects);
echo "Projects enriched.\n";
