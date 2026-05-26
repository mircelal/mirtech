<?php
declare(strict_types=1);

/** SEO konfiqurasiyası (settings.json → seo blokundan birləşir). */
function seoConfig(): array
{
    static $cfg = null;
    if ($cfg !== null) {
        return $cfg;
    }
    $raw = readJson('settings.json');
    $seo = is_array($raw['seo'] ?? null) ? $raw['seo'] : [];
    $contact = $raw['contact'] ?? [];

    $cfg = array_merge([
        'og_image' => '',
        'logo_url' => '',
        'google_site_verification' => '',
        'twitter_site' => '',
        'twitter_creator' => '',
        'same_as' => [],
        'founding_date' => '2010',
        'area_served' => 'AZ',
    ], $seo);

    if ($cfg['og_image'] === '' && !empty($contact['website_url'])) {
        $cfg['og_image'] = rtrim((string)$contact['website_url'], '/') . '/assets/img/og-default.svg';
    }

    return $cfg;
}

/** Saytın kanonik origin (https://mirtech.az və ya avtodetect). */
function siteOrigin(): string
{
    static $origin = null;
    if ($origin !== null) {
        return $origin;
    }

    $url = trim((string)(readJson('settings.json')['contact']['website_url'] ?? ''));
    if ($url !== '' && preg_match('#^https?://#i', $url)) {
        $origin = rtrim($url, '/');
        return $origin;
    }

    $https = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off')
        || (($_SERVER['HTTP_X_FORWARDED_PROTO'] ?? '') === 'https')
        || (($_SERVER['SERVER_PORT'] ?? '') === '443');
    $host = $_SERVER['HTTP_HOST'] ?? 'localhost';
    $base = baseUrl();

    $origin = ($https ? 'https' : 'http') . '://' . $host . ($base !== '' ? $base : '');
    return rtrim($origin, '/');
}

/** Tam URL (canonical, OG, sitemap). */
function absoluteUrl(string $path = '', ?string $lang = null): string
{
    $rel = $path === '' ? siteUrl('', $lang) : siteUrl($path, $lang);
    if (preg_match('#^https?://#i', $rel)) {
        return $rel;
    }
    $origin = siteOrigin();
    if ($rel === '' || $rel === '/') {
        return $origin . '/';
    }
    return $origin . (str_starts_with($rel, '/') ? $rel : '/' . $rel);
}

function seoTruncate(string $text, int $max = 160): string
{
    $text = trim(preg_replace('/\s+/u', ' ', strip_tags($text)) ?? '');
    if ($text === '') {
        return '';
    }
    if (mb_strlen($text) <= $max) {
        return $text;
    }
    return rtrim(mb_substr($text, 0, $max - 1)) . '…';
}

function ogLocale(string $lang): string
{
    return match ($lang) {
        'az' => 'az_AZ',
        'en' => 'en_US',
        'es' => 'es_ES',
        default => 'en_US',
    };
}

function seoPathForPage(string $pageType, array $vars): string
{
    return match ($pageType) {
        'home' => '',
        'projects' => 'projects.php',
        'technologies' => 'technologies.php',
        'calculator' => 'calculator.php',
        'project' => 'project.php?id=' . (int)($vars['project']['id'] ?? $_GET['id'] ?? 0),
        default => ltrim(str_replace('\\', '/', parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH) ?: ''), '/'),
    };
}

function seoResolveImage(array $vars, array $cfg): string
{
    $img = trim((string)($vars['img'] ?? $vars['project']['image'] ?? ''));
    if ($img !== '' && publicFileExists($img)) {
        return absoluteUrl($img);
    }
    $custom = trim((string)($cfg['og_image'] ?? ''));
    if ($custom !== '') {
        return str_starts_with($custom, 'http') ? $custom : absoluteUrl(ltrim($custom, '/'));
    }
    return absoluteUrl('assets/img/og-default.svg');
}

