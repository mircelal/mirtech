<?php
declare(strict_types=1);

/** Kalkulyator seçimlərinin admin üçün oxunaqlı etiketləri (calculator.js ilə uyğun) */
function leadCalcLabelMaps(): array
{
    return [
        'types' => [
            'landing' => 'Landing Page',
            'corporate' => 'Korporativ sayt',
            'ecommerce' => 'E-Ticarət',
            'portal' => 'Portal / Media',
            'blog' => 'Blog / Jurnal',
            'wordpress' => 'WordPress',
            'dle' => 'DLE (DataLife)',
            'mobile_flutter' => 'Mobil (Flutter)',
            'mobile_android' => 'Android App',
            'mobile_ios' => 'iOS App',
            'mobile_pwa' => 'PWA',
            'admin_panel' => 'İdarə Paneli',
            'erp' => 'ERP Sistemi',
            'crm' => 'CRM',
            'custom_app' => 'Xüsusi Proqram',
            'api_backend' => 'API / Backend',
            'desktop_app' => 'Desktop Proqram',
            'desktop_tool' => 'Desktop Alət',
            'server_setup' => 'Server Quraşdırma',
            'proxmox_cloud' => 'Proxmox / VM',
            'nextcloud_setup' => 'Nextcloud / NAS',
            'infra_full' => 'Tam infrastruktur',
            'migration' => 'Köçürmə',
        ],
        'groups' => [
            'web' => 'Veb sayt',
            'mobile' => 'Mobil',
            'software' => 'Proqram / Panel',
            'desktop' => 'Desktop',
            'infra' => 'Server / İnfrastruktur',
        ],
        'pages' => [
            'p1' => '1–5 səhifə',
            'p2' => '6–20 səhifə',
            'p3' => '21–50 səhifə',
            'p4' => '50+ səhifə',
        ],
        'langs' => [
            'az' => 'Azərbaycan',
            'ru' => 'Rus',
            'en' => 'İngilis',
            'tr' => 'Türk',
        ],
        'mobSize' => [
            'm1' => 'Kiçik (5–10 ekran)',
            'm2' => 'Orta (11–25 ekran)',
            'm3' => 'Böyük (25+ ekran)',
        ],
        'mobPlatform' => [
            'both' => 'Android + iOS',
            'android' => 'Android',
            'ios' => 'iOS',
            'one' => 'Flutter (hər ikisi)',
            'pwa' => 'PWA',
        ],
        'softComplex' => [
            's1' => 'Sadə (əsas CRUD)',
            's2' => 'Orta (rol, hesabat)',
            's3' => 'Mürəkkəb (workflow)',
        ],
        'softUsers' => [
            'u1' => 'Kiçik komanda (1–10)',
            'u2' => 'Orta (11–50)',
            'u3' => 'Böyük (50+)',
        ],
        'infraScale' => [
            'i1' => 'Tək server',
            'i2' => 'Cluster (Proxmox)',
            'i3' => 'Korporativ (HA, backup)',
        ],
        'deskScope' => [
            'd1' => 'Sadə (1 modul)',
            'd2' => 'Orta (bir neçə modul)',
            'd3' => 'Kompleks (driver, hardware)',
        ],
        'mods' => [
            'admin' => 'Admin Panel',
            'search' => 'Axtarış',
            'auth' => 'Login / Rol',
            'cart' => 'Səbət',
            'payment' => 'Ödəniş',
            'crm_m' => 'CRM Modulu',
            'whouse' => 'Anbar',
            'account' => 'Mühasibat',
            'sales' => 'Satış',
            'report' => 'Hesabat',
            'blog_m' => 'Blog / Xəbər',
            'slider' => 'Slider',
            'chat' => 'Canlı dəstək',
            'api' => 'API İnteqrasiya',
            'push' => 'Push bildiriş',
            'maps' => 'Xəritə',
            'gana' => 'Analytics',
            'monitor' => 'Monitorinq',
            'backup_infra' => 'Backup',
            'docker_extra' => 'Docker',
            'vpn' => 'VPN / WireGuard',
            'ssl_infra' => 'SSL / WAF',
            'twofa' => '2FA',
            'invoice' => 'Faktura PDF',
            'seo_extra' => 'SEO',
        ],
        'tier' => [
            'std' => 'Standart UI',
            'pro' => 'Xüsusi dizayn',
            'prem' => 'Premium UX',
        ],
        'dead' => [
            'std' => 'Standart müddət',
            'fast' => 'Sürətli (+ödəniş)',
            'urgent' => 'Təcili (+ödəniş)',
        ],
        'extras' => [
            'seo_extra' => 'SEO',
            'hosting' => 'Hosting + domain',
            'logo' => 'Logo / brend',
            'train' => 'Təlim',
            'content' => 'Məzmun yazılması',
            'store_publish' => 'App Store / Play',
            'maintain' => '3 ay dəstək',
            'maintain_y' => 'İllik dəstək',
            'migrate' => 'Köçürmə',
        ],
    ];
}

