<?php
/**
 * Layihə desc və overview — uzun, aydın, tam Azərbaycan dilində.
 * php scripts/enrich-project-texts.php
 */
declare(strict_types=1);

require dirname(__DIR__) . '/config.php';

/** Ad əsasında xüsusi mətnlər (desc qısa, overview uzun) */
$byName = [
    'Elektron kitab platforması' => [
        'desc' => 'Çoxdilli elektron kitab kataloqu, oxucu icması və daxili ödəniş sistemi ilə tam ekosistem.',
        'overview' => 'Layihədə oxucular üçün elektron kitab oxuma, kolleksiya yaratma, reytinq və müzakirə imkanları birləşdirilib. Daxili balans və ödəniş modulu, müəllif və nəşriyyat üçün ayrıca panellər, həmçinin səkkiz dil dəstəyi nəzərə alınıb. MirTech server tərəfi, müasir interfeys və yüksək trafik üçün optimallaşdırma aparıb; sistem dayanıqlı hosting və monitorinq ilə işləyir.',
    ],
    'Oyun pulu və bazar sistemi' => [
        'desc' => 'Oyunçular üçün balans yükləmə, epin satışı və daxili bazar modulları olan platforma.',
        'overview' => 'Platforma oyun pulunun təhlükəsiz yüklənməsini, epin kodlarının satışını və istifadəçilər arasında elan bazasını bir məkanda birləşdirir. İdarə panelindən əməliyyatlar izlənilir, şübhəli ödənişlər süzülür. Hazırda bazar və ödəniş axınları üzrə genişləndirmə davam edir; mobil uyğun interfeys və xarici sistem inteqrasiyaları planlaşdırılıb.',
    ],
    'Xəbər portalı — redaktor paneli' => [
        'desc' => 'DataLife Engine əsaslı xəbər saytı: sürətli lent, redaktor paneli və axtarış motoru uyğunluğu.',
        'overview' => 'Media redaksiyası gündəlik iş axınını sürətləndirmək üçün xüsusi şablonlar, kateqoriya strukturu və reklam zonaları qurulub. Mobil oxunuş üçün yüngül səhifələr, şəkil optimallaşdırması və keş mexanizmi tətbiq olunub. Layihə tamamlanıb; redaktorlar təlim alıb və texniki dəstək müddəti ərzində kiçik yeniləmələr aparılıb.',
    ],
    'İnteraz TV canlı yayım serveri' => [
        'desc' => 'Televiziya kanalı üçün canlı yayım axınının server tərəfində qurulması və inteqrasiyası.',
        'overview' => 'Canlı yayım üçün server resursları planlaşdırılıb, axın sabitliyi və ehtiyat nüsxəsi nəzərə alınıb. Mövcud studiya və veb infrastrukturu ilə inteqrasiya edilərək gecikmə minimuma endirilib. Monitorinq panelindən yayım vəziyyəti izlənilir; nasazlıq halında avtomatik xəbərdarlıq göndərilir.',
    ],
    'Salam — xəbər axını paneli' => [
        'desc' => 'Xəbər axınının idarəsi, tez dərc və redaktor təsdiqi üçün xüsusi iş paneli.',
        'overview' => 'Redaktorlar bir neçə addımda material əlavə edib, başlıq, qısa mətn və şəkil yükləyə bilir. Axın prioritetləri və vaxt planlaması paneldən idarə olunur. Köhnə kontent arxivi axtarışla əlçatandır; sistem mobil redaktorlar üçün də rahat işləyir.',
    ],
    'Azefinance Mail Server' => [
        'desc' => 'Korporativ poçt serverinin qurulması, domenlər və təhlükəsiz göndərmə parametrləri.',
        'overview' => 'Şirkət daxili və xarici yazışmalar üçün etibarlı poçt serveri konfiqurasiya olunub. Spam filtrasiyası, şifrələnmiş bağlantı və istifadəçi qutularının kütləvi yaradılması avtomatlaşdırılıb. Sənədləşmə və admin təlimi verilib; ehtiyat nüsxə həftəlik rejimdə alınır.',
    ],
    'Azefinance Bulud' => [
        'desc' => 'İşçi kompüterlərinin və faylların korporativ bulud mühitinə köçürülməsi.',
        'overview' => 'Köhnə fayl serverlərindən müasir bulud həllinə keçid mərhələli aparılıb. İstifadəçilər sinxron qovluqlardan və uzaqdan girişdən istifadə edir. Təhlükəsizlik siyasəti, giriş icazələri və monitorinq qaydaları yazılı şəkildə təqdim olunub.',
    ],
    'COO ERP' => [
        'desc' => 'Satış, anbar, mühasibat və insan resurslarını birləşdirən müəssisə idarəetmə sistemi.',
        'overview' => 'ERP çərçivəsində satış sifarişləri, anbar qalıqları, müştəri kartları və daxili hesabatlar vahid məlumat bazasında birləşib. Rol əsaslı giriş sayəsində hər departament yalnız öz modulunu görür. Hesabat panelləri rəhbərlik üçün real vaxta yaxın məlumat verir.',
    ],
    'Topdan satış — anbar proqramı' => [
        'desc' => 'Topdan satış şirkəti üçün anbar qalığı, sifariş və çatdırılma qeydlərinin idarə paneli.',
        'overview' => 'Anbar əməkdaşları mal qəbulu və çıxışını skaner və ya panel üzərindən qeyd edir. Minimum qalıq xəbərdarlığı, müştəri sifariş tarixçəsi və çap olunan sənədlər bir sistemdən hazırlanır. Köhnə Excel cədvəlləri əvəz olunub; səhvlər azalıb.',
    ],
    'Nextcloud & Proxmox' => [
        'desc' => 'Virtual serverlər, fayl buludu və ehtiyat nüsxə ilə daxili infrastruktur.',
        'overview' => 'Proxmox üzərində virtual maşınlar ayrılıb, Nextcloud ilə fayl paylaşımı təşkil olunub. Şəbəkə, firewall və SSL sertifikatları mərhələli qurulub. İnzibati paneldən resurs istifadəsi izlənir; planlaşdırılmış texniki xidmət günləri müəyyən edilib.',
    ],
];

