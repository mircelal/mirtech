<?php
declare(strict_types=1);

/** Admin panel UI language (separate from public site_lang). */

$GLOBALS['_mirtech_admin_lang'] = null;
$GLOBALS['_mirtech_admin_strings'] = null;

function initAdminLang(): void
{
    if ($GLOBALS['_mirtech_admin_lang'] !== null) {
        return;
    }
    if (!empty($_GET['admin_lang']) && is_string($_GET['admin_lang'])) {
        $c = strtolower(trim($_GET['admin_lang']));
        if (isValidLang($c)) {
            $_SESSION['admin_lang'] = $c;
        }
    }
    $lang = null;
    if (!empty($_SESSION['admin_lang']) && isValidLang((string)$_SESSION['admin_lang'])) {
        $lang = (string)$_SESSION['admin_lang'];
    }
    if ($lang === null) {
        $lang = defaultLang();
    }
    $GLOBALS['_mirtech_admin_lang'] = $lang;
    $path = DATA_PATH . '/lang/admin-' . $lang . '.json';
    $defaults = adminUiDefaultStrings($lang);
    if (is_file($path)) {
        $data = json_decode(file_get_contents($path) ?: '{}', true);
        $file = is_array($data) ? $data : [];
        // JSON overrides; defaults fill keys missing from file (avoids AZ fallback when admin_lang=en).
        $GLOBALS['_mirtech_admin_strings'] = array_merge($defaults, $file);
    } else {
        $GLOBALS['_mirtech_admin_strings'] = $defaults;
    }
}

function adminLang(): string
{
    if ($GLOBALS['_mirtech_admin_lang'] === null) {
        initAdminLang();
    }
    return $GLOBALS['_mirtech_admin_lang'] ?? defaultLang();
}

function adminUiStrings(): array
{
    if ($GLOBALS['_mirtech_admin_strings'] === null) {
        initAdminLang();
    }
    return $GLOBALS['_mirtech_admin_strings'] ?? adminUiDefaultStrings(adminLang());
}

/** Admin UI translation */
function at(string $key, array $replace = []): string
{
    $strings = adminUiStrings();
    $text = $strings[$key] ?? $key;
    foreach ($replace as $k => $v) {
        $text = str_replace('{' . $k . '}', (string)$v, $text);
    }
    return $text;
}

function adminLangUrl(string $targetLang): string
{
    $uri = $_SERVER['REQUEST_URI'] ?? '/admin/';
    $path = parse_url($uri, PHP_URL_PATH) ?: '';
    $query = [];
    parse_str(parse_url($uri, PHP_URL_QUERY) ?? '', $query);
    $query['admin_lang'] = $targetLang;
    $qs = http_build_query($query);
    return $path . ($qs ? '?' . $qs : '');
}

function adminLangSwitcher(): string
{
    $html = '<div class="adm-ui-lang" role="navigation" aria-label="' . htmlspecialchars(at('lang.switch')) . '">';
    foreach (enabledLangs() as $l) {
        $code = (string)($l['code'] ?? '');
        if ($code === '') {
            continue;
        }
        $active = $code === adminLang() ? ' is-active' : '';
        $html .= '<a href="' . htmlspecialchars(adminLangUrl($code)) . '" class="adm-ui-lang-btn' . $active . '" title="' . htmlspecialchars($l['native'] ?? $code) . '">' . strtoupper(htmlspecialchars($code)) . '</a>';
    }
    $html .= '</div>';
    return $html;
}

