<?php
declare(strict_types=1);

/** Phrase-based AZ → EN/ES for bulk content translation. Longest matches first. */
function contentPhraseMaps(): array
{
    $en = [
        'Professional Texnologiya Həlləri' => 'Professional Technology Solutions',
        '15 illik texnologiya şirkəti' => '15 years of technology expertise',
        'Biznesiniz üçün' => 'For your business',
        'Güclü Rəqəmsal Sistemlər' => 'Powerful Digital Systems',
        '2010-cu ildən Azərbaycanda' => 'in Azerbaijan since 2010',
        'veb, bulud, mobil və server' => 'web, cloud, mobile and servers',
        'Tamamlanmış layihə' => 'Completed projects',
        'İl təcrübə' => 'Years of experience',
        'Məmnun müştəri' => 'Satisfied clients',
        'Texniki dəstək' => 'Technical support',
        '15+ İl Təcrübə' => '15+ Years of Experience',
        '2010-cu ildən bəri Azərbaycanda proqram təminatı və infrastruktur.' => 'Software and infrastructure in Azerbaijan since 2010.',
        'Web, mobil, ERP, bulud — bir komanda, tam həll.' => 'Web, mobile, ERP, cloud — one team, end-to-end solutions.',
        'Mobil Birinci' => 'Mobile First',
        'Android, iOS, Flutter — native və cross-platform.' => 'Android, iOS, Flutter — native and cross-platform.',
        'Bulud & Server' => 'Cloud & Servers',
        'Proxmox, Nextcloud, Linux, Windows — öz mərkəzlərimizdə.' => 'Proxmox, Nextcloud, Linux, Windows — in our own data centers.',
        'SSL, backup, 2FA və müasir təhlükəsizlik standartları.' => 'SSL, backups, 2FA and modern security standards.',
        'Pulsuz Məsləhət' => 'Free Consultation',
        'İdeyanızı danışın — əvvəlcə məsləhət, sonra qərar.' => 'Share your idea — consultation first, then decisions.',
        'Pulsuz hosting (1 il)' => 'Free hosting (1 year)',
        'Pulsuz domain' => 'Free domain',
        'Korporativ email' => 'Business email',
        'Mobil uyumlu dizayn' => 'Mobile-responsive design',
        'SEO hazırlığı' => 'SEO setup',
        '24/7 texniki dəstək' => '24/7 technical support',
        'Pulsuz konsultasiya' => 'Free consultation',
        'Veb & E-Ticarət' => 'Web & E-Commerce',
        'korporativ sayt, portal, e-ticarət' => 'corporate sites, portals, e-commerce',
        '₼650-dan' => 'from ₼650',
        'Mobil Tətbiqlər' => 'Mobile Apps',
        'native performans, müasir UI' => 'native performance, modern UI',
        '₼1200-dan' => 'from ₼1200',
        'Anbar, mühasibat, HR, satış — tam müəssisə idarəetməsi.' => 'Warehouse, accounting, HR, sales — full business management.',
        '₼2000-dan' => 'from ₼2000',
        'Müqavilə' => 'Custom quote',
        'Desktop & Sistem' => 'Desktop & Systems',
        'xüsusi proqramlar və inteqrasiyalar' => 'custom software and integrations',
        'Dizayn & UX' => 'Design & UX',
        'müasir interfeyslər' => 'modern interfaces',
        '₼300-dan' => 'from ₼300',
        'Elektron kitab platforması' => 'E-book platform',
        'Çoxdilli elektron kitab kataloqu, oxucu icması və daxili ödəniş sistemi ilə tam ekosistem.' => 'A full ecosystem with a multilingual e-book catalog, reader community and built-in payments.',
        'Oyun pulu və bazar sistemi' => 'In-game currency and marketplace',
        'Xəbər portalı — redaktor paneli' => 'News portal — editor dashboard',
        'İnteraz TV canlı yayım serveri' => 'Interaz TV live streaming server',
        'Xəbər arxivi axtarış düzəlişi' => 'News archive search improvements',
        'Onlayn imtahan platforması' => 'Online exam platform',
        'Təhsil platforması' => 'Education platform',
        'Mobil xəbər lentəsi optimizasiyası' => 'Mobile news feed optimization',
        'Portal yükləmə optimizasiyası' => 'Portal load optimization',
        'Reklam zonası idarə paneli' => 'Ad zone admin panel',
        'Xəbər və media portalı' => 'News and media portal',
        'DLE modul inteqrasiyası' => 'DLE module integration',
        'Canlı mətn axını serveri' => 'Live text stream server',
        'Xəbər axını və RSS optimizasiyası' => 'News feed and RSS optimization',
        'Analiz və plan' => 'Analysis & planning',
        'Texniki tapşırıq və struktur' => 'Technical specification and architecture',
        'İnkişaf' => 'Development',
        'Server, interfeys, inteqrasiyalar' => 'Server, UI, integrations',
        'Sınaq və optimallaşdırma' => 'Testing & optimization',
        'Yükləmə, axtarış optimallaşdırması, təhlükəsizlik' => 'Load, search optimization, security',
        'İstifadəyə verilmə və dəstək' => 'Launch & support',
        'Server yerləşdirməsi, monitorinq, yeniləmələr' => 'Deployment, monitoring, updates',
        'İdarə paneli' => 'Admin panel',
        'Rol əsaslı giriş' => 'Role-based access',
        'Hesabat modulu' => 'Reporting module',
        'Mobil uyğun interfeys' => 'Mobile-friendly interface',
        'Təhlükəsizlik' => 'Security',
        'Tamamlanma' => 'Completion',
        'Modul' => 'Modules',
        'İl' => 'Year',
        '6–12 ay' => '6–12 months',
        'Biznes proqramı' => 'Business software',
        'İnfrastruktur' => 'Infrastructure',
        'E-ticarət' => 'E-commerce',
        'Korporativ' => 'Corporate',
        'Təhsil' => 'Education',
        'Oyun' => 'Gaming',
        'Xəbər' => 'News',
        'Platform' => 'Platform',
        'Mobil' => 'Mobile',
        'Tarix' => 'History',
        'Veb' => 'Web',
        'Bulud' => 'Cloud',
        'Layihədə' => 'The project combines',
        'oxucular üçün' => 'for readers',
        'elektron kitab oxuma' => 'e-book reading',
        'kolleksiya yaratma' => 'collections',
        'reytinq və müzakirə' => 'ratings and discussions',
        'Daxili balans və ödəniş modulu' => 'Built-in balance and payments',
        'müəllif və nəşriyyat üçün ayrıca panellər' => 'separate panels for authors and publishers',
        'səkkiz dil dəstəyi' => 'eight-language support',
        'yüksək trafik üçün optimallaşdırma' => 'optimization for high traffic',
        'dayanıqlı server yerləşdirməsi' => 'reliable server deployment',
        'monitorinq ilə işləyir' => 'runs with monitoring',
        'Hamam aksesuarları e-ticarət' => 'Bath accessories e-commerce',
        'Onlayn lüğət — AI ilə söz izahları' => 'Online dictionary — AI word definitions',
        'Uşaq bağçası və gündəlik qayğı xidməti' => 'Kindergarten and daily care service',
        'Zəka Oyunları' => 'Brain Games',
        'Tiraj və lotereya platforması' => 'Draw and lottery platform',
        'Korporativ veb sayt' => 'Corporate website',
        'Azefinance Mail Server' => 'Azefinance Mail Server',
        'Azefinance Bulud' => 'Azefinance Cloud',
        'Backend və idarəetmə sistemi' => 'Backend and management system',
        'Çoxplatformalı POS və kiosk' => 'Cross-platform POS and kiosk',
        'Əl terminalı (Android)' => 'Handheld terminal (Android)',
        'Satış nümayəndəsi tətbiqi' => 'Sales representative app',
        'Davamiyyət və giriş-çıxış' => 'Attendance and check-in/out',
        'Rəqəmsal arxiv kataloqu' => 'Digital archive catalog',
        'Tarixi kitabxana' => 'Historical library',
        'Redaksiya iş axını paneli' => 'Editorial workflow panel',
        'Media redaktor paneli — yeniləmə' => 'Media editor panel — update',
        'Texnosan Mail' => 'Texnosan Mail',
        'Yazıçının şəxsi saytı' => "Writer's personal website",
        'Festival üçün mail xidməti' => 'Mail service for festival',
        'Fireart Mail' => 'Fireart Mail',
        'Topdan satış — anbar proqramı' => 'Wholesale — warehouse software',
        'İnşaat — layihə paneli' => 'Construction — project panel',
        'Ərzaq topdansatış — müştəri sistemi' => 'Grocery wholesale — customer system',
        'Logistika — çatdırılma qeydləri' => 'Logistics — delivery records',
        'Klinika — randevu sistemi' => 'Clinic — appointment system',
        'Tikinti materialları — qiymət kataloqu' => 'Building materials — price catalog',
        'Daxili bulud və maliyyə infrastruktur' => 'Private cloud and finance infrastructure',
        'Nextcloud & Proxmox' => 'Nextcloud & Proxmox',
        'Optimizasiya — Platform' => 'Optimization — Platform',
        'Inteqrasiya — İnfrastruktur' => 'Integration — Infrastructure',
        'POS–ERP sinxronizasiya' => 'POS–ERP synchronization',
        'Android push inteqrasiyası' => 'Android push integration',
        'HR iş axını paneli' => 'HR workflow panel',
        'Çox tenant SaaS paneli' => 'Multi-tenant SaaS panel',
        'Inteqrasiya — E-ticarət' => 'Integration — E-commerce',
        'Tarix materialları indeksləmə' => 'Historical materials indexing',
        'Muzey kolleksiya paneli' => 'Museum collection panel',
        'Üzvlük və abunə paneli' => 'Membership and subscription panel',
        'Mobil API backend inteqrasiyası' => 'Mobile API backend integration',
        'Nextcloud istifadəçi inteqrasiyası' => 'Nextcloud user integration',
        'Multimedia arxiv optimizasiyası' => 'Multimedia archive optimization',
        'Oyun pulu yükləmə modulu' => 'In-game currency top-up module',
        'Daxili bazar inteqrasiyası' => 'Internal marketplace integration',
        'Epin satış paneli' => 'E-pin sales panel',
        'API gateway inteqrasiyası' => 'API gateway integration',
        'Hesabat dashboard yeniləməsi' => 'Reporting dashboard update',
        'Offline sinxron düzəlişi' => 'Offline sync fix',
        'TV canlı yayım server inteqrasiyası' => 'TV live streaming server integration',
        'Moderasiya idarəetmə modulu' => 'Moderation management module',
        'Anbar idarə paneli' => 'Warehouse admin panel',
        'Satış CRM inteqrasiyası' => 'Sales CRM integration',
        'Səbət və checkout optimizasiyası' => 'Cart and checkout optimization',
        'Oyunçu balans sistemi' => 'Player balance system',
        'Mühasibat export modulu' => 'Accounting export module',
        'Onlayn mağaza admin paneli' => 'Online store admin panel',
        'Panel — Biznes proqramı' => 'Panel — Business software',
        'Server — Biznes proqramı' => 'Server — Business software',
        'Veb təhlükəsizlik düzəlişi' => 'Web security improvements',
        'Optimizasiya — Biznes proqramı' => 'Optimization — Business software',
        'Daxili idarə paneli' => 'Internal admin panel',
        'VPN və firewall düzəlişi' => 'VPN and firewall fix',
        'SEO struktur yeniləməsi' => 'SEO structure update',
        'Ödəniş gateway inteqrasiyası' => 'Payment gateway integration',
        'Proxmox VM köçürməsi' => 'Proxmox VM migration',
        'Server — İnfrastruktur' => 'Server — Infrastructure',
        'Optimizasiya — E-ticarət' => 'Optimization — E-commerce',
        'Docker konteyner miqrasiyası' => 'Docker container migration',
        'Inteqrasiya — Platform' => 'Integration — Platform',
        'Portal API genişləndirməsi' => 'Portal API expansion',
        'İstifadəçi portalı — modul əlavəsi' => 'User portal — module add-on',
        'Inteqrasiya — Biznes proqramı' => 'Integration — Business software',
        'Ödəniş axını optimizasiyası' => 'Payment flow optimization',
        'iOS tətbiq yeniləməsi' => 'iOS app update',
        'Server monitorinq paneli' => 'Server monitoring panel',
        'Salam — xəbər axını paneli' => 'Salam — news feed panel',
        'imkanları birləşdirilib' => 'capabilities are combined',
        'nəzərə alınıb' => 'was included in scope',
        'aparıb' => 'delivered',
        'server tərəfi' => 'server side',
        'müasir interfeys' => 'modern interface',
        'həmçinin' => 'also',
        'ayrıca panellər' => 'separate dashboards',
        'müəllif və nəşriyyat üçün' => 'for authors and publishers',
        'səkkiz dil dəstəyi' => 'eight-language support',
        'reytinq və müzakirə' => 'ratings and discussions',
        'daxili balans və ödəniş modulu' => 'built-in balance and payment module',
        'elektron kitab oxuma' => 'e-book reading',
        'kolleksiya yaratma' => 'building collections',
        'Çoxdilli' => 'Multilingual',
        'oxucu icması' => 'reader community',
        'daxili ödəniş sistemi' => 'built-in payment system',
        'tam ekosistem' => 'complete ecosystem',
        'AI inteqrasiyası' => 'AI integration',
        'Mobil uyğun interfeys' => 'Mobile-friendly interface',
        'Layihədə oxucular üçün elektron kitab oxuma, kolleksiya yaratma, reytinq və müzakirə imkanları birləşdirilib.' => 'The project combines e-book reading, collections, ratings and discussions for readers.',
        'Layihədə' => 'The project',
        'birləşdirilib' => 'are combined',
        'imkanları' => 'capabilities',
        'Daxili balans və ödəniş modulu' => 'Built-in balance and payment module',
        'müəllif və nəşriyyat üçün ayrıca panellər' => 'separate dashboards for authors and publishers',
        'yüksək trafik üçün optimallaşdırma' => 'optimization for high traffic',
        'dayanıqlı server yerləşdirməsi' => 'reliable server deployment',
        'monitorinq ilə işləyir' => 'runs with monitoring',
    ];

    $es = [
        'Professional Texnologiya Həlləri' => 'Soluciones tecnológicas profesionales',
        '15 illik texnologiya şirkəti' => '15 años de experiencia tecnológica',
        'Biznesiniz üçün' => 'Para su negocio',
        'Güclü Rəqəmsal Sistemlər' => 'Sistemas digitales potentes',
        '2010-cu ildən Azərbaycanda' => 'en Azerbaiyán desde 2010',
        'veb, bulud, mobil və server' => 'web, nube, móvil y servidores',
        'Tamamlanmış layihə' => 'Proyectos completados',
        'İl təcrübə' => 'Años de experiencia',
        'Məmnun müştəri' => 'Clientes satisfechos',
        'Texniki dəstək' => 'Soporte técnico',
        '15+ İl Təcrübə' => 'Más de 15 años de experiencia',
        '2010-cu ildən bəri Azərbaycanda proqram təminatı və infrastruktur.' => 'Software e infraestructura en Azerbaiyán desde 2010.',
        'Web, mobil, ERP, bulud — bir komanda, tam həll.' => 'Web, móvil, ERP, nube — un equipo, solución integral.',
        'Mobil Birinci' => 'Mobile primero',
        'Android, iOS, Flutter — native və cross-platform.' => 'Android, iOS, Flutter — nativo y multiplataforma.',
        'Bulud & Server' => 'Nube y servidores',
        'Proxmox, Nextcloud, Linux, Windows — öz mərkəzlərimizdə.' => 'Proxmox, Nextcloud, Linux, Windows — en nuestros propios centros de datos.',
        'SSL, backup, 2FA və müasir təhlükəsizlik standartları.' => 'SSL, copias de seguridad, 2FA y estándares modernos de seguridad.',
        'Pulsuz Məsləhət' => 'Consulta gratuita',
        'İdeyanızı danışın — əvvəlcə məsləhət, sonra qərar.' => 'Cuente su idea — primero asesoramiento, luego decisiones.',
        'Pulsuz hosting (1 il)' => 'Hosting gratuito (1 año)',
        'Pulsuz domain' => 'Dominio gratuito',
        'Korporativ email' => 'Correo corporativo',
        'Mobil uyumlu dizayn' => 'Diseño adaptable a móvil',
        'SEO hazırlığı' => 'Preparación SEO',
        '24/7 texniki dəstək' => 'Soporte técnico 24/7',
        'Pulsuz konsultasiya' => 'Consulta gratuita',
        'Veb & E-Ticarət' => 'Web y comercio electrónico',
        'korporativ sayt, portal, e-ticarət' => 'sitios corporativos, portales, e-commerce',
        '₼650-dan' => 'desde ₼650',
        'Mobil Tətbiqlər' => 'Aplicaciones móviles',
        'native performans, müasir UI' => 'rendimiento nativo, UI moderna',
        '₼1200-dan' => 'desde ₼1200',
        'Anbar, mühasibat, HR, satış — tam müəssisə idarəetməsi.' => 'Almacén, contabilidad, RRHH, ventas — gestión empresarial completa.',
        '₼2000-dan' => 'desde ₼2000',
        'Müqavilə' => 'Presupuesto a medida',
        'Desktop & Sistem' => 'Escritorio y sistemas',
        'xüsusi proqramlar və inteqrasiyalar' => 'software e integraciones a medida',
        'Dizayn & UX' => 'Diseño y UX',
        'müasir interfeyslər' => 'interfaces modernas',
        '₼300-dan' => 'desde ₼300',
        'Elektron kitab platforması' => 'Plataforma de libros electrónicos',
        'Çoxdilli elektron kitab kataloqu, oxucu icması və daxili ödəniş sistemi ilə tam ekosistem.' => 'Ecosistema completo con catálogo multilingüe, comunidad de lectores y pagos integrados.',
        'Oyun pulu və bazar sistemi' => 'Moneda de juego y marketplace',
        'Xəbər portalı — redaktor paneli' => 'Portal de noticias — panel de editor',
        'İnteraz TV canlı yayım serveri' => 'Servidor de streaming en vivo Interaz TV',
        'Onlayn imtahan platforması' => 'Plataforma de exámenes en línea',
        'Təhsil platforması' => 'Plataforma educativa',
        'Analiz və plan' => 'Análisis y planificación',
        'Texniki tapşırıq və struktur' => 'Especificación técnica y arquitectura',
        'İnkişaf' => 'Desarrollo',
        'Sınaq və optimallaşdırma' => 'Pruebas y optimización',
        'İstifadəyə verilmə və dəstək' => 'Lanzamiento y soporte',
        'İdarə paneli' => 'Panel de administración',
        'Rol əsaslı giriş' => 'Acceso basado en roles',
        'Hesabat modulu' => 'Módulo de informes',
        'Mobil uyğun interfeys' => 'Interfaz adaptable a móvil',
        'Təhlükəsizlik' => 'Seguridad',
        'Tamamlanma' => 'Finalización',
        'Modul' => 'Módulos',
        '6–12 ay' => '6–12 meses',
        'Biznes proqramı' => 'Software empresarial',
        'İnfrastruktur' => 'Infraestructura',
        'E-ticarət' => 'Comercio electrónico',
        'Korporativ' => 'Corporativo',
        'Təhsil' => 'Educación',
        'Oyun' => 'Juegos',
        'Xəbər' => 'Noticias',
        'Platform' => 'Plataforma',
        'Mobil' => 'Móvil',
        'Tarix' => 'Historia',
        'Veb' => 'Web',
        'Bulud' => 'Nube',
        'Layihədə oxucular üçün elektron kitab oxuma, kolleksiya yaratma, reytinq və müzakirə imkanları birləşdirilib.' => 'El proyecto combina lectura de e-books, colecciones, valoraciones y debates para los lectores.',
        'Layihədə' => 'En el proyecto',
        'birləşdirilib' => 'se combinan',
        'imkanları' => 'capacidades',
        'Daxili balans və ödəniş modulu' => 'Módulo interno de saldo y pagos',
        'müəllif və nəşriyyat üçün ayrıca panellər' => 'paneles separados para autores y editores',
        'yüksək trafik üçün optimallaşdırma' => 'optimización para alto tráfico',
        'dayanıqlı server yerləşdirməsi' => 'despliegue fiable en servidor',
        'monitorinq ilə işləyir' => 'funciona con monitoreo',
        'imkanları birləşdirilib' => 'las capacidades se combinan',
        'oxucular üçün' => 'para los lectores',
        'elektron kitab oxuma' => 'lectura de libros electrónicos',
        'kolleksiya yaratma' => 'creación de colecciones',
        'reytinq və müzakirə' => 'valoraciones y debates',
        'daxili balans və ödəniş modulu' => 'módulo interno de saldo y pagos',
        'müəllif və nəşriyyat üçün' => 'para autores y editores',
        'ayrıca panellər' => 'paneles separados',
        'səkkiz dil dəstəyi' => 'soporte en ocho idiomas',
    ];

    return ['en' => $en, 'es' => $es];
}