function seoDefaultDescription(string $pageType): string
{
    return match ($pageType) {
        'home' => t('meta.home_desc'),
        'projects' => t('meta.projects_desc'),
        'technologies' => t('meta.tech_desc'),
        'calculator' => t('meta.calc_desc'),
        'project' => t('meta.project_desc_fallback'),
        'error' => t('meta.error_desc'),
        default => t('meta.home_desc'),
    };
}

/** Controller view data → SEO konteksti. */
function buildSeoContext(string $pageType, array $vars = []): array
{
    $settings = getSettingsLocalized();
    $cfg = seoConfig();
    $lang = currentLang();
    $siteName = (string)($settings['site_name'] ?? t('site.name'));
    $tagline = trim((string)($settings['tagline'] ?? ''));

    $pageTitle = trim((string)($vars['pageTitle'] ?? $siteName));
    $description = seoTruncate((string)($vars['pageDescription'] ?? seoDefaultDescription($pageType)));

    $title = $pageTitle;
    if ($tagline !== '' && $pageType !== 'home') {
        $title .= ' — ' . $tagline;
    } elseif ($tagline !== '' && $pageType === 'home') {
        $title = $siteName . ' — ' . $tagline;
    }

    $noindex = !empty($vars['seoNoindex']) || $pageType === 'error';
    $robots = $noindex
        ? 'noindex, nofollow'
        : 'index, follow, max-image-preview:large, max-snippet:-1, max-video-preview:-1';

    $path = seoPathForPage($pageType, $vars);
    $canonical = absoluteUrl($path, $lang);
    $ogImage = seoResolveImage($vars, $cfg);
    $ogType = $pageType === 'project' ? 'article' : 'website';

    $breadcrumbs = seoBreadcrumbs($pageType, $vars, $lang);

    return [
        'pageType' => $pageType,
        'title' => $title,
        'description' => $description,
        'canonical' => $canonical,
        'robots' => $robots,
        'noindex' => $noindex,
        'lang' => $lang,
        'siteName' => $siteName,
        'og' => [
            'type' => $ogType,
            'title' => $pageTitle,
            'description' => $description,
            'url' => $canonical,
            'image' => $ogImage,
            'locale' => ogLocale($lang),
            'site_name' => $siteName,
        ],
        'twitter' => [
            'card' => 'summary_large_image',
            'title' => $pageTitle,
            'description' => $description,
            'image' => $ogImage,
            'site' => trim((string)($cfg['twitter_site'] ?? '')),
            'creator' => trim((string)($cfg['twitter_creator'] ?? '')),
        ],
        'verification' => [
            'google' => trim((string)($cfg['google_site_verification'] ?? '')),
        ],
        'breadcrumbs' => $breadcrumbs,
        'jsonLd' => seoJsonLdGraph($pageType, $vars, $canonical, $ogImage, $breadcrumbs, $cfg, $settings),
    ];
}

function applySeo(array $data, string $pageType, array $opts = []): array
{
    $data['seo'] = buildSeoContext($pageType, array_merge($data, $opts));
    return $data;
}

function seoBreadcrumbs(string $pageType, array $vars, string $lang): array
{
    $items = [
        ['name' => t('nav.home'), 'url' => absoluteUrl('', $lang)],
    ];
    if ($pageType === 'projects' || $pageType === 'project' || $pageType === 'error') {
        $items[] = ['name' => t('nav.projects'), 'url' => absoluteUrl('projects.php', $lang)];
    }
    if ($pageType === 'technologies') {
        $items[] = ['name' => t('nav.tech'), 'url' => absoluteUrl('technologies.php', $lang)];
    }
    if ($pageType === 'calculator') {
        $items[] = ['name' => t('nav.calculator'), 'url' => absoluteUrl('calculator.php', $lang)];
    }
    if ($pageType === 'project' && !empty($vars['pName'])) {
        $items[] = [
            'name' => (string)$vars['pName'],
            'url' => absoluteUrl('project.php?id=' . (int)($vars['project']['id'] ?? 0), $lang),
        ];
    }
    return $items;
}