$categoryDesc = [
    'Xəbər' => 'Media və xəbər kontenti üçün redaktor paneli, tez dərc axını və axtarış optimallaşdırması.',
    'Veb' => 'Korporativ və ya xidmət tipli veb həll: müasir dizayn, mobil uyğunluq və idarəetmə paneli.',
    'Portal' => 'İstifadəçi qeydiyyatı, kontent bölmələri və axtarış ilə genişlənə bilən portal strukturu.',
    'E-ticarət' => 'Məhsul kataloqu, səbət, ödəniş inteqrasiyası və satış hesabatları olan onlayn ticarət həlli.',
    'Mobil' => 'Android və iOS üçün mobil tətbiq və ya proqressiv veb tətbiq; server API ilə sinxron iş.',
    'ERP' => 'Satış, anbar, müştəri və hesabat modullarını birləşdirən müəssisə idarəetmə paneli.',
    'Biznes proqramı' => 'Şirkət daxili prosesləri sadələşdirən xüsusi proqram və idarəetmə paneli.',
    'Bulud' => 'Server, virtual maşın, fayl buludu və təhlükəsizlik üzrə infrastruktur işləri.',
    'İnfrastruktur' => 'Şəbəkə, server, monitorinq və ehtiyat nüsxə üzrə texniki quruluş.',
    'Tarix' => 'Arxiv materiallarının rəqəmsal kataloqu, axtarış və kateqoriyalar.',
    'Platform' => 'Çox istifadəçili platforma: qeydiyyat, modul sistemi və miqyaslana bilən arxitektura.',
    'Oyun' => 'Oyunçu balansı, məhsul satışı və daxili bazar funksiyaları olan platforma modulları.',
];

function statusAz(string $status): string
{
    return match ($status) {
        'completed' => 'tamamlanıb',
        'ongoing' => 'hal-hazırda davam edir',
        'started' => 'başlanılıb',
        default => 'həyata keçirilib',
    };
}

function buildOverview(string $name, string $cat, string $desc, int $year, string $status): string
{
    $st = statusAz($status);
    $catLine = match ($cat) {
        'Xəbər' => 'Xəbər və media sahəsində redaktorların gündəlik işini asanlaşdırmaq, səhifələrin sürətli açılmasını və mobil oxunuş keyfiyyətini yaxşılaşdırmaq əsas məqsəd olub.',
        'Veb' => 'Veb layihədə korporativ təqdimat, etibarlı hosting və axtarış motorları üçün uyğun struktur yaradılıb.',
        'E-ticarət' => 'Onlayn satış prosesində məhsul idarəetməsi, sifariş izləmə və ödəniş təhlükəsizliyi vahid paneldən idarə olunur.',
        'Mobil' => 'Mobil tətbiqdə istifadəçi rahatlığı, bildirişlər və oflayn rejim imkanları nəzərə alınıb.',
        'ERP' => 'Müəssisə daxili satış, anbar və hesabat məlumatları bir-biri ilə uyğunlaşdırılıb.',
        'Bulud', 'İnfrastruktur' => 'Server və şəbəkə infrastrukturunun dayanıqlığı, ehtiyat nüsxə və monitorinq qaydaları təmin edilib.',
        'Platform' => 'Platforma çoxsaylı istifadəçi və modul əlavə etməyə imkan verən texniki baza ilə qurulub.',
        'Oyun' => 'Oyunçu əməliyyatlarının təhlükəsiz və sürətli icrası üçün balans və satış modulları testdən keçirilib.',
        default => 'Layihə müştəri tələblərinə uyğun planlaşdırılıb və mərhələli şəkildə həyata keçirilib.',
    };

    return "{$name} — {$desc} {$catLine} MirTech komandası analiz, inkişaf, sınaq və istifadəyə verilmə mərhələlərini aparıb. Layihə {$year}-ci ildə {$st}.";
}

