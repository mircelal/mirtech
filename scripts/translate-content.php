<?php
declare(strict_types=1);

/**
 * Fill EN/ES translations from AZ content (settings, services, projects).
 * Run: php scripts/translate-content.php
 */

require_once dirname(__DIR__) . '/config.php';
require_once dirname(__DIR__) . '/core/includes/content-translator.php';

$def = defaultLang();

// Settings
$settingsPath = DATA_PATH . '/settings.json';
$settings = json_decode(file_get_contents($settingsPath) ?: '{}', true);
if (is_array($settings)) {
    copy($settingsPath, $settingsPath . '.bak-translate-' . date('Ymd-His'));
    $settings = syncSettingsDefault($settings, $def);
    file_put_contents($settingsPath, json_encode($settings, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
    echo "Translated settings.json (EN default top-level + az/en/es translations)\n";
}

// Services
$servicesPath = DATA_PATH . '/services.json';
$services = json_decode(file_get_contents($servicesPath) ?: '[]', true);
if (is_array($services)) {
    copy($servicesPath, $servicesPath . '.bak-translate-' . date('Ymd-His'));
    foreach ($services as $i => $s) {
        $services[$i] = syncEntityDefaultFields($s, serviceTranslationsPack($s), $def);
    }
    file_put_contents($servicesPath, json_encode($services, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
    echo 'Translated ' . count($services) . " services\n";
}

// Projects
$projectsPath = DATA_PATH . '/projects.json';
$projects = json_decode(file_get_contents($projectsPath) ?: '[]', true);
if (is_array($projects)) {
    copy($projectsPath, $projectsPath . '.bak-translate-' . date('Ymd-His'));
    foreach ($projects as $i => $p) {
        $projects[$i] = syncEntityDefaultFields($p, projectTranslationFromAz($p), $def);
    }
    file_put_contents($projectsPath, json_encode($projects, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
    echo 'Translated ' . count($projects) . " projects\n";
}

// Technologies (names usually stay as brand names; translate only if AZ-specific)
$techPath = DATA_PATH . '/technologies.json';
$techs = json_decode(file_get_contents($techPath) ?: '[]', true);
if (is_array($techs)) {
    foreach ($techs as $i => $t) {
        $name = (string)($t['name'] ?? '');
        $techs[$i]['translations'] = [
            'az' => ['name' => $name],
            'en' => ['name' => $name],
            'es' => ['name' => $name],
        ];
    }
    file_put_contents($techPath, json_encode($techs, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
    echo 'Synced ' . count($techs) . " technology names (brands unchanged)\n";
}

echo "Done. Default language content is now in: {$def}\n";
