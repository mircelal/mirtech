<?php
declare(strict_types=1);

/** Extra calc.* keys for calculator.js (mods, scopes, deadlines, extras, smart tips). */
function calcI18nExtended(string $locale): array
{
    $idx = match ($locale) {
        'az' => 1,
        'es' => 3,
        default => 0,
    };
    $p = static fn(array $row): string => $row[$idx] ?? $row[0];

    $out = [];

    $mcat = [
        'all' => ['All', 'Hamısı', 'Todos'],
        'ui' => ['UI / Panel', 'UI / Panel', 'UI / Panel'],
        'shop' => ['Commerce', 'Ticarət', 'Comercio'],
        'erp' => ['ERP / CRM', 'ERP / CRM', 'ERP / CRM'],
        'mobile' => ['Mobile', 'Mobil', 'Móvil'],
        'int' => ['Integration', 'İnteqrasiya', 'Integración'],
        'infra' => ['Infrastructure', 'İnfrastruktur', 'Infraestructura'],
    ];
    foreach ($mcat as $id => $row) {
        $out['calc.mcat.' . $id . '.n'] = $p($row);
    }

    $modNames = [
        'admin' => ['Admin Panel', 'Admin Panel', 'Panel de administración'],
        'search' => ['Search', 'Axtarış', 'Búsqueda'],
        'auth' => ['Login / Roles', 'Login / Rol', 'Login / Roles'],
        'cart' => ['Cart', 'Səbət', 'Carrito'],
        'payment' => ['Payments', 'Ödəniş', 'Pagos'],
        'crm_m' => ['CRM Module', 'CRM Modulu', 'Módulo CRM'],
        'whouse' => ['Warehouse', 'Anbar', 'Almacén'],
        'account' => ['Accounting', 'Mühasibat', 'Contabilidad'],
        'sales' => ['Sales', 'Satış', 'Ventas'],
        'report' => ['Reports', 'Hesabat', 'Informes'],
        'blog_m' => ['Blog / News', 'Blog / Xəbər', 'Blog / Noticias'],
        'slider' => ['Slider', 'Slider', 'Slider'],
        'chat' => ['Live support', 'Canlı dəstək', 'Soporte en vivo'],
        'api' => ['API Integration', 'API İnteqrasiya', 'Integración API'],
        'push' => ['Push notifications', 'Push bildiriş', 'Notificaciones push'],
        'maps' => ['Maps', 'Xəritə', 'Mapas'],
        'gana' => ['Analytics', 'Analytics', 'Analytics'],
        'monitor' => ['Monitoring', 'Monitorinq', 'Monitoreo'],
        'backup_infra' => ['Backup', 'Backup', 'Copia de seguridad'],
        'docker_extra' => ['Docker', 'Docker', 'Docker'],
        'vpn' => ['VPN / WireGuard', 'VPN / WireGuard', 'VPN / WireGuard'],
        'ssl_infra' => ['SSL / WAF', 'SSL / WAF', 'SSL / WAF'],
        'twofa' => ['2FA', '2FA', '2FA'],
        'invoice' => ['Invoice PDF', 'Faktura PDF', 'Factura PDF'],
    ];
    $modDesc = [
        'admin' => ['Content / management', 'Kontent / idarəetmə', 'Contenido / gestión'],
        'search' => ['Smart filter', 'Smart filter', 'Filtro inteligente'],
        'auth' => ['Users & permissions', 'İstifadəçi, icazə', 'Usuarios y permisos'],
        'cart' => ['E-commerce', 'E-ticarət', 'E-commerce'],
        'payment' => ['Bank, card, e-wallet', 'Bank, kart, E-manat', 'Banco, tarjeta'],
        'crm_m' => ['Lead, pipeline', 'Lead, pipeline', 'Lead, pipeline'],
        'whouse' => ['Stock, inventory', 'Stok, inventar', 'Stock, inventario'],
        'account' => ['Income / expenses', 'Gəlir / xərc', 'Ingresos / gastos'],
        'sales' => ['Orders, contracts', 'Sifariş, müqavilə', 'Pedidos, contratos'],
        'report' => ['Dashboard, export', 'Dashboard, export', 'Panel, exportar'],
        'blog_m' => ['Categories, comments', 'Kateqoriya, şərh', 'Categorías, comentarios'],
        'slider' => ['Banner', 'Banner', 'Banner'],
        'chat' => ['WhatsApp, chat', 'WhatsApp, chat', 'WhatsApp, chat'],
        'api' => ['Third-party', '3-cü tərəf', 'Terceros'],
        'push' => ['FCM / APNs', 'FCM / APNs', 'FCM / APNs'],
        'maps' => ['Google Maps', 'Google Maps', 'Google Maps'],
        'gana' => ['GA4, events', 'GA4, event', 'GA4, eventos'],
        'monitor' => ['Grafana, uptime', 'Grafana, uptime', 'Grafana, uptime'],
        'backup_infra' => ['Automated backup', 'Avtomatik yedək', 'Respaldo automático'],
        'docker_extra' => ['Containers', 'Konteyner', 'Contenedores'],
        'vpn' => ['Remote access', 'Uzaq giriş', 'Acceso remoto'],
        'ssl_infra' => ['HTTPS, security', 'HTTPS, təhlükəsizlik', 'HTTPS, seguridad'],
        'twofa' => ['SMS / TOTP', 'SMS / TOTP', 'SMS / TOTP'],
        'invoice' => ['Invoicing', 'Hesab-faktura', 'Facturación'],
    ];
    foreach ($modNames as $id => $row) {
        $out['calc.mods.' . $id . '.n'] = $p($row);
        $out['calc.mods.' . $id . '.d'] = $p($modDesc[$id]);
    }

    $tier = [
        'std' => ['Standard UI', 'Standart UI', 'UI estándar'],
        'pro' => ['Custom design (+30%)', 'Xüsusi dizayn (+30%)', 'Diseño personalizado (+30%)'],
        'prem' => ['Premium UX (+60%)', 'Premium UX (+60%)', 'UX premium (+60%)'],
    ];
    foreach ($tier as $id => $row) {
        $out['calc.tier.' . $id . '.n'] = $p($row);
    }
    $tierMob = [
        'std' => ['Standard mobile UI', 'Standart mobil UI', 'UI móvil estándar'],
        'pro' => ['Custom design (+35%)', 'Xüsusi dizayn (+35%)', 'Diseño personalizado (+35%)'],
        'prem' => ['Premium animation (+65%)', 'Premium animasiya (+65%)', 'Animación premium (+65%)'],
    ];
    foreach ($tierMob as $id => $row) {
        $out['calc.tier_mobile.' . $id . '.n'] = $p($row);
    }
    $tierSoft = [
        'std' => ['Standard panel', 'Standart panel', 'Panel estándar'],
        'pro' => ['Custom dashboard (+30%)', 'Xüsusi dashboard (+30%)', 'Panel personalizado (+30%)'],
        'prem' => ['Enterprise UX (+55%)', 'Korporativ UX (+55%)', 'UX corporativo (+55%)'],
    ];
    foreach ($tierSoft as $id => $row) {
        $out['calc.tier_software.' . $id . '.n'] = $p($row);
    }
    $tierInfra = [
        'std' => ['Standard setup', 'Standart quruluş', 'Configuración estándar'],
        'pro' => ['HA + docs (+25%)', 'HA + sənədləşmə (+25%)', 'HA + documentación (+25%)'],
        'prem' => ['Full outsource (+50%)', 'Tam outsource (+50%)', 'Externalización total (+50%)'],
    ];
    foreach ($tierInfra as $id => $row) {
        $out['calc.tier_infra.' . $id . '.n'] = $p($row);
    }

    $deadline = [
        'std' => ['30–45 days', '30–45 gün', '30–45 días'],
        'fast' => ['15–30 days (+18%)', '15–30 gün (+18%)', '15–30 días (+18%)'],
        'urgent' => ['7–15 days (+40%)', '7–15 gün (+40%)', '7–15 días (+40%)'],
    ];
    foreach ($deadline as $id => $row) {
        $out['calc.deadline.' . $id . '.n'] = $p($row);
    }
    $deadlineMob = [
        'std' => ['45–60 days', '45–60 gün', '45–60 días'],
        'fast' => ['30–45 days (+15%)', '30–45 gün (+15%)', '30–45 días (+15%)'],
        'urgent' => ['20–30 days (+35%)', '20–30 gün (+35%)', '20–30 días (+35%)'],
    ];
    foreach ($deadlineMob as $id => $row) {
        $out['calc.deadline_mobile.' . $id . '.n'] = $p($row);
    }
    $deadlineSoft = [
        'std' => ['60–90 days', '60–90 gün', '60–90 días'],
        'fast' => ['45–60 days (+12%)', '45–60 gün (+12%)', '45–60 días (+12%)'],
        'urgent' => ['30–45 days (+28%)', '30–45 gün (+28%)', '30–45 días (+28%)'],
    ];
    foreach ($deadlineSoft as $id => $row) {
        $out['calc.deadline_software.' . $id . '.n'] = $p($row);
    }
    $deadlineInfra = [
        'std' => ['3–7 days', '3–7 gün', '3–7 días'],
        'fast' => ['1–3 days (+20%)', '1–3 gün (+20%)', '1–3 días (+20%)'],
        'urgent' => ['Urgent (+40%)', 'Təcili (+40%)', 'Urgente (+40%)'],
    ];
    foreach ($deadlineInfra as $id => $row) {
        $out['calc.deadline_infra.' . $id . '.n'] = $p($row);
    }

    $scopeMob = [
        'm1' => [['Small', '5–10 screens'], ['Kiçik', '5–10 ekran'], ['Pequeño', '5–10 pantallas']],
        'm2' => [['Medium', '11–25 screens'], ['Orta', '11–25 ekran'], ['Mediano', '11–25 pantallas']],
        'm3' => [['Large', '25+ screens'], ['Böyük', '25+ ekran'], ['Grande', '25+ pantallas']],
    ];
    foreach ($scopeMob as $id => $rows) {
        $out['calc.scope.mob.' . $id . '.n'] = $p([$rows[0][0], $rows[1][0], $rows[0][0], $rows[2][0]]);
        $out['calc.scope.mob.' . $id . '.d'] = $p([$rows[0][1], $rows[1][1], $rows[0][1], $rows[2][1]]);
    }
    $scopeMobPlat = [
        'both' => [['Android + iOS', 'Two stores'], ['Android + iOS', 'İki mağaza'], ['Android + iOS', 'Dos tiendas']],
        'android' => [['Android', 'Play Store'], ['Android', 'Play Store'], ['Android', 'Play Store']],
        'ios' => [['iOS', 'App Store'], ['iOS', 'App Store'], ['iOS', 'App Store']],
        'one' => [['Flutter (both)', 'Single codebase'], ['Flutter (hər ikisi)', 'Tək kod bazası'], ['Flutter (ambos)', 'Un solo código']],
        'pwa' => [['PWA', 'Browser + install'], ['PWA', 'Brauzer + quraşdırma'], ['PWA', 'Navegador + instalación']],
    ];
    foreach ($scopeMobPlat as $id => $rows) {
        $out['calc.scope.mobplat.' . $id . '.n'] = $p([$rows[0][0], $rows[1][0], $rows[0][0], $rows[2][0]]);
        $out['calc.scope.mobplat.' . $id . '.d'] = $p([$rows[0][1], $rows[1][1], $rows[0][1], $rows[2][1]]);
    }
    $scopeSoft = [
        's1' => [['Simple', 'Basic CRUD'], ['Sadə', 'Əsas CRUD'], ['Simple', 'CRUD básico']],
        's2' => [['Medium', 'Roles, reports'], ['Orta', 'Rol, hesabat'], ['Mediano', 'Roles, informes']],
        's3' => [['Complex', 'Multi-module workflow'], ['Mürəkkəb', 'Çox modul, workflow'], ['Complejo', 'Flujo multi-módulo']],
    ];
    foreach ($scopeSoft as $id => $rows) {
        $out['calc.scope.soft.' . $id . '.n'] = $p([$rows[0][0], $rows[1][0], $rows[0][0], $rows[2][0]]);
        $out['calc.scope.soft.' . $id . '.d'] = $p([$rows[0][1], $rows[1][1], $rows[0][1], $rows[2][1]]);
    }
    $scopeUsers = [
        'u1' => [['Small team', '1–10 users'], ['Kiçik komanda', '1–10 user'], ['Equipo pequeño', '1–10 usuarios']],
        'u2' => [['Medium', '11–50 users'], ['Orta', '11–50 user'], ['Mediano', '11–50 usuarios']],
        'u3' => [['Large', '50+ users'], ['Böyük', '50+ user'], ['Grande', '50+ usuarios']],
    ];
    foreach ($scopeUsers as $id => $rows) {
        $out['calc.scope.users.' . $id . '.n'] = $p([$rows[0][0], $rows[1][0], $rows[0][0], $rows[2][0]]);
        $out['calc.scope.users.' . $id . '.d'] = $p([$rows[0][1], $rows[1][1], $rows[0][1], $rows[2][1]]);
    }
    $scopeInfra = [
        'i1' => [['Single server', '1 VM / host'], ['Tək server', '1 VM / host'], ['Un servidor', '1 VM / host']],
        'i2' => [['Cluster', 'Proxmox, many VMs'], ['Cluster', 'Proxmox, çox VM'], ['Cluster', 'Proxmox, muchas VM']],
        'i3' => [['Enterprise', 'HA, backup, monitor'], ['Korporativ', 'HA, backup, monitor'], ['Empresarial', 'HA, backup, monitor']],
    ];
    foreach ($scopeInfra as $id => $rows) {
        $out['calc.scope.infra.' . $id . '.n'] = $p([$rows[0][0], $rows[1][0], $rows[0][0], $rows[2][0]]);
        $out['calc.scope.infra.' . $id . '.d'] = $p([$rows[0][1], $rows[1][1], $rows[0][1], $rows[2][1]]);
    }
    $scopeDesk = [
        'd1' => [['Simple', '1 module'], ['Sadə', '1 modul'], ['Simple', '1 módulo']],
        'd2' => [['Medium', 'Several modules'], ['Orta', 'Bir neçə modul'], ['Mediano', 'Varios módulos']],
        'd3' => [['Complex', 'Drivers, hardware'], ['Kompleks', 'Driver, hardware'], ['Complejo', 'Drivers, hardware']],
    ];
    foreach ($scopeDesk as $id => $rows) {
        $out['calc.scope.desk.' . $id . '.n'] = $p([$rows[0][0], $rows[1][0], $rows[0][0], $rows[2][0]]);
        $out['calc.scope.desk.' . $id . '.d'] = $p([$rows[0][1], $rows[1][1], $rows[0][1], $rows[2][1]]);
    }

    $extras = [
        'seo_extra' => ['SEO', 'SEO', 'SEO'],
        'hosting' => ['Hosting + domain', 'Hosting + domain', 'Hosting + dominio'],
        'logo' => ['Logo / brand', 'Logo / brend', 'Logo / marca'],
        'train' => ['Training', 'Təlim', 'Formación'],
        'content' => ['Content writing', 'Məzmun yazılması', 'Redacción de contenido'],
        'store_publish' => ['App Store / Play', 'App Store / Play', 'App Store / Play'],
        'maintain' => ['3 months support', '3 ay dəstək', '3 meses de soporte'],
        'maintain_y' => ['Annual support', 'İllik dəstək', 'Soporte anual'],
        'migrate' => ['Migration', 'Köçürmə', 'Migración'],
    ];
    foreach ($extras as $id => $row) {
        $out['calc.extra.' . $id . '.n'] = $p($row);
    }

    $smart = [
        'landing' => [['Landing', 'Quick to launch; slider and analytics recommended.'], ['Landing', 'Tez hazırlanır; slider və analytics tövsiyə olunur.'], ['Landing', 'Rápido; slider y analytics recomendados.']],
        'wordpress' => [['WordPress', 'Consider theme, plugins and security updates.'], ['WordPress', 'Tema, plugin və təhlükəsizlik yeniləmələri nəzərə alın.'], ['WordPress', 'Tema, plugins y actualizaciones de seguridad.']],
        'dle' => [['DLE portal', 'News module, ad zones and admin panel recommended.'], ['DLE portal', 'Xəbər modulu, reklam zonası və admin panel tövsiyə olunur.'], ['Portal DLE', 'Módulo de noticias, anuncios y panel admin.']],
        'portal' => [['Portal / DLE', 'Modules, SEO and high-traffic optimization matter.'], ['Portal / DLE', 'Modul, SEO və yüksək trafik optimallaşdırması vacibdir.'], ['Portal / DLE', 'Módulos, SEO y optimización de tráfico.']],
        'ecommerce' => [['E-commerce', 'Cart, payments and admin are essential for sales.'], ['E-ticarət', 'Səbət, ödəniş və admin panel satış üçün vacibdir.'], ['E-commerce', 'Carrito, pagos y admin esenciales.']],
        'mobile_flutter' => [['Flutter', 'One codebase for Android and iOS — saves time and budget.'], ['Flutter', 'Bir kodla Android və iOS — vaxt və büdcə qənaəti.'], ['Flutter', 'Un código para Android e iOS — ahorra tiempo.']],
        'mobile_android' => [['Android', 'Kotlin native — Play Store and push notifications.'], ['Android', 'Kotlin native — Play Store və push bildirişlər.'], ['Android', 'Kotlin nativo — Play Store y push.']],
        'mobile_ios' => [['iOS', 'Swift native — App Store requirements included.'], ['iOS', 'Swift native — App Store tələbləri nəzərə alınır.'], ['iOS', 'Swift nativo — requisitos App Store.']],
        'mobile_pwa' => [['PWA', 'Web-based mobile — fast, works without app stores.'], ['PWA', 'Veb əsaslı mobil — sürətli, mağaza olmadan da işləyir.'], ['PWA', 'Móvil web — rápido, sin tiendas.']],
        'crm' => [['CRM', 'Sales pipeline and customer cards are core.'], ['CRM', 'Satış pipeline və müştəri kartları əsas moduldur.'], ['CRM', 'Pipeline de ventas y fichas de clientes.']],
        'erp' => [['ERP', 'Plan with warehouse, CRM and reporting modules.'], ['ERP', 'Anbar, CRM və hesabat modulları ilə planlayın.'], ['ERP', 'Planifique almacén, CRM e informes.']],
        'admin_panel' => [['Admin panel', 'Role system and reports are often needed.'], ['İdarə paneli', 'Rol sistemi və hesabatlar tez-tez lazım olur.'], ['Panel admin', 'Roles e informes suelen hacer falta.']],
        'server_setup' => [['Server', 'Nginx, SSL, backup — minimum security package.'], ['Server', 'Nginx, SSL, backup — minimum təhlükəsizlik paketi.'], ['Servidor', 'Nginx, SSL, backup — paquete mínimo.']],
        'desktop_app' => [['Desktop', 'Windows/Linux client — complexity varies.'], ['Desktop', 'Windows/Linux müştəri proqramı — mürəkkəblikdən asılıdır.'], ['Escritorio', 'Cliente Windows/Linux — varía la complejidad.']],
    ];
    foreach ($smart as $id => $rows) {
        $out['calc.smart.' . $id . '.title'] = $p([$rows[0][0], $rows[1][0], $rows[0][0], $rows[2][0]]);
        $out['calc.smart.' . $id . '.text'] = $p([$rows[0][1], $rows[1][1], $rows[0][1], $rows[2][1]]);
    }

    return $out;
}