function contentWordMaps(): array
{
    $en = [
        'platforması' => 'platform',
        'sistemi' => 'system',
        'serveri' => 'server',
        'paneli' => 'panel',
        'modulu' => 'module',
        'optimizasiyası' => 'optimization',
        'inteqrasiyası' => 'integration',
        'idarəetmə' => 'management',
        'idarə' => 'admin',
        'veb sayt' => 'website',
        'tətbiqi' => 'app',
        'tətbiq' => 'app',
        'proqramı' => 'software',
        'xidməti' => 'service',
        'portalı' => 'portal',
        'axını' => 'feed',
        'redaktor' => 'editor',
        'canlı yayım' => 'live streaming',
        'arxiv' => 'archive',
        'axtarış' => 'search',
        'düzəlişi' => 'improvements',
        'imtahan' => 'exam',
        'lentəsi' => 'feed',
        'yükləmə' => 'loading',
        'zonası' => 'zone',
        'mətn' => 'text',
        'pulu' => 'currency',
        'bazar' => 'marketplace',
        'oyun' => 'game',
        'topdansatış' => 'wholesale',
        'anbar' => 'warehouse',
        'satış' => 'sales',
        'müştəri' => 'customer',
        'çatdırılma' => 'delivery',
        'klinika' => 'clinic',
        'randevu' => 'appointment',
        'tikinti' => 'construction',
        'materialları' => 'materials',
        'qiymət' => 'price',
        'kataloqu' => 'catalog',
        'sinxronizasiya' => 'sync',
        'sinxron' => 'sync',
        'yeniləməsi' => 'update',
        'yeniləmə' => 'update',
        'indeksləmə' => 'indexing',
        'koleksiya' => 'collection',
        'üzvlük' => 'membership',
        'abunə' => 'subscription',
        'mağaza' => 'store',
        'səbət' => 'cart',
        'ödəniş' => 'payment',
        'oyunçu' => 'player',
        'balans' => 'balance',
        'mühasibat' => 'accounting',
        'export' => 'export',
        'təhlükəsizlik' => 'security',
        'köçürməsi' => 'migration',
        'konteyner' => 'container',
        'miqrasiyası' => 'migration',
        'genişləndirməsi' => 'expansion',
        'əlavəsi' => 'add-on',
        'monitorinq' => 'monitoring',
        'nümayəndəsi' => 'representative',
        'davamiyyət' => 'attendance',
        'giriş-çıxış' => 'check-in/out',
        'kitabxana' => 'library',
        'festival' => 'festival',
        'yazıçının' => "writer's",
        'şəxsi' => 'personal',
        'yaxın' => 'Yaxın',
        'lüğət' => 'dictionary',
        'söz' => 'word',
        'izahları' => 'definitions',
        'uşaq' => 'child',
        'bağçası' => 'kindergarten',
        'gündəlik' => 'daily',
        'qayğı' => 'care',
        'tiraj' => 'draw',
        'lotereya' => 'lottery',
        'terminalı' => 'terminal',
        'kiosk' => 'kiosk',
        'çoxplatformalı' => 'cross-platform',
        'çox tenant' => 'multi-tenant',
        'SaaS' => 'SaaS',
        'iş axını' => 'workflow',
        'media' => 'media',
        'redaksiya' => 'editorial',
        'hamam' => 'bath',
        'aksesuarları' => 'accessories',
        'e-ticarət' => 'e-commerce',
        'zəka' => 'brain',
        'oyunları' => 'games',
        'zirvə' => 'summit',
        'düzəliş' => 'fix',
        'moderasiya' => 'moderation',
        'offline' => 'offline',
        'dashboard' => 'dashboard',
        'gateway' => 'gateway',
        'checkout' => 'checkout',
        'firewall' => 'firewall',
        'VPN' => 'VPN',
        'SEO' => 'SEO',
        'struktur' => 'structure',
        'genişləndirmə' => 'expansion',
    ];
    $es = [
        'platforması' => 'plataforma',
        'sistemi' => 'sistema',
        'serveri' => 'servidor',
        'paneli' => 'panel',
        'modulu' => 'módulo',
        'optimizasiyası' => 'optimización',
        'inteqrasiyası' => 'integración',
        'idarəetmə' => 'gestión',
        'idarə' => 'administración',
        'veb sayt' => 'sitio web',
        'tətbiqi' => 'aplicación',
        'tətbiq' => 'aplicación',
        'proqramı' => 'software',
        'xidməti' => 'servicio',
        'portalı' => 'portal',
        'axını' => 'flujo',
        'redaktor' => 'editor',
        'canlı yayım' => 'transmisión en vivo',
        'arxiv' => 'archivo',
        'axtarış' => 'búsqueda',
        'düzəlişi' => 'mejora',
        'imtahan' => 'examen',
        'lentəsi' => 'feed',
        'yükləmə' => 'carga',
        'zonası' => 'zona',
        'mətn' => 'texto',
        'pulu' => 'moneda',
        'bazar' => 'marketplace',
        'oyun' => 'juego',
        'topdansatış' => 'mayorista',
        'anbar' => 'almacén',
        'satış' => 'ventas',
        'müştəri' => 'cliente',
        'çatdırılma' => 'entrega',
        'klinika' => 'clínica',
        'randevu' => 'cita',
        'tikinti' => 'construcción',
        'materialları' => 'materiales',
        'qiymət' => 'precio',
        'kataloqu' => 'catálogo',
        'sinxronizasiya' => 'sincronización',
        'sinxron' => 'sincronización',
        'yeniləməsi' => 'actualización',
        'yeniləmə' => 'actualización',
        'indeksləmə' => 'indexación',
        'koleksiya' => 'colección',
        'üzvlük' => 'membresía',
        'abunə' => 'suscripción',
        'mağaza' => 'tienda',
        'səbət' => 'carrito',
        'ödəniş' => 'pago',
        'oyunçu' => 'jugador',
        'balans' => 'saldo',
        'mühasibat' => 'contabilidad',
        'təhlükəsizlik' => 'seguridad',
        'köçürməsi' => 'migración',
        'konteyner' => 'contenedor',
        'miqrasiyası' => 'migración',
        'genişləndirməsi' => 'expansión',
        'əlavəsi' => 'complemento',
        'monitorinq' => 'monitoreo',
        'nümayəndəsi' => 'representante',
        'davamiyyət' => 'asistencia',
        'giriş-çıxış' => 'entrada/salida',
        'kitabxana' => 'biblioteca',
        'lüğət' => 'diccionario',
        'söz' => 'palabra',
        'izahları' => 'definiciones',
        'uşaq' => 'infantil',
        'bağçası' => 'guardería',
        'gündəlik' => 'diario',
        'qayğı' => 'cuidado',
        'tiraj' => 'sorteo',
        'lotereya' => 'lotería',
        'terminalı' => 'terminal',
        'çoxplatformalı' => 'multiplataforma',
        'iş axını' => 'flujo de trabajo',
        'redaksiya' => 'editorial',
        'hamam' => 'baño',
        'aksesuarları' => 'accesorios',
        'e-ticarət' => 'comercio electrónico',
        'zəka' => 'cerebro',
        'oyunları' => 'juegos',
        'moderasiya' => 'moderación',
        'struktur' => 'estructura',
        'genişləndirmə' => 'expansión',
        'Layihədə' => 'En el proyecto',
        'oxucular' => 'lectores',
        'üçün' => 'para',
        'elektron' => 'electrónico',
        'kitab' => 'libro',
        'oxuma' => 'lectura',
        'yaratma' => 'creación',
        'reytinq' => 'valoración',
        'müzakirə' => 'debate',
        'birləşdirilib' => 'se combinan',
        'imkanları' => 'capacidades',
        'Daxili' => 'Interno',
        'daxili' => 'interno',
        'müəllif' => 'autor',
        'nəşriyyat' => 'editorial',
        'ayrıca' => 'separado',
        'panellər' => 'paneles',
        'trafik' => 'tráfico',
        'optimallaşdırma' => 'optimización',
        'yerləşdirməsi' => 'despliegue',
        'dayanıqlı' => 'fiable',
        'işləyir' => 'funciona',
        'nəzərə' => 'en cuenta',
        'alınıb' => 'considerado',
        'aparılıb' => 'realizado',
        'həyata' => 'vida',
        'keçirilib' => 'implementado',
        'çoxdilli' => 'multilingüe',
        'ekosistem' => 'ecosistema',
    ];
    return ['en' => $en, 'es' => $es];
}

