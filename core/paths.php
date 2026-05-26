<?php
declare(strict_types=1);

if (!defined('ROOT_PATH')) {
    define('ROOT_PATH', dirname(__DIR__));
}

define('CORE_PATH', ROOT_PATH . '/core');
define('PUBLIC_PATH', ROOT_PATH . '/public');
define('VIEWS_PATH', ROOT_PATH . '/views');
define('DATA_PATH', ROOT_PATH . '/data');
define('UPLOADS_PATH', PUBLIC_PATH . '/uploads/projects');

$userConfig = ROOT_PATH . '/config.user.php';
if (is_file($userConfig)) {
    require $userConfig;
}