function adminUiDefaultStrings(string $locale): array
{
    $az = [
        'lang.switch' => 'Admin dili',
        'nav.dashboard' => 'Panel',
        'nav.projects' => 'Layihələr',
        'nav.services' => 'Xidmətlər',
        'nav.technologies' => 'Texnologiyalar',
        'nav.settings' => 'Parametrlər',
        'nav.leads' => 'Müraciətlər',
        'nav.languages' => 'Dillər',
        'nav.translations' => 'Tərcümələr',
        'nav.logout' => 'Çıxış',
        'nav.menu_open' => 'Menyunu aç',
        'nav.menu_close' => 'Menyunu bağla',
        'common.save' => 'Saxla',
        'common.cancel' => 'Ləğv et',
        'common.delete' => 'Sil',
        'common.edit' => 'Redaktə',
        'common.view' => 'Bax',
        'common.add' => 'Əlavə et',
        'common.confirm_delete' => 'Silinsin?',
        'common.saved' => 'Saxlanıldı.',
        'common.yes' => 'Bəli',
        'common.no' => 'Xeyr',
        'projects.title' => 'Layihələr',
        'projects.new' => 'Yeni layihə',
        'projects.edit' => 'Layihəni redaktə et',
        'projects.all' => 'Bütün layihələr',
        'projects.saved' => 'Layihə saxlanıldı.',
        'projects.added' => 'Layihə əlavə edildi.',
        'projects.deleted' => 'Layihə silindi.',
        'projects.view_site' => 'Saytda bax',
        'projects.tab.basic' => 'Əsas',
        'projects.tab.content' => 'Məzmun',
        'projects.tab.media' => 'Media',
        'projects.tab.extra' => 'Əlavə',
        'projects.name' => 'Ad',
        'projects.category' => 'Kateqoriya',
        'projects.desc' => 'Qısa təsvir',
        'projects.overview' => 'Ətraflı (overview)',
        'projects.duration' => 'Müddət',
        'projects.features' => 'Funksiyalar',
        'projects.features_hint' => 'Hər sətirdə bir',
        'projects.status' => 'Status',
        'projects.year' => 'İl',
        'projects.url' => 'Sayt URL',
        'projects.sort' => 'Sıra',
        'projects.featured' => 'Ana səhifədə göstər',
        'projects.progress' => 'Tamamlanma %',
        'projects.technologies' => 'Texnologiyalar',
        'projects.technologies_hint' => 'Vergüllə: PHP, Laravel',
        'projects.image' => 'Şəkil',
        'projects.remove_image' => 'Şəkli sil',
        'projects.timeline' => 'İnkişaf planı',
        'projects.stats' => 'Göstəricilər',
        'projects.timeline_title' => 'Mərhələ',
        'projects.timeline_desc' => 'Təsvir',
        'projects.stats_label' => 'Etiket',
        'projects.stats_value' => 'Dəyər',
        'projects.stats_max' => 'Max',
        'projects.status.started' => 'Başlandı',
        'projects.status.ongoing' => 'Davam edir',
        'projects.status.completed' => 'Tamamlandı',
        'projects.tl.done' => 'Bitib',
        'projects.tl.active' => 'Aktiv',
        'projects.tl.pending' => 'Gözləyir',
        'projects.extra_hint' => 'İstəyə bağlı — detallı səhifə üçün',
        'projects.content_hint' => 'Hər dil üçün mətnlər',
        'projects.lang_box' => 'Hər dil üçün mətnlər',
        'common.lang_box' => 'Hər dil üçün mətnlər',
        'dashboard.projects' => 'Layihə',
        'dashboard.services' => 'Xidmət',
        'dashboard.leads' => 'Müraciət',
        'dashboard.active' => 'Aktiv layihə',
        'dashboard.recent_leads' => 'Son müraciətlər',
        'dashboard.no_leads' => 'Hələ müraciət yoxdur.',
        'table.image' => 'Şəkil',
        'table.name' => 'Ad',
        'table.status' => 'Status',
        'table.year' => 'İl',
        'table.actions' => 'Əməliyyat',
        'credit.made_by' => 'Layihəni hazırlayan',
        'credit.source' => 'Açıq mənbə şablon',
        'pagination.page' => 'Səhifə {page} / {total}',
        'pagination.total' => '{n} layihə',
    ];

    $en = [
        'lang.switch' => 'Admin language',
        'nav.dashboard' => 'Dashboard',
        'nav.projects' => 'Projects',
        'nav.services' => 'Services',
        'nav.technologies' => 'Technologies',
        'nav.settings' => 'Settings',
        'nav.leads' => 'Leads',
        'nav.languages' => 'Languages',
        'nav.translations' => 'Translations',
        'nav.logout' => 'Log out',
        'nav.menu_open' => 'Open menu',
        'nav.menu_close' => 'Close menu',
        'common.save' => 'Save',
        'common.cancel' => 'Cancel',
        'common.delete' => 'Delete',
        'common.edit' => 'Edit',
        'common.view' => 'View',
        'common.add' => 'Add',
        'common.confirm_delete' => 'Delete this item?',
        'common.saved' => 'Saved.',
        'projects.title' => 'Projects',
        'projects.new' => 'New project',
        'projects.edit' => 'Edit project',
        'projects.all' => 'All projects',
        'projects.saved' => 'Project saved.',
        'projects.added' => 'Project added.',
        'projects.deleted' => 'Project deleted.',
        'projects.view_site' => 'View on site',
        'projects.tab.basic' => 'Basic',
        'projects.tab.content' => 'Content',
        'projects.tab.media' => 'Media',
        'projects.tab.extra' => 'Extra',
        'projects.name' => 'Name',
        'projects.category' => 'Category',
        'projects.desc' => 'Short description',
        'projects.overview' => 'Overview',
        'projects.duration' => 'Duration',
        'projects.features' => 'Features',
        'projects.features_hint' => 'One per line',
        'projects.status' => 'Status',
        'projects.year' => 'Year',
        'projects.url' => 'Website URL',
        'projects.sort' => 'Sort order',
        'projects.featured' => 'Show on homepage',
        'projects.progress' => 'Progress %',
        'projects.technologies' => 'Technologies',
        'projects.technologies_hint' => 'Comma-separated',
        'projects.image' => 'Image',
        'projects.remove_image' => 'Remove image',
        'projects.timeline' => 'Timeline',
        'projects.stats' => 'Metrics',
        'projects.extra_hint' => 'Optional — for project detail page',
        'projects.content_hint' => 'Texts per language',
        'projects.lang_box' => 'Texts per language',
        'common.lang_box' => 'Texts per language',
        'dashboard.projects' => 'Projects',
        'dashboard.services' => 'Services',
        'dashboard.leads' => 'Leads',
        'dashboard.active' => 'Active projects',
        'dashboard.recent_leads' => 'Recent leads',
        'dashboard.no_leads' => 'No leads yet.',
        'table.image' => 'Image',
        'table.name' => 'Name',
        'table.status' => 'Status',
        'table.year' => 'Year',
        'table.actions' => 'Actions',
        'credit.made_by' => 'Built by',
        'credit.source' => 'Open-source template',
        'pagination.page' => 'Page {page} / {total}',
        'pagination.total' => '{n} projects',
    ];

    $es = [
        'lang.switch' => 'Idioma del admin',
        'nav.dashboard' => 'Panel',
        'nav.projects' => 'Proyectos',
        'nav.services' => 'Servicios',
        'nav.technologies' => 'Tecnologías',
        'nav.settings' => 'Ajustes',
        'nav.leads' => 'Consultas',
        'nav.languages' => 'Idiomas',
        'nav.translations' => 'Traducciones',
        'nav.logout' => 'Salir',
        'common.save' => 'Guardar',
        'common.cancel' => 'Cancelar',
        'common.delete' => 'Eliminar',
        'common.edit' => 'Editar',
        'common.view' => 'Ver',
        'projects.title' => 'Proyectos',
        'projects.new' => 'Nuevo proyecto',
        'projects.edit' => 'Editar proyecto',
        'projects.tab.basic' => 'Básico',
        'projects.tab.content' => 'Contenido',
        'projects.tab.media' => 'Media',
        'projects.tab.extra' => 'Extra',
        'projects.all' => 'Todos los proyectos',
        'projects.lang_box' => 'Textos por idioma',
        'projects.content_hint' => 'Textos por idioma',
        'common.lang_box' => 'Textos por idioma',
        'dashboard.projects' => 'Proyectos',
        'dashboard.leads' => 'Consultas',
        'credit.made_by' => 'Creado por',
        'credit.source' => 'Plantilla open source',
        'pagination.page' => 'Página {page} / {total}',
        'pagination.total' => '{n} proyectos',
    ];

    return match ($locale) {
        'en' => array_replace($az, $en),
        'es' => array_replace($az, $es),
        default => $az,
    };
}