function translateContentString(string $text, string $targetLang): string
{
    if ($targetLang === 'az' || trim($text) === '') {
        return $text;
    }
    $maps = contentPhraseMaps();
    $map = $maps[$targetLang] ?? [];
    uksort($map, fn($a, $b) => strlen($b) <=> strlen($a));
    $out = $text;
    foreach ($map as $from => $to) {
        $out = str_replace($from, $to, $out);
    }
    $words = contentWordMaps()[$targetLang] ?? [];
    uksort($words, fn($a, $b) => strlen($b) <=> strlen($a));
    foreach ($words as $from => $to) {
        if (str_contains($out, $from)) {
            $out = str_replace($from, $to, $out);
        }
    }
    $out = str_replace('Mobilee-friendly', 'Mobile-friendly', $out);
    $out = str_replace('Móvile primero', 'Mobile first', $out);
    $out = str_replace('Móvile ', 'Mobile ', $out);
    if ($targetLang === 'en') {
        $out = str_replace(' in Azerbaiyán ', ' in Azerbaijan ', $out);
        $out = str_replace('en Azerbaiyán', 'in Azerbaijan', $out);
    }
    if ($targetLang === 'es') {
        $out = str_replace(' en Azerbaiyán ', ' en Azerbaiyán ', $out);
        $out = str_replace('Móvile primero', 'Mobile first', $out);
    }
    return $out;
}

