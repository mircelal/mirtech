<?php
declare(strict_types=1);

/** Flat calc.* keys for lang packs (calculator.js). */
function calcI18nFlat(string $locale): array
{
    $types = [
        'landing' => ['Landing Page', 'Tək səhifəli tanıtım', 'Landing Page', 'Página de aterrizaje'],
        'corporate' => ['Corporate site', 'Korporativ sayt', 'Corporate site', 'Sitio corporativo'],
        'ecommerce' => ['E-Commerce', 'E-Ticarət', 'E-Commerce', 'Comercio electrónico'],
        'portal' => ['Portal / Media', 'Portal / Media', 'Portal / Media', 'Portal / medios'],
        'blog' => ['Blog / Journal', 'Blog / Jurnal', 'Blog / Journal', 'Blog / revista'],
        'wordpress' => ['WordPress', 'WordPress', 'WordPress', 'WordPress'],
        'dle' => ['DLE (DataLife)', 'DLE (DataLife)', 'DLE (DataLife)', 'DLE (DataLife)'],
        'mobile_flutter' => ['Mobile (Flutter)', 'Mobil (Flutter)', 'Mobile (Flutter)', 'Móvil (Flutter)'],
        'mobile_android' => ['Android App', 'Android App', 'Android App', 'App Android'],
        'mobile_ios' => ['iOS App', 'iOS App', 'iOS App', 'App iOS'],
        'mobile_pwa' => ['PWA', 'PWA', 'PWA', 'PWA'],
        'admin_panel' => ['Admin Panel', 'İdarə Paneli', 'Admin Panel', 'Panel de administración'],
        'erp' => ['ERP System', 'ERP Sistemi', 'ERP System', 'Sistema ERP'],
        'crm' => ['CRM', 'CRM', 'CRM', 'CRM'],
        'custom_app' => ['Custom Software', 'Xüsusi Proqram', 'Custom Software', 'Software a medida'],
        'api_backend' => ['API / Backend', 'API / Backend', 'API / Backend', 'API / Backend'],
        'desktop_app' => ['Desktop App', 'Desktop Proqram', 'Desktop App', 'App de escritorio'],
        'desktop_tool' => ['Desktop Tool', 'Desktop Alət', 'Desktop Tool', 'Herramienta de escritorio'],
        'server_setup' => ['Server Setup', 'Server Quraşdırma', 'Server Setup', 'Configuración de servidor'],
        'proxmox_cloud' => ['Proxmox / VM', 'Proxmox / VM', 'Proxmox / VM', 'Proxmox / VM'],
        'nextcloud_setup' => ['Nextcloud / NAS', 'Nextcloud / NAS', 'Nextcloud / NAS', 'Nextcloud / NAS'],
        'infra_full' => ['Full infrastructure', 'Tam infrastruktur', 'Full infrastructure', 'Infraestructura completa'],
        'migration' => ['Migration', 'Köçürmə', 'Migration', 'Migración'],
    ];
    $typeDesc = [
        'landing' => ['Single-page promo', 'Tək səhifəli tanıtım', 'Single-page promo', 'Promoción de una página'],
        'corporate' => ['Company / services', 'Şirkət / xidmət', 'Company / services', 'Empresa / servicios'],
        'ecommerce' => ['Online store', 'Onlayn mağaza', 'Online store', 'Tienda en línea'],
        'portal' => ['News, content', 'Xəbər, kontent', 'News, content', 'Noticias, contenido'],
        'blog' => ['Article platform', 'Məqalə platforması', 'Article platform', 'Plataforma de artículos'],
        'wordpress' => ['CMS, WooCommerce', 'CMS, WooCommerce', 'CMS, WooCommerce', 'CMS, WooCommerce'],
        'dle' => ['Portal, news site', 'Portal, xəbər saytı', 'Portal, news site', 'Portal, sitio de noticias'],
        'mobile_flutter' => ['Android + iOS one codebase', 'Android + iOS bir kod', 'Android + iOS one codebase', 'Android + iOS un código'],
        'mobile_android' => ['Kotlin / native', 'Kotlin / native', 'Kotlin / native', 'Kotlin / nativo'],
        'mobile_ios' => ['Swift / native', 'Swift / native', 'Swift / native', 'Swift / nativo'],
        'mobile_pwa' => ['Web-based mobile', 'Veb əsaslı mobil', 'Web-based mobile', 'Móvil basado en web'],
        'admin_panel' => ['Admin dashboard', 'Admin dashboard', 'Admin dashboard', 'Panel de administración'],
        'erp' => ['Warehouse, sales, HR', 'Anbar, satış, HR', 'Warehouse, sales, HR', 'Almacén, ventas, RRHH'],
        'crm' => ['Customers, sales', 'Müştəri, satış', 'Customers, sales', 'Clientes, ventas'],
        'custom_app' => ['PHP, Python, API', 'PHP, Python, API', 'PHP, Python, API', 'PHP, Python, API'],
        'api_backend' => ['REST, integration', 'REST, inteqrasiya', 'REST, integration', 'REST, integración'],
        'desktop_app' => ['C++, Windows', 'C++, Windows', 'C++, Windows', 'C++, Windows'],
        'desktop_tool' => ['Small utility', 'Kiçik utilit', 'Small utility', 'Utilidad pequeña'],
        'server_setup' => ['Linux, Nginx, SSL', 'Linux, Nginx, SSL', 'Linux, Nginx, SSL', 'Linux, Nginx, SSL'],
        'proxmox_cloud' => ['Virtualization', 'Virtualizasiya', 'Virtualization', 'Virtualización'],
        'nextcloud_setup' => ['File cloud', 'Fayl buludu', 'File cloud', 'Nube de archivos'],
        'infra_full' => ['Docker, monitoring', 'Docker, monitorinq', 'Docker, monitoring', 'Docker, monitoreo'],
        'migration' => ['From legacy system', 'Köhnə sistemdən', 'From legacy system', 'Desde sistema antiguo'],
    ];

    $idx = match ($locale) {
        'az' => 1,
        'es' => 3,
        default => 0,
    };

    $out = [
        'calc.eyebrow' => ['Smart calculator', 'Ağıllı kalkulyator', 'Smart calculator', 'Calculadora inteligente'][$idx],
        'calc.step.0' => ['Project type', 'Layihə növü', 'Project type', 'Tipo de proyecto'][$idx],
        'calc.step.0.sub' => ['Choose project type', 'Layihə növünü seçin', 'Choose project type', 'Elige el tipo'][$idx],
        'calc.step.1' => ['Project scope', 'Layihə həcmi', 'Project scope', 'Alcance'][$idx],
        'calc.step.2' => ['Modules', 'Modullar', 'Modules', 'Módulos'][$idx],
        'calc.step.3' => ['Design & timeline', 'Dizayn & müddət', 'Design & timeline', 'Diseño y plazo'][$idx],
        'calc.step.4' => ['Free quote', 'Pulsuz təklif', 'Free quote', 'Presupuesto gratis'][$idx],
        'calc.cta.continue' => ['Continue', 'Davam et', 'Continue', 'Continuar'][$idx],
        'calc.cta.modules' => ['Modules', 'Modullar', 'Modules', 'Módulos'][$idx],
        'calc.cta.design' => ['Design', 'Dizayn', 'Design', 'Diseño'][$idx],
        'calc.cta.quote' => ['Get quote', 'Təklif al', 'Get quote', 'Obtener presupuesto'][$idx],
        'calc.cta.send' => ['Send', 'Göndər', 'Send', 'Enviar'][$idx],
        'calc.type_cat.all' => ['All', 'Hamısı', 'All', 'Todos'][$idx],
        'calc.type_cat.web' => ['Website', 'Veb sayt', 'Website', 'Sitio web'][$idx],
        'calc.type_cat.mobile' => ['Mobile', 'Mobil', 'Mobile', 'Móvil'][$idx],
        'calc.type_cat.software' => ['Software / Panel', 'Proqram / Panel', 'Software / Panel', 'Software / panel'][$idx],
        'calc.type_cat.desktop' => ['Desktop', 'Desktop', 'Desktop', 'Escritorio'][$idx],
        'calc.type_cat.infra' => ['Server', 'Server', 'Server', 'Servidor'][$idx],
        'calc.smart.default.title' => ["Let's start", 'Başlayaq', "Let's start", 'Empecemos'][$idx],
        'calc.smart.default.text' => ['Pick a category — web, mobile, software or server.', 'Layihə kateqoriyasını seçin — veb, mobil, proqram və ya server.', 'Pick a category — web, mobile, software or server.', 'Elige categoría — web, móvil, software o servidor.'][$idx],
    ];

    foreach ($types as $id => $row) {
        $out['calc.types.' . $id . '.n'] = $row[$idx];
        $out['calc.types.' . $id . '.d'] = $typeDesc[$id][$idx];
    }

  return $out;
}