function seoOrganizationSchema(array $cfg, array $settings): array
{
    $sc = siteContact();
    $contact = $sc['contact'];
    $origin = siteOrigin();

    $sameAs = array_values(array_filter(array_map(
        'trim',
        is_array($cfg['same_as'] ?? null) ? $cfg['same_as'] : []
    )));

    $logo = trim((string)($cfg['logo_url'] ?? ''));
    if ($logo === '') {
        $logo = absoluteUrl('assets/img/og-default.svg');
    } elseif (!str_starts_with($logo, 'http')) {
        $logo = absoluteUrl(ltrim($logo, '/'));
    }

    return [
        '@type' => 'Organization',
        '@id' => $origin . '/#organization',
        'name' => (string)($settings['site_name'] ?? 'MirTech'),
        'url' => $origin . '/',
        'logo' => [
            '@type' => 'ImageObject',
            'url' => $logo,
        ],
        'email' => (string)($contact['email'] ?? ''),
        'telephone' => (string)($contact['whatsapp'] ?? ''),
        'foundingDate' => (string)($cfg['founding_date'] ?? '2010'),
        'areaServed' => (string)($cfg['area_served'] ?? 'AZ'),
        'sameAs' => $sameAs,
    ];
}

function seoWebSiteSchema(): array
{
    $origin = siteOrigin();
    return [
        '@type' => 'WebSite',
        '@id' => $origin . '/#website',
        'url' => $origin . '/',
        'name' => (string)(getSettingsLocalized()['site_name'] ?? 'MirTech'),
        'publisher' => ['@id' => $origin . '/#organization'],
        'inLanguage' => array_map(fn($l) => (string)($l['code'] ?? ''), enabledLangs()),
        'potentialAction' => [
            '@type' => 'SearchAction',
            'target' => [
                '@type' => 'EntryPoint',
                'urlTemplate' => absoluteUrl('projects.php') . '?q={search_term_string}',
            ],
            'query-input' => 'required name=search_term_string',
        ],
    ];
}

function seoJsonLdGraph(
    string $pageType,
    array $vars,
    string $canonical,
    string $ogImage,
    array $breadcrumbs,
    array $cfg,
    array $settings
): array {
    $origin = siteOrigin();
    $graph = [
        seoOrganizationSchema($cfg, $settings),
        seoWebSiteSchema(),
        [
            '@type' => 'WebPage',
            '@id' => $canonical . '#webpage',
            'url' => $canonical,
            'name' => (string)($vars['pageTitle'] ?? $settings['site_name'] ?? 'MirTech'),
            'description' => seoTruncate((string)($vars['pageDescription'] ?? seoDefaultDescription($pageType))),
            'isPartOf' => ['@id' => $origin . '/#website'],
            'about' => ['@id' => $origin . '/#organization'],
            'inLanguage' => currentLang(),
        ],
    ];

    if (count($breadcrumbs) > 1) {
        $graph[] = [
            '@type' => 'BreadcrumbList',
            'itemListElement' => array_map(
                static fn($item, $i) => [
                    '@type' => 'ListItem',
                    'position' => $i + 1,
                    'name' => $item['name'],
                    'item' => $item['url'],
                ],
                $breadcrumbs,
                array_keys($breadcrumbs)
            ),
        ];
    }

    if ($pageType === 'project' && !empty($vars['project'])) {
        $p = $vars['project'];
        $year = (int)($p['year'] ?? 0);
        $creative = [
            '@type' => 'CreativeWork',
            '@id' => $canonical . '#project',
            'name' => (string)($vars['pName'] ?? localized($p, 'name')),
            'description' => seoTruncate((string)($vars['pDesc'] ?? localized($p, 'desc'))),
            'url' => $canonical,
            'image' => $ogImage,
            'creator' => ['@id' => $origin . '/#organization'],
        ];
        if ($year > 0) {
            $creative['datePublished'] = $year . '-01-01';
        }
        if (!empty($p['url'])) {
            $creative['sameAs'] = (string)$p['url'];
        }
        $graph[] = $creative;
    }

    if ($pageType === 'projects') {
        $graph[] = [
            '@type' => 'CollectionPage',
            '@id' => $canonical . '#collection',
            'name' => t('projects.title'),
            'description' => seoTruncate(t('meta.projects_desc')),
            'url' => $canonical,
        ];
    }

    if ($pageType === 'calculator') {
        $graph[] = [
            '@type' => 'Service',
            '@id' => $canonical . '#service',
            'name' => t('calc.title'),
            'description' => seoTruncate(t('meta.calc_desc')),
            'provider' => ['@id' => $origin . '/#organization'],
            'areaServed' => (string)($cfg['area_served'] ?? 'AZ'),
            'url' => $canonical,
        ];
    }

    return [
        '@context' => 'https://schema.org',
        '@graph' => $graph,
    ];
}