/** @param mixed $data */
function translateContentValue(mixed $data, string $targetLang): mixed
{
    if (is_string($data)) {
        return translateContentString($data, $targetLang);
    }
    if (!is_array($data)) {
        return $data;
    }
    if (array_is_list($data)) {
        return array_map(fn($item) => translateContentValue($item, $targetLang), $data);
    }
    $out = [];
    foreach ($data as $k => $v) {
        $out[$k] = translateContentValue($v, $targetLang);
    }
    return $out;
}

function settingsTranslationsPack(?array $settings = null): array
{
    if ($settings !== null) {
        $az = $settings['translations']['az'] ?? [];
        if (empty($az['tagline'])) {
            $az = [
                'tagline' => (string)($settings['tagline'] ?? ''),
                'hero_eyebrow' => (string)($settings['hero_eyebrow'] ?? ''),
                'hero_title' => (string)($settings['hero_title'] ?? ''),
                'hero_title_highlight' => (string)($settings['hero_title_highlight'] ?? ''),
                'hero_subtitle' => (string)($settings['hero_subtitle'] ?? ''),
                'stats' => $settings['stats'] ?? [],
                'why' => $settings['why'] ?? [],
                'included' => $settings['included'] ?? [],
            ];
        }
        return [
            'az' => $az,
            'en' => translateContentValue($az, 'en'),
            'es' => translateContentValue($az, 'es'),
        ];
    }

    $az = [
        'tagline' => 'Professional Texnologiya Həlləri',
        'hero_eyebrow' => '15 illik texnologiya şirkəti',
        'hero_title' => 'Biznesiniz üçün',
        'hero_title_highlight' => 'Güclü Rəqəmsal Sistemlər',
        'hero_subtitle' => 'WordPress, Laravel, AWS, Cloudflare, AI inteqrasiyası — veb, bulud, mobil və server. 2010-cu ildən Azərbaycanda.',
        'stats' => [
            ['value' => '150', 'suffix' => '+', 'label' => 'Tamamlanmış layihə', 'color' => 'blue'],
            ['value' => '15', 'suffix' => '+', 'label' => 'İl təcrübə', 'color' => 'teal'],
            ['value' => '98', 'suffix' => '%', 'label' => 'Məmnun müştəri', 'color' => 'amber'],
            ['value' => '24', 'suffix' => '/7', 'label' => 'Texniki dəstək', 'color' => 'purple'],
        ],
        'why' => [
            ['icon' => 'fa-award', 'color' => 'blue', 'title' => '15+ İl Təcrübə', 'desc' => '2010-cu ildən bəri Azərbaycanda proqram təminatı və infrastruktur.'],
            ['icon' => 'fa-code', 'color' => 'teal', 'title' => 'Full Stack', 'desc' => 'Web, mobil, ERP, bulud — bir komanda, tam həll.'],
            ['icon' => 'fa-mobile-screen', 'color' => 'amber', 'title' => 'Mobil Birinci', 'desc' => 'Android, iOS, Flutter — native və cross-platform.'],
            ['icon' => 'fa-server', 'color' => 'purple', 'title' => 'Bulud & Server', 'desc' => 'Proxmox, Nextcloud, Linux, Windows — öz mərkəzlərimizdə.'],
            ['icon' => 'fa-shield-halved', 'color' => 'teal', 'title' => 'Təhlükəsizlik', 'desc' => 'SSL, backup, 2FA və müasir təhlükəsizlik standartları.'],
            ['icon' => 'fa-comments', 'color' => 'gold', 'title' => 'Pulsuz Məsləhət', 'desc' => 'İdeyanızı danışın — əvvəlcə məsləhət, sonra qərar.'],
        ],
        'included' => [
            'Pulsuz hosting (1 il)',
            'Pulsuz domain',
            'Korporativ email',
            'Mobil uyumlu dizayn',
            'SEO hazırlığı',
            '24/7 texniki dəstək',
            'Pulsuz konsultasiya',
        ],
    ];

    return [
        'az' => $az,
        'en' => translateContentValue($az, 'en'),
        'es' => translateContentValue($az, 'es'),
    ];
}