function timelineAz(array $steps): array
{
    $map = [
        'Analiz & plan' => ['Analiz və plan', 'Texniki tapşırıq, struktur və iş cədvəli'],
        'İnkişaf' => ['İnkişaf', 'Server, interfeys və inteqrasiyalar'],
        'Test & optimallaşdırma' => ['Sınaq və optimallaşdırma', 'Yükləmə sürəti, təhlükəsizlik və səhvlərin aradan qaldırılması'],
        'Deploy & dəstək' => ['İstifadəyə verilmə və dəstək', 'Yerə quraşdırma, monitorinq və yeniləmələr'],
        'Analiz & UX' => ['Analiz və istifadəçi təcrübəsi', 'Vəftə və texniki tapşırıq'],
        'Backend & API' => ['Server və API', 'Məlumat bazası və proqram interfeysi'],
        'Frontend' => ['İnterfeys', 'Responsive dizayn və performans'],
        'Deploy & Dəstək' => ['İstifadəyə verilmə', 'Hosting və texniki dəstək'],
    ];
    foreach ($steps as $i => $step) {
        $title = $step['title'] ?? '';
        if (isset($map[$title])) {
            $steps[$i]['title'] = $map[$title][0];
            if (mb_strlen($step['desc'] ?? '') < 25) {
                $steps[$i]['desc'] = $map[$title][1];
            }
        }
        $d = $steps[$i]['desc'] ?? '';
        $d = str_replace(
            ['Backend', 'backend', 'Frontend', 'frontend', 'Deploy', 'deploy', 'SEO', 'Wireframe'],
            ['Server', 'server', 'İnterfeys', 'interfeys', 'Yerə quraşdırma', 'yerə quraşdırma', 'axtarış optimallaşdırması', 'ekran sxemi'],
            $d
        );
        $steps[$i]['desc'] = $d;
    }
    return $steps;
}

$projects = readJson('projects.json');
$updated = 0;

foreach ($projects as $i => $p) {
    $name = trim($p['name'] ?? '');
    $cat = $p['category'] ?? 'Veb';
    $year = (int)($p['year'] ?? date('Y'));
    $status = $p['status'] ?? 'completed';

    if (isset($byName[$name])) {
        $projects[$i]['desc'] = $byName[$name]['desc'];
        $projects[$i]['overview'] = $byName[$name]['overview'];
        $updated++;
    } else {
        $shortDesc = $categoryDesc[$cat] ?? $categoryDesc['Veb'];
        $curDesc = trim($p['desc'] ?? '');
        $needsDesc = mb_strlen($curDesc) < 55
            || $curDesc === $name
            || str_contains($curDesc, '(DLE)')
            || preg_match('/^(inteqrasiya|optimizasiya|duzelis|server)\s*—/iu', $curDesc);
        if ($needsDesc) {
            $first = mb_strtolower(mb_substr($shortDesc, 0, 1)) . mb_substr($shortDesc, 1);
            $projects[$i]['desc'] = $name . ' — ' . $first;
            $updated++;
        }
        $curOverview = trim($p['overview'] ?? '');
        if (mb_strlen($curOverview) < 120 || str_contains($curOverview, 'MirTech tərəfindən həyata keçirilmiş')) {
            $projects[$i]['overview'] = buildOverview(
                $name,
                $cat,
                $projects[$i]['desc'],
                $year,
                $status
            );
            $updated++;
        }
    }

    if (!empty($projects[$i]['timeline'])) {
        $projects[$i]['timeline'] = timelineAz($projects[$i]['timeline']);
    }
}

function azPolish(string $s): string
{
    $repl = [
        'Admin panel' => 'İdarə paneli',
        'admin panel' => 'idarə paneli',
        '(backup)' => '',
        ' backup' => ' ehtiyat nüsxəsi',
        'Hosting' => 'Server yerləşdirməsi',
        'hosting' => 'server yerləşdirməsi',
        'Responsive' => 'Uyğunlaşan',
        'responsive' => 'uyğunlaşan',
        ' API ' => ' proqram interfeysi ',
        'MirTech komandası' => 'MirTech komandası',
    ];
    return str_replace(array_keys($repl), array_values($repl), $s);
}

foreach ($projects as $i => $p) {
    $projects[$i]['desc'] = azPolish($projects[$i]['desc'] ?? '');
    $projects[$i]['overview'] = azPolish($projects[$i]['overview'] ?? '');
    if (!empty($projects[$i]['timeline'])) {
        foreach ($projects[$i]['timeline'] as $j => $step) {
            $projects[$i]['timeline'][$j]['desc'] = azPolish($step['desc'] ?? '');
        }
    }
}

writeJson('projects.json', $projects);
echo "Yenilənən sahələr: təxminən {$updated} layihədə desc/overview/timeline\n";
echo "Cəmi: " . count($projects) . " layihə\n";
