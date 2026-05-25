<?php
declare(strict_types=1);

return [
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
            ['title' => 'Mobil inkişaf', 'desc' => 'Android / iOS', 'progress' => 100, 'status' => 'done'],
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
    'İnfrastruktur' => [
        'technologies' => ['Proxmox', 'Nextcloud', 'Linux', 'Nginx', 'Docker'],
        'features' => ['VM idarəetməsi', 'Fayl buludu', 'Backup', 'SSL və firewall'],
        'timeline' => [
            ['title' => 'Analiz', 'desc' => 'Mövcud server audit', 'progress' => 100, 'status' => 'done'],
            ['title' => 'Quruluş', 'desc' => 'Proxmox və şəbəkə', 'progress' => 100, 'status' => 'done'],
            ['title' => 'Nextcloud', 'desc' => 'İstifadəçi və sinxron', 'progress' => 70, 'status' => 'active'],
            ['title' => 'Monitorinq', 'desc' => 'Alert və backup', 'progress' => 40, 'status' => 'pending'],
        ],
        'stats' => [
            ['label' => 'VM', 'value' => '12', 'max' => 20],
            ['label' => 'Uptime', 'value' => '99', 'max' => 100],
            ['label' => 'Backup', 'value' => '7', 'max' => 7],
        ],
    ],
    'Veb' => [
        'technologies' => ['PHP', 'Laravel', 'Vue.js', 'MySQL', 'Nginx'],
        'features' => ['Responsive dizayn', 'Admin panel', 'SEO', 'Forma inteqrasiyası', 'Çoxdillilik'],
        'timeline' => [
            ['title' => 'Dizayn', 'desc' => 'UI/UX və prototip', 'progress' => 100, 'status' => 'done'],
            ['title' => 'İnkişaf', 'desc' => 'Frontend və backend', 'progress' => 100, 'status' => 'done'],
            ['title' => 'Test', 'desc' => 'Cross-browser və mobil', 'progress' => 100, 'status' => 'done'],
            ['title' => 'Deploy', 'desc' => 'Hosting və SSL', 'progress' => 100, 'status' => 'done'],
        ],
        'stats' => [
            ['label' => 'Səhifə', 'value' => '24', 'max' => 30],
            ['label' => 'Performans', 'value' => '91', 'max' => 100],
            ['label' => 'SEO', 'value' => '85', 'max' => 100],
        ],
    ],
    'E-ticarət' => [
        'technologies' => ['PHP', 'Laravel', 'MySQL', 'Redis', 'Linux'],
        'features' => ['Səbət', 'Ödəniş inteqrasiyası', 'Anbar sync', 'Admin panel', 'Hesabat'],
        'timeline' => [
            ['title' => 'Kataloq', 'desc' => 'Məhsul və kateqoriya', 'progress' => 100, 'status' => 'done'],
            ['title' => 'Ödəniş', 'desc' => 'Bank və kart', 'progress' => 100, 'status' => 'done'],
            ['title' => 'Logistika', 'desc' => 'Çatdırılma modulu', 'progress' => 100, 'status' => 'done'],
            ['title' => 'Optimallaşdırma', 'desc' => 'Cache və SEO', 'progress' => 100, 'status' => 'done'],
        ],
        'stats' => [
            ['label' => 'Məhsul', 'value' => '1200', 'max' => 2000],
            ['label' => 'Sifariş/gün', 'value' => '85', 'max' => 100],
            ['label' => 'Konversiya', 'value' => '3.2', 'max' => 5],
        ],
    ],
    'Platform' => [
        'technologies' => ['PHP', 'Laravel', 'Vue.js', 'MySQL', 'Redis', 'Linux'],
        'features' => ['İstifadəçi hesabı', 'Ödəniş balansı', 'API', 'Moderasiya', 'Hesabat'],
        'timeline' => [
            ['title' => 'Arxitektura', 'desc' => 'Mikroservis planı', 'progress' => 100, 'status' => 'done'],
            ['title' => 'Core', 'desc' => 'Auth və balans', 'progress' => 100, 'status' => 'done'],
            ['title' => 'Marketplace', 'desc' => 'Bazar modulu', 'progress' => 100, 'status' => 'done'],
            ['title' => 'Dəstək', 'desc' => 'Monitorinq', 'progress' => 100, 'status' => 'done'],
        ],
        'stats' => [
            ['label' => 'İstifadəçi', 'value' => '8K', 'max' => 10],
            ['label' => 'API', 'value' => '42', 'max' => 50],
            ['label' => 'Uptime', 'value' => '99', 'max' => 100],
        ],
    ],
    'Oyun' => [
        'technologies' => ['PHP', 'Laravel', 'Vue.js', 'MySQL', 'Redis'],
        'features' => ['Balans sistemi', 'Epin satışı', 'Bazar yeri', 'Ödəniş axını', 'Admin panel'],
        'timeline' => [
            ['title' => 'Backend', 'desc' => 'API və balans', 'progress' => 100, 'status' => 'done'],
            ['title' => 'Bazar', 'desc' => 'Elan və təsdiq', 'progress' => 75, 'status' => 'active'],
            ['title' => 'Ödəniş', 'desc' => 'Gateway inteqrasiya', 'progress' => 60, 'status' => 'active'],
            ['title' => 'Test', 'desc' => 'Yük testi', 'progress' => 30, 'status' => 'pending'],
        ],
        'stats' => [
            ['label' => 'Tranzaksiya', 'value' => '2K', 'max' => 5],
            ['label' => 'Modul', 'value' => '6', 'max' => 10],
            ['label' => 'Tamamlanma', 'value' => '68', 'max' => 100],
        ],
    ],
];
