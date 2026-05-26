<?php
declare(strict_types=1);

/**
 * One-time migration: translations for projects/services/settings/technologies + lang packs.
 * Run: php scripts/migrate-i18n.php
 */

require_once dirname(__DIR__) . '/config.php';

// Avoid session lang side effects
$GLOBALS['_mirtech_lang'] = 'en';

$langDir = DATA_PATH . '/lang';
if (!is_dir($langDir)) {
    mkdir($langDir, 0755, true);
}

foreach (['en', 'az', 'es'] as $code) {
    $path = $langDir . '/' . $code . '.json';
    $defaults = i18nDefaultStrings($code);
    $existing = [];
    if (is_file($path)) {
        $existing = json_decode(file_get_contents($path) ?: '{}', true);
        if (!is_array($existing)) {
            $existing = [];
        }
    }
    $merged = array_merge($defaults, $existing);
    file_put_contents($path, json_encode($merged, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
    echo "Updated {$path}\n";
}

function projectTranslationBlock(array $p): array
{
    return [
        'name' => (string)($p['name'] ?? ''),
        'desc' => (string)($p['desc'] ?? ''),
        'overview' => (string)($p['overview'] ?? ''),
        'category' => (string)($p['category'] ?? ''),
        'duration' => (string)($p['duration'] ?? ''),
        'features' => is_array($p['features'] ?? null) ? $p['features'] : [],
        'timeline' => is_array($p['timeline'] ?? null) ? $p['timeline'] : [],
        'stats' => is_array($p['stats'] ?? null) ? $p['stats'] : [],
    ];
}

$projectsPath = DATA_PATH . '/projects.json';
if (is_file($projectsPath)) {
    $projects = json_decode(file_get_contents($projectsPath) ?: '[]', true);
    if (is_array($projects)) {
        $changed = false;
        foreach ($projects as $i => $p) {
            if (!empty($p['translations']) && is_array($p['translations'])) {
                continue;
            }
            $block = projectTranslationBlock($p);
            $projects[$i]['translations'] = [
                'az' => $block,
                'en' => $block,
                'es' => $block,
            ];
            $changed = true;
        }
        if ($changed) {
            copy($projectsPath, $projectsPath . '.bak-' . date('Ymd-His'));
            file_put_contents($projectsPath, json_encode($projects, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
            echo "Migrated projects.json\n";
        }
    }
}

$servicesPath = DATA_PATH . '/services.json';
if (is_file($servicesPath)) {
    $services = json_decode(file_get_contents($servicesPath) ?: '[]', true);
    if (is_array($services)) {
        $changed = false;
        foreach ($services as $i => $s) {
            if (!empty($s['translations'])) {
                continue;
            }
            $block = [
                'title' => (string)($s['title'] ?? ''),
                'desc' => (string)($s['desc'] ?? ''),
                'price' => (string)($s['price'] ?? ''),
            ];
            $services[$i]['translations'] = ['az' => $block, 'en' => $block, 'es' => $block];
            $changed = true;
        }
        if ($changed) {
            copy($servicesPath, $servicesPath . '.bak-' . date('Ymd-His'));
            file_put_contents($servicesPath, json_encode($services, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
            echo "Migrated services.json\n";
        }
    }
}

$techPath = DATA_PATH . '/technologies.json';
if (is_file($techPath)) {
    $techs = json_decode(file_get_contents($techPath) ?: '[]', true);
    if (is_array($techs)) {
        $changed = false;
        foreach ($techs as $i => $t) {
            if (!empty($t['translations'])) {
                continue;
            }
            $name = (string)($t['name'] ?? '');
            $techs[$i]['translations'] = [
                'az' => ['name' => $name],
                'en' => ['name' => $name],
                'es' => ['name' => $name],
            ];
            $changed = true;
        }
        if ($changed) {
            copy($techPath, $techPath . '.bak-' . date('Ymd-His'));
            file_put_contents($techPath, json_encode($techs, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
            echo "Migrated technologies.json\n";
        }
    }
}

$settingsPath = DATA_PATH . '/settings.json';
if (is_file($settingsPath)) {
    $settings = json_decode(file_get_contents($settingsPath) ?: '[]', true);
    if (is_array($settings) && empty($settings['translations'])) {
        $block = [
            'tagline' => (string)($settings['tagline'] ?? ''),
            'hero_eyebrow' => (string)($settings['hero_eyebrow'] ?? ''),
            'hero_title' => (string)($settings['hero_title'] ?? ''),
            'hero_title_highlight' => (string)($settings['hero_title_highlight'] ?? ''),
            'hero_subtitle' => (string)($settings['hero_subtitle'] ?? ''),
            'stats' => $settings['stats'] ?? [],
            'why' => $settings['why'] ?? [],
            'included' => $settings['included'] ?? [],
        ];
        $settings['translations'] = [
            'az' => $block,
            'en' => $block,
            'es' => $block,
        ];
        copy($settingsPath, $settingsPath . '.bak-' . date('Ymd-His'));
        file_put_contents($settingsPath, json_encode($settings, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
        echo "Migrated settings.json\n";
    }
}

echo "Done.\n";
