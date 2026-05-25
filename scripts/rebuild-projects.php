<?php
declare(strict_types=1);
require dirname(__DIR__) . '/config.php';

function project(
    int $id,
    string $name,
    string $desc,
    int $year,
    string $category,
    string $url,
    int $sort,
    bool $featured,
    string $overview,
    array $technologies,
    array $features,
    string $status = 'completed',
    string $duration = '6–12 ay'
): array {
    $progress = $status === 'completed' ? 100 : ($status === 'ongoing' ? 68 : 35);
    $timeline = [
        ['title' => 'Analiz & plan', 'desc' => 'Texniki tapşırıq və struktur', 'progress' => 100, 'status' => 'done'],
        ['title' => 'İnkişaf', 'desc' => 'Backend, frontend, inteqrasiyalar', 'progress' => $status === 'completed' ? 100 : 75, 'status' => $status === 'completed' ? 'done' : 'active'],
        ['title' => 'Test & optimallaşdırma', 'desc' => 'Yükləmə, SEO, təhlükəsizlik', 'progress' => $status === 'completed' ? 100 : 50, 'status' => $status === 'completed' ? 'done' : 'pending'],
        ['title' => 'Deploy & dəstək', 'desc' => 'Hosting, monitorinq, yeniləmələr', 'progress' => $status === 'completed' ? 100 : 30, 'status' => $status === 'completed' ? 'done' : 'pending'],
    ];
    return [
        'id' => $id,
        'name' => $name,
        'desc' => $desc,
        'status' => $status,
        'url' => $url,
        'year' => $year,
        'category' => $category,
        'image' => '',
        'sort' => $sort,
        'featured' => $featured,
        'overview' => $overview,
        'technologies' => $technologies,
        'features' => $features,
        'timeline' => $timeline,
        'stats' => [
            ['label' => 'Tamamlanma', 'value' => (string)$progress, 'max' => 100],
            ['label' => 'Modul', 'value' => (string)count($features), 'max' => 10],
            ['label' => 'İl', 'value' => (string)$year, 'max' => 2030],
        ],
        'progress_overall' => $progress,
        'duration' => $duration,
    ];
}

$dle = ['PHP', 'DLE', 'MySQL', 'Linux', 'Nginx'];
$dleFeatures = ['Xəbər lentəsi', 'Redaktor paneli', 'SEO strukturu', 'Reklam zonaları', 'Mobil uyğunlaşma'];