/** XML sitemap (Google + hreflang). */
function generateSitemapXml(): string
{
    $urls = [];
    $static = [
        '' => ['priority' => '1.0', 'changefreq' => 'weekly'],
        'projects.php' => ['priority' => '0.9', 'changefreq' => 'weekly'],
        'technologies.php' => ['priority' => '0.8', 'changefreq' => 'monthly'],
        'calculator.php' => ['priority' => '0.8', 'changefreq' => 'monthly'],
    ];

    foreach ($static as $path => $meta) {
        $urls[] = ['path' => $path, 'meta' => $meta];
    }

    foreach (sortByOrder(readJson('projects.json')) as $p) {
        $id = (int)($p['id'] ?? 0);
        if ($id <= 0) {
            continue;
        }
        $urls[] = [
            'path' => 'project.php?id=' . $id,
            'meta' => ['priority' => '0.7', 'changefreq' => 'monthly'],
            'lastmod' => !empty($p['year']) ? $p['year'] . '-06-01' : null,
        ];
    }

    $xml = '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
    $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:xhtml="http://www.w3.org/1999/xhtml">' . "\n";

    $langs = enabledLangs();
    $def = defaultLang();

    foreach ($urls as $entry) {
        $path = $entry['path'];
        $loc = absoluteUrl($path, $def);
        $xml .= "  <url>\n";
        $xml .= '    <loc>' . htmlspecialchars($loc, ENT_XML1) . "</loc>\n";
        if (!empty($entry['lastmod'])) {
            $xml .= '    <lastmod>' . htmlspecialchars($entry['lastmod'], ENT_XML1) . "</lastmod>\n";
        }
        $xml .= '    <changefreq>' . htmlspecialchars($entry['meta']['changefreq'], ENT_XML1) . "</changefreq>\n";
        $xml .= '    <priority>' . htmlspecialchars($entry['meta']['priority'], ENT_XML1) . "</priority>\n";

        foreach ($langs as $l) {
            $code = (string)($l['code'] ?? '');
            if ($code === '') {
                continue;
            }
            $href = absoluteUrl($path, $code);
            $xml .= '    <xhtml:link rel="alternate" hreflang="' . htmlspecialchars($code, ENT_XML1) . '" href="' . htmlspecialchars($href, ENT_XML1) . "\" />\n";
        }
        $xml .= '    <xhtml:link rel="alternate" hreflang="x-default" href="' . htmlspecialchars(absoluteUrl($path, $def), ENT_XML1) . "\" />\n";
        $xml .= "  </url>\n";
    }

    $xml .= "</urlset>\n";
    return $xml;
}

function robotsTxtContent(): string
{
    $lines = [
        'User-agent: *',
        'Allow: /',
        'Disallow: /admin/',
        'Disallow: /api.php',
        'Disallow: /api/',
        '',
        'User-agent: GPTBot',
        'Allow: /',
        '',
        'User-agent: Google-Extended',
        'Allow: /',
        '',
        'Sitemap: ' . absoluteUrl('sitemap.xml'),
    ];
    return implode("\n", $lines) . "\n";
}