function leadLabel(array $maps, string $map, string $id): string
{
    return $maps[$map][$id] ?? $id;
}

/** @return list<array{0:string,1:string}> */
function leadDetailRows(array $details): array
{
    if (!is_array($details) || $details === []) {
        return [];
    }

    $maps = leadCalcLabelMaps();
    $rows = [];
    $group = (string)($details['group'] ?? 'web');

    if (!empty($details['type'])) {
        $rows[] = ['Layihə növü', leadLabel($maps, 'types', (string)$details['type'])];
    }
    $rows[] = ['Kateqoriya', leadLabel($maps, 'groups', $group)];

    if (!empty($details['summary'])) {
        $rows[] = ['Xülasə', (string)$details['summary']];
    }

    switch ($group) {
        case 'web':
            if (!empty($details['page'])) {
                $rows[] = ['Səhifə həcmi', leadLabel($maps, 'pages', (string)$details['page'])];
            }
            break;
        case 'mobile':
            if (!empty($details['mobSize'])) {
                $rows[] = ['Tətbiq ölçüsü', leadLabel($maps, 'mobSize', (string)$details['mobSize'])];
            }
            if (!empty($details['mobPlatform'])) {
                $rows[] = ['Platforma', leadLabel($maps, 'mobPlatform', (string)$details['mobPlatform'])];
            }
            break;
        case 'software':
            if (!empty($details['softComplex'])) {
                $rows[] = ['Mürəkkəblik', leadLabel($maps, 'softComplex', (string)$details['softComplex'])];
            }
            if (!empty($details['softUsers'])) {
                $rows[] = ['İstifadəçi sayı', leadLabel($maps, 'softUsers', (string)$details['softUsers'])];
            }
            break;
        case 'desktop':
            if (!empty($details['deskScope'])) {
                $rows[] = ['Desktop həcmi', leadLabel($maps, 'deskScope', (string)$details['deskScope'])];
            }
            break;
        case 'infra':
            if (!empty($details['infraScale'])) {
                $rows[] = ['İnfrastruktur', leadLabel($maps, 'infraScale', (string)$details['infraScale'])];
            }
            break;
    }

    $langs = $details['langs'] ?? [];
    if (is_array($langs) && $langs !== []) {
        $langNames = array_map(fn($id) => leadLabel($maps, 'langs', (string)$id), $langs);
        $rows[] = ['Dillər', implode(', ', $langNames)];
    }

    $mods = $details['mods'] ?? [];
    if (is_array($mods) && $mods !== []) {
        $modNames = array_map(fn($id) => leadLabel($maps, 'mods', (string)$id), $mods);
        $rows[] = ['Modullar', implode(', ', $modNames)];
    } else {
        $rows[] = ['Modullar', '—'];
    }

    if (!empty($details['tier'])) {
        $rows[] = ['Dizayn / UI', leadLabel($maps, 'tier', (string)$details['tier'])];
    }
    if (!empty($details['dead'])) {
        $rows[] = ['Hazırlıq müddəti', leadLabel($maps, 'dead', (string)$details['dead'])];
    }

    $extras = $details['extras'] ?? [];
    if (is_array($extras) && $extras !== []) {
        $extraNames = array_map(fn($id) => leadLabel($maps, 'extras', (string)$id), $extras);
        $rows[] = ['Əlavə xidmətlər', implode(', ', $extraNames)];
    } else {
        $rows[] = ['Əlavə xidmətlər', '—'];
    }

    return $rows;
}

function findLeadById(array $leads, int $id): ?array
{
    foreach ($leads as $lead) {
        if ((int)($lead['id'] ?? 0) === $id) {
            return $lead;
        }
    }
    return null;
}

function leadWhatsAppUrl(array $lead): string
{
    $sc = siteContact();
    $wa = $sc['whatsapp_raw'] ?? '994707232128';
    $name = $lead['name'] ?? '';
    $phone = $lead['phone'] ?? '';
    $type = $lead['project_type'] ?? '—';
    $total = $lead['total'] ?? '—';
    $summary = is_array($lead['details'] ?? null) ? ($lead['details']['summary'] ?? '') : '';
    $msg = "MirTech — Müraciət #{$lead['id']}\nAd: {$name}\nTel: {$phone}\nLayihə: {$type}\nQiymət: {$total}";
    if ($summary !== '') {
        $msg .= "\n{$summary}";
    }
    return 'https://wa.me/' . preg_replace('/\D/', '', $wa) . '?text=' . rawurlencode($msg);
}