$projects = [
    project(1, 'mir.az', 'Elektron kitab və kitab sosial şəbəkəsi', 2020, 'Platform',
        'https://mir.az', 1, true,
        'mir.az — 8 dildə işləyən elektron kitab platforması və kitab sosial şəbəkəsi. Daxili pul sistemi, ödəniş inteqrasiyaları, oxucu icması və kitabla bağlı texnologiyalar (oxuma, kolleksiya, reytinq, müzakirə).',
        ['PHP', 'Laravel', 'Vue.js', 'MySQL', 'Redis', 'Linux'],
        ['8 dil dəstəyi', 'Elektron kitab kataloqu', 'Kitab sosial şəbəkə', 'Daxili pul və balans', 'Ödəniş sistemi', 'Oxucu profili və kolleksiya', 'Reytinq və müzakirələr', 'Kitab texnologiyaları (EPUB, oxuma rejimi)'],
    ),

    project(2, 'samogame.az', 'Oyun platforması — UCC, bazar, epin', 2025, 'Oyun',
        'https://samogame.az', 2, true,
        'samogame.az — 2025-ci ildə qurulan oyun platforması. UCC oyun pulu yüklənir, daxili bazar yeri və epin satışı ilə oyunçular üçün vahid ekosistem.',
        ['PHP', 'Laravel', 'Vue.js', 'MySQL', 'Redis', 'Linux'],
        ['UCC oyun pulu yükləmə', 'Daxili bazar yeri', 'Epin satışı', 'İstifadəçi balansı', 'Oyun kataloqu', 'Təhlükəsiz ödəniş axını'],
        'ongoing', 'Davam edir'
    ),

    project(3, 'post-media.az', 'Xəbər portalı (DLE)', 2024, 'Xəbər',
        'https://post-media.az', 3, true,
        'post-media.az — 2024-cü ildə DataLife Engine (DLE) üzərində qurulan müasir xəbər saytı. Sürətli kontent axını və redaktor iş axını.',
        $dle, $dleFeatures
    ),

    project(4, 'denmedia.az', 'Xəbər portalı (DLE)', 2024, 'Xəbər',
        'https://denmedia.az', 4, true,
        'denmedia.az — 2024-cü ildə DLE əsasında hazırlanmış xəbər portalı. Den media qrupunun rəqəmsal üzü.',
        $dle, $dleFeatures
    ),

    project(5, 'den.az', 'Xəbər portalı (DLE)', 2022, 'Xəbər',
        'https://den.az', 5, true,
        'den.az — 2022-ci ildə DLE ilə qurulan xəbər saytı. Gündəlik xəbər, analitika və multimedia kontent.',
        $dle, $dleFeatures
    ),

    project(6, 'testonline.az', 'Onlayn imtahan platforması', 2021, 'Təhsil',
        'https://testonline.az', 6, true,
        'testonline.az — PHP ilə hazırlanmış onlayn imtahan platforması. Testlər, nəticələr və istifadəçi idarəetməsi.',
        ['PHP', 'MySQL', 'JavaScript', 'Linux', 'Nginx'],
        ['Onlayn test və imtahan', 'Vaxt limiti və nəticə', 'Sual bankı', 'İstifadəçi və qrup idarəetməsi', 'Hesabat və statistika']
    ),

    project(7, 'eduroom.az', 'Təhsil platforması', 2020, 'Təhsil',
        'https://eduroom.az', 7, false,
        'eduroom.az — 2020-ci ildə qurulan təhsil platforması. Dərslər, materiallar və təhsil ekosistemi.',
        ['PHP', 'Laravel', 'MySQL', 'Linux'],
        ['Kurs və material idarəetməsi', 'İstifadəçi rolları', 'Kontent strukturu', 'Mobil uyğun interfeys']
    ),

    project(8, 'lidexeber.az', 'Xəbər portalı (DLE)', 2020, 'Xəbər',
        'https://lidexeber.az', 8, false,
        'lidexeber.az — 2020-ci ildə DLE üzərində işə salınan xəbər saytı.',
        $dle, $dleFeatures
    ),

    project(9, 'newscafe', 'Xəbər portalı (DLE)', 2018, 'Xəbər',
        'https://newscafe.az', 9, false,
        'NewsCafe — 2018-ci ildə DataLife Engine ilə qurulan xəbər saytı. Uzunmüddətli kontent arxivi və redaktor paneli.',
        $dle, $dleFeatures
    ),

    project(10, 'rednews.az', 'Xəbər portalı (DLE)', 2014, 'Xəbər',
        'https://rednews.az', 10, true,
        'rednews.az — 2014-cü ildən fəaliyyət göstərən xəbər portalı. DLE əsaslı struktur və geniş xəbər arxivi.',
        $dle, array_merge($dleFeatures, ['Uzunmüddətli arxiv'])
    ),

    project(11, 'wsemir.com', 'Xəbər və media portalı', 2010, 'Xəbər',
        'https://wsemir.com', 11, true,
        'wsemir.com — 2010-cu ildə qurulan, portfolionun ən köhnə layihələrindən biri. Xəbər və media kontenti, uzun illər davam edən texniki dəstək.',
        array_merge($dle, ['PHP']),
        array_merge($dleFeatures, ['Çoxillik arxiv', 'Media bölmələri'])
    ),

    project(12, 'pressa.az', 'Xəbər portalı (DLE)', 2019, 'Xəbər',
        'https://pressa.az', 12, false,
        'pressa.az — DLE əsasında xəbər portalı. Gündəlik pressa və analitik materiallar.',
        $dle, $dleFeatures
    ),

    project(13, 'reyd.az', 'Xəbər portalı (DLE)', 2019, 'Xəbər',
        'https://reyd.az', 13, false,
        'reyd.az — DLE ilə hazırlanmış xəbər saytı.',
        $dle, $dleFeatures
    ),

    project(14, 'ulusum.az', 'Xəbər portalı (DLE)', 2019, 'Xəbər',
        'https://ulusum.az', 14, false,
        'ulusum.az — DLE üzərində qurulan xəbər portalı.',
        $dle, $dleFeatures
    ),

    project(15, 'onews.az', 'Xəbər portalı (DLE)', 2023, 'Xəbər',
        'https://onews.az', 15, false,
        'onews.az — 2023-cü ildə DLE üzərində qurulan xəbər portalı.',
        $dle, $dleFeatures
    ),

    project(16, 'hamampro.az', 'Hamam aksesuarları e-ticarət', 2023, 'E-ticarət',
        'https://hamampro.az', 16, false,
        'hamampro.az — hamam və vanna otağı aksesuarları üçün e-ticarət saytı. Məhsul kataloqu, səbət, sifariş və ödəniş axını.',
        ['PHP', 'Laravel', 'MySQL', 'Vue.js', 'Linux'],
        ['Məhsul kataloqu', 'Səbət və sifariş', 'Ödəniş inteqrasiyası', 'Admin paneli', 'SEO və filtrlər']
    ),

    project(17, 'Lexico', 'Onlayn lüğət — AI ilə söz izahları', 2024, 'Platform',
        'https://lexico.az', 17, true,
        'Lexico — onlayn lüğət sistemi. Süni intellekt ilə təxminən 120 min söz 4 fərqli dil əsasında yenidən təhlil edilərək izah və məna yazılıb; axtarış, müqayisə və çoxdilli lüğət interfeysi.',
        ['PHP', 'Laravel', 'MySQL', 'OpenAI', 'Python', 'Redis', 'Linux'],
        ['~120 000 söz bazası', 'AI ilə izah generasiyası', '4 dil əsasında təhlil', 'Axtarış və filtrasiya', 'Söz müqayisəsi', 'Admin və redaktə paneli', 'API və performans optimallaşdırması']
    ),

    project(18, 'Güvən Dayə', 'Uşaq bağçası və gündəlik qayğı xidməti', 2017, 'Korporativ',
        'https://guvendaye.az', 18, false,
        'Güvən Dayə — uşaq bağçası və gündəlik qayğı xidmətinin korporativ veb saytı. Xidmətlər, qrup və əlaqə məlumatları, valideynlər üçün aydın struktur.',
        ['PHP', 'WordPress', 'MySQL', 'Linux', 'Nginx'],
        ['Xidmət və proqram təqdimatı', 'Qrup və yaş kateqoriyaları', 'Əlaqə və müraciət forması', 'Mobil uyğun dizayn', 'SEO']
    ),

    project(19, 'Zəka Oyunları', 'İntellektual inkişaf kursları', 2016, 'Təhsil',
        'https://zekaoyunlari.az', 19, false,
        'Zəka Oyunları — intellektual inkişaf və məntiq oyunları üzrə kursların təqdim olunduğu veb sayt. Proqramlar, qeydiyyat və məlumat bölmələri.',
        ['PHP', 'WordPress', 'MySQL', 'Linux'],
        ['Kurs və proqram kataloqu', 'Qeydiyyat və müraciət', 'Bloq və yeniliklər', 'Galeriya', 'Mobil uyğunlaşma']
    ),

    project(20, 'tiraj.az', 'Tiraj və lotereya platforması', 2019, 'Portal',
        'https://tiraj.az', 20, false,
        'tiraj.az — tiraj və lotereya axınları, real vaxt statistikaları və admin paneli.',
        ['PHP', 'Laravel', 'MySQL', 'Linux'],
        ['Tiraj cədvəlləri', 'Real vaxt statistika', 'Admin paneli', 'Mobil uyğunlaşma']
    ),

    // —— Azefinance ——
    project(23, 'Azefinance', 'Korporativ veb sayt', 2019, 'Korporativ',
        'https://azefinance.az', 23, true,
        'Azefinance — maliyyə korporasiyasının rəsmi veb saytı. Xidmətlər, komanda, əlaqə və korporativ imic.',
        ['PHP', 'Laravel', 'MySQL', 'Vue.js', 'Linux', 'Nginx'],
        ['Korporativ struktur', 'Xidmət və məhsul səhifələri', 'Əlaqə və müraciət', 'Çoxdilli dəstək', 'SEO', 'Admin paneli']
    ),

    project(24, 'Azefinance Mail Server', 'Korporativ poçt infrastrukturu', 2024, 'İnfrastruktur',
        '', 24, false,
        'Azefinance üçün xüsusi mail server — domenlər, qutular, SPF/DKIM, təhlükəsiz göndəriş və qəbul, işçi email axını.',
        ['Linux', 'Nginx', 'PHP', 'Bash'],
        ['Korporativ mail server', 'Domen və qutu idarəetməsi', 'SPF, DKIM, DMARC', 'Antispam və relay', 'Backup və monitorinq']
    ),

    project(25, 'Azefinance Bulud', 'İşçi kompüterlərinin buluda köçürülməsi', 2024, 'Bulud',
        '', 25, true,
        'Azefinance bulud serveri — bütün işçilərin kompüterlərinin mərkəzi buluda köçürülməsi: fayllar, sinxronizasiya, uzaqdan iş və vahid təhlükəsizlik siyasəti.',
        ['Proxmox', 'Nextcloud', 'Linux', 'WireGuard', 'Nginx'],
        ['Bulud server qurulması', 'İşçi PC-lərin migrasiyası', 'Fayl sinxronizasiyası', 'Uzaq masaüstü / VPN', 'Backup strategiyası', 'Rol əsaslı giriş'],
        'ongoing', 'Davam edir'
    ),

    // —— COO ekosistemi ——
    project(26, 'COO ERP', 'Backend və idarəetmə sistemi', 2024, 'ERP',
        '', 26, true,
        'COO ERP — satış, anbar, HR, maliyyə və hesabat modullarını birləşdirən mərkəzi backend və veb idarəetmə sistemi. API ilə mobil və POS tətbiqlərinə xidmət edir.',
        ['PHP', 'Laravel', 'Vue.js', 'MySQL', 'Redis', 'REST API', 'Linux'],
        ['Satış və anbar modulları', 'HR və davamiyyət', 'Maliyyə və hesabat', 'Rol əsaslı giriş', 'REST API', 'Dashboard və export'],
        'ongoing', 'Davam edir'
    ),

    project(27, 'COO POS', 'Çoxplatformalı POS və kiosk', 2024, 'Mobil',
        '', 27, true,
        'COO POS — Android, iOS, Windows, macOS və Linux kiosk rejimində satış nöqtəsi proqramı. ERP ilə real vaxt sinxronizasiya.',
        ['Kotlin', 'Flutter', 'Android', 'iOS', 'Windows Server', 'Linux', 'REST API'],
        ['Android & iOS POS', 'Windows & macOS masaüstü', 'Linux kiosk rejimi', 'Offline/online sinxron', 'Çek və ödəniş axını', 'ERP inteqrasiyası'],
        'ongoing', 'Davam edir'
    ),

    project(28, 'COO Scanner', 'Əl terminalı (Android)', 2024, 'Mobil',
        '', 28, false,
        'COO Scanner — smartfonu anbar və satış üçün əl terminalına çevirən Android tətbiqi: barkod/QR skan, sürətli əməliyyat, ERP ilə əlaqə.',
        ['Kotlin', 'Android', 'REST API'],
        ['Barkod və QR skan', 'Anbar əməliyyatları', 'Satış nöqtəsi dəstəyi', 'Offline cache', 'ERP real vaxt sinxron']
    ),

    project(29, 'COO Sales', 'Satış nümayəndəsi tətbiqi', 2024, 'Mobil',
        '', 29, false,
        'COO Sales — satış nümayəndələri üçün Android və iOS köməkçi tətqiq: sifariş, müştəri, marşrut və ERP-dən canlı məlumat.',
        ['Kotlin', 'Swift', 'Android', 'iOS', 'REST API'],
        ['Sifariş və müştəri kartı', 'Marşrut və ziyarət planı', 'Qiymət və stok sorğusu', 'Offline rejim', 'Push bildirişlər']
    ),

    project(30, 'COO HRM', 'Davamiyyət və giriş-çıxış', 2024, 'Mobil',
        '', 30, false,
        'COO HRM — işçilərin işə giriş-çıxışı və davamiyyətinin ölçülməsi: iOS (Apple) tətbiqi, geofencing və ya terminal inteqrasiyası, HR modulu ilə sinxron.',
        ['Swift', 'iOS', 'Kotlin', 'Android', 'REST API'],
        ['Giriş-çıxış qeydiyyatı', 'Davamiyyət cədvəli', 'iOS / Apple ekosistemi', 'HR modulu sinxronu', 'Hesabat və export']
    ),

    // —— Yeni layihələr ——
    project(31, 'Alban Yolu', 'Tarix portalı', 2015, 'Tarix',
        'https://albanyolu.az', 31, false,
        'Alban Yolu — Albaniya və region tarixi, hadisələr və arxiv materialları üçün tarix saytı.',
        ['PHP', 'WordPress', 'MySQL', 'Linux', 'Nginx'],
        ['Tarix məqalələri və arxiv', 'Kateqoriya və xronologiya', 'Axtarış', 'Multimedia', 'SEO']
    ),

    project(32, 'lib.az', 'Tarixi kitabxana', 2012, 'Tarix',
        'https://lib.az', 32, false,
        'lib.az — tarixi sənədlər, kitablar və arxiv fondunun onlayn kitabxana formatında təqdimatı.',
        ['PHP', 'MySQL', 'Linux', 'Nginx'],
        ['Kitab və sənəd kataloqu', 'Axtarış və filtrasiya', 'Oxuma və yükləmə', 'Kateqoriyalar', 'Admin paneli']
    ),

    project(33, 'Mountain Gunde', 'Tirmz və mağaza saytı', 2021, 'E-ticarət',
        'https://mountaingunde.az', 33, false,
        'Mountain Gunde — dağ turizmi və outdoor brendinin Tirmz inteqrasiyası və onlayn mağaza saytı.',
        ['PHP', 'Laravel', 'MySQL', 'Vue.js', 'Linux'],
        ['Mağaza kataloqu', 'Tirmz / sifariş axını', 'Məhsul və stok', 'Ödəniş inteqrasiyası', 'Mobil uyğun dizayn']
    ),

    project(34, 'Bazardüzü Climbing — Zirvə', 'Alpinizm və Bazardüzü portalı', 2022, 'Korporativ',
        'https://bazarduzuclimbing.com/', 34, true,
        'Zirvə — Bazardüzü alpinizm komandası və tədbirləri üçün rəsmi sayt (bazarduzuclimbing.com). Marşrutlar, komanda, xəbərlər və əlaqə.',
        ['PHP', 'WordPress', 'MySQL', 'Linux', 'Nginx'],
        ['Komanda və tədbirlər', 'Bazardüzü marşrutları', 'Xəbər və bloq', 'Qalereya', 'Əlaqə və müraciət']
    ),

    project(35, 'Lunexi Global', 'İşə düzəltmə platforması', 2023, 'Platform',
        'https://lunexiglobal.com', 35, false,
        'Lunexi Global — işə düzəltmə şirkəti üçün vakansiya, namizəd və işəgötürən idarəetmə platforması.',
        ['PHP', 'Laravel', 'Vue.js', 'MySQL', 'Linux'],
        ['Vakansiya elanları', 'Namizəd profili', 'İşəgötürən kabineti', 'Müraciət axını', 'Axtarış və filtrasiya', 'Admin paneli']
    ),

    project(36, 'Qafqaz Post', 'Xəbər portalı (DLE)', 2018, 'Xəbər',
        'https://qafqazpost.az', 36, false,
        'Qafqaz Post — DLE əsasında regional xəbər saytı.',
        $dle, $dleFeatures
    ),

    project(37, 'BakuInfo', 'Xəbər portalı (DLE)', 2020, 'Xəbər',
        'https://bakuinfo.az', 37, false,
        'BakuInfo — Bakı və Azərbaycan xəbərləri üçün DLE əsaslı xəbər portalı.',
        $dle, $dleFeatures
    ),

    project(38, 'Texnosan Mail', 'Buludda korporativ mail server', 2024, 'İnfrastruktur',
        '', 38, false,
        'Texnosan — korporativ mail serverin bulud infrastrukturunda qurulması: qutular, domen, təhlükəsizlik və backup.',
        ['Linux', 'Nginx', 'Nextcloud', 'Bash'],
        ['Bulud mail server', 'Domen və DNS', 'SPF/DKIM', 'İşçi qutuları', 'Backup və monitorinq']
    ),

    project(39, 'Yaxın Servis', 'Korporativ veb sayt', 2015, 'Korporativ',
        'https://yaxinservis.az', 39, false,
        'Yaxın Servis — xidmət şirkətinin korporativ veb saytı: xidmətlər, əlaqə və müraciət.',
        ['PHP', 'WordPress', 'MySQL', 'Linux'],
        ['Xidmət təqdimatı', 'Əlaqə forması', 'Mobil uyğunlaşma', 'SEO']
    ),

    project(40, 'Uraqan.com', 'Yazıçının şəxsi saytı', 2013, 'Korporativ',
        'https://uraqan.com', 40, false,
        'Uraqan.com — yazıçının şəxsi veb saytı: əsərlər, bloq, bioqrafiya və əlaqə.',
        ['PHP', 'WordPress', 'MySQL', 'Linux'],
        ['Əsər və publikasiyalar', 'Bloq', 'Bioqrafiya', 'Əlaqə', 'SEO']
    ),

    project(41, 'AzFest Mail', 'Festival üçün mail xidməti', 2023, 'İnfrastruktur',
        '', 41, false,
        'AzFest — tədbir və festival komandası üçün korporativ mail server və domen idarəetməsi.',
        ['Linux', 'Nginx', 'Bash'],
        ['Mail server qurulması', 'Festival domenləri', 'Komanda qutuları', 'Antispam', 'Texniki dəstək']
    ),

    project(42, 'Fireart Mail', 'Korporativ mail xidməti', 2022, 'İnfrastruktur',
        '', 42, false,
        'Fireart — şirkət üçün mail server: təhlükəsiz göndəriş-qəbul, qutu idarəetməsi və infrastruktur dəstəyi.',
        ['Linux', 'Nginx', 'Bash'],
        ['Korporativ mail', 'Domen inteqrasiyası', 'SSL və relay', 'Backup', 'Monitorinq']
    ),

    // —— Orta illər: firmalar üçün veb əsaslı biznes proqramları (sadə, ictimai internetdə) ——
    project(43, 'Topdan satış — anbar proqramı', 'Distribüsiya firması üçün daxili panel', 2015, 'Biznes proqramı',
        '', 43, false,
        'Topdan satış şirkəti üçün veb panel: məhsul qalığı, giriş-çıxış əməliyyatları, sadə hesabat. Ofis şəbəkəsindən brauzer ilə istifadə.',
        ['PHP', 'MySQL', 'Linux'],
        ['Məhsul və qalıq siyahısı', 'Anbar giriş-çıxışı', 'Satış qeydləri', 'PDF hesabat', 'İstifadəçi rolları']
    ),

    project(44, 'İnşaat — layihə paneli', 'Layihə və xərc izləmə', 2016, 'Biznes proqramı',
        '', 44, false,
        'İnşaat firması üçün layihələr, podratçı ödənişləri və xərc maddələrinin izləndiyi sadə idarəetmə paneli.',
        ['PHP', 'MySQL', 'Linux'],
        ['Layihə kartları', 'Xərc maddələri', 'Podratçı qeydləri', 'Status və tarixçə', 'Export']
    ),

    project(45, 'Ərzaq topdansatış — müştəri sistemi', 'Müştəri və faktura', 2017, 'Biznes proqramı',
        '', 45, false,
        'Ərzaq topdansatışı üçün müştəri bazası, sifariş qeydi və faktura çapı — gündəlik satış komandası üçün veb proqram.',
        ['PHP', 'MySQL', 'Linux'],
        ['Müştəri kartotekası', 'Sifariş qeydiyyatı', 'Faktura və çap', 'Borc izləmə', 'Sadə dashboard']
    ),

    project(46, 'Logistika — çatdırılma qeydləri', 'Marşrut və sürücü paneli', 2017, 'Biznes proqramı',
        '', 46, false,
        'Logistika firması üçün çatdırılma sifarişlərinin qeydiyyatı, status yeniləməsi və günlük hesabat — mobil brauzerdə də işləyən sadə interfeys.',
        ['PHP', 'MySQL', 'Linux'],
        ['Sifariş qeydiyyatı', 'Status: gözləyir / yolda / çatdırıldı', 'Sürücü təyini', 'Günlük siyahı', 'Çap forma']
    ),

    project(47, 'Klinika — randevu sistemi', 'Pasiyent qeydiyyatı', 2018, 'Biznes proqramı',
        '', 47, false,
        'Özəl klinika üçün onlayn və telefon randevularının qeydiyyatı, həkim təqvimi və gündəlik qəbul siyahısı.',
        ['PHP', 'MySQL', 'Linux'],
        ['Randevu təqvimi', 'Pasiyent qeydi', 'Həkim və kabinet', 'Gündəlik siyahı', 'SMS / zəng qeydi (manual)']
    ),

    project(48, 'Tikinti materialları — qiymət kataloqu', 'Satış komandası üçün köməkçi', 2018, 'Biznes proqramı',
        '', 48, false,
        'Tikinti materialları satışı üçün daxili qiymət və stok kataloqu — satış nümayəndələri tez sorğu edə bilir; mürəkkəb hesablama və ya offline rejim yoxdur.',
        ['PHP', 'MySQL', 'Linux'],
        ['Məhsul və qiymət siyahısı', 'Stok göstəricisi', 'Axtarış', 'PDF / çap', 'Admin yeniləmə']
    ),

    project(21, 'azfinance', 'Daxili bulud və maliyyə infrastruktur', 2025, 'Bulud',
        '', 21, false,
        'azfinance — daxili bulud, server və maliyyə sistemlərinin vahid infrastruktur layihəsi.',
        ['Proxmox', 'Nextcloud', 'Linux', 'PHP', 'Python'],
        ['Virtualizasiya', 'Fayl sinxronizasiyası', 'Backup strategiyası', 'VPN & təhlükəsizlik', 'Monitorinq'],
        'ongoing', 'Davam edir'
    ),

    project(22, 'Nextcloud & Proxmox', 'Daxili server və virtualizasiya', 2024, 'İnfrastruktur',
        '', 22, false,
        'Proxmox və Nextcloud əsasında özəl bulud — virtualizasiya, fayl paylaşımı və backup.',
        ['Proxmox', 'Nextcloud', 'Linux', 'Nginx'],
        ['VM idarəetməsi', 'Fayl buludu', 'Backup', 'SSL və firewall'],
        'ongoing', 'Davam edir'
    ),
];

writeJson('projects.json', $projects);
echo count($projects) . " layihə yazıldı.\n";