function serviceTranslationsPack(array $service): array
{
    $az = [
        'title' => (string)($service['translations']['az']['title'] ?? $service['title'] ?? ''),
        'desc' => (string)($service['translations']['az']['desc'] ?? $service['desc'] ?? ''),
        'price' => (string)($service['translations']['az']['price'] ?? $service['price'] ?? ''),
    ];
    return [
        'az' => $az,
        'en' => translateContentValue($az, 'en'),
        'es' => translateContentValue($az, 'es'),
    ];
}

function projectTranslationFromAz(array $project): array
{
    $az = $project['translations']['az'] ?? null;
    if (!is_array($az) || empty($az['name'])) {
        $az = [
            'name' => (string)($project['name'] ?? ''),
            'desc' => (string)($project['desc'] ?? ''),
            'overview' => (string)($project['overview'] ?? ''),
            'category' => (string)($project['category'] ?? ''),
            'duration' => (string)($project['duration'] ?? ''),
            'features' => $project['features'] ?? [],
            'timeline' => $project['timeline'] ?? [],
            'stats' => $project['stats'] ?? [],
        ];
    }
    return [
        'az' => $az,
        'en' => translateContentValue($az, 'en'),
        'es' => translateContentValue($az, 'es'),
    ];
}

function syncEntityDefaultFields(array $entity, array $translations, string $def = 'en'): array
{
    $block = $translations[$def] ?? [];
    if (isset($block['name'])) {
        $entity['name'] = $block['name'];
    }
    if (isset($block['title'])) {
        $entity['title'] = $block['title'];
    }
    if (isset($block['desc'])) {
        $entity['desc'] = $block['desc'];
    }
    if (isset($block['overview'])) {
        $entity['overview'] = $block['overview'];
    }
    if (isset($block['category'])) {
        $entity['category'] = $block['category'];
    }
    if (isset($block['duration'])) {
        $entity['duration'] = $block['duration'];
    }
    if (isset($block['price'])) {
        $entity['price'] = $block['price'];
    }
    if (!empty($block['features'])) {
        $entity['features'] = $block['features'];
    }
    if (!empty($block['timeline'])) {
        $entity['timeline'] = $block['timeline'];
    }
    if (!empty($block['stats'])) {
        $entity['stats'] = $block['stats'];
    }
    $entity['translations'] = $translations;
    return $entity;
}

function syncSettingsDefault(array $settings, string $def = 'en'): array
{
    $tr = settingsTranslationsPack($settings);
    $settings['translations'] = $tr;
    $block = $tr[$def];
    $settings['tagline'] = $block['tagline'];
    $settings['hero_eyebrow'] = $block['hero_eyebrow'];
    $settings['hero_title'] = $block['hero_title'];
    $settings['hero_title_highlight'] = $block['hero_title_highlight'];
    $settings['hero_subtitle'] = $block['hero_subtitle'];
    $settings['stats'] = $block['stats'];
    $settings['why'] = $block['why'];
    $settings['included'] = $block['included'];
    return $settings;
}