function adminVendorCredit(): string
{
    $name = PROJECT_VENDOR_NAME;
    $url = PROJECT_REPO_URL;
    return '<div class="adm-credit">'
        . '<span class="adm-credit-label">' . htmlspecialchars(at('credit.made_by')) . '</span>'
        . '<a href="' . htmlspecialchars($url) . '" class="adm-credit-brand" target="_blank" rel="noopener noreferrer">'
        . '<i class="fa-brands fa-github" aria-hidden="true"></i> ' . htmlspecialchars($name)
        . '</a>'
        . '<span class="adm-credit-sub">' . htmlspecialchars(at('credit.source')) . '</span>'
        . '</div>';
}

function adminListUrl(string $script, array $params = []): string
{
    $lang = adminLang();
    if ($lang !== '' && $lang !== defaultLang()) {
        $params['admin_lang'] = $lang;
    }
    $qs = http_build_query($params);
    return $script . ($qs !== '' ? '?' . $qs : '');
}

function seedAdminLangFiles(): void
{
    foreach (['az', 'en', 'es'] as $code) {
        $path = DATA_PATH . '/lang/admin-' . $code . '.json';
        if (!is_file($path)) {
            file_put_contents($path, json_encode(adminUiDefaultStrings($code), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
        }
    }
}
