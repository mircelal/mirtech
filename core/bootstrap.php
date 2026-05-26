<?php
declare(strict_types=1);

session_start();

require __DIR__ . '/paths.php';
require __DIR__ . '/helpers.php';
require __DIR__ . '/View.php';

require CORE_PATH . '/includes/tech-icon.php';
require CORE_PATH . '/includes/mail.php';
require CORE_PATH . '/includes/lead-format.php';
require CORE_PATH . '/includes/i18n.php';
require CORE_PATH . '/includes/seo.php';
require CORE_PATH . '/includes/performance.php';

spl_autoload_register(static function (string $class): void {
    if (!str_starts_with($class, 'App\\Controllers\\')) {
        return;
    }
    $rel = str_replace('\\', '/', substr($class, strlen('App\\Controllers\\')));
    $file = CORE_PATH . '/Controllers/' . $rel . '.php';
    if (is_file($file)) {
        require $file;
    }
});

if (!isAdminRequest()) {
    initLang();
}
