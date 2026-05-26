<?php
declare(strict_types=1);

require dirname(__DIR__) . '/core/bootstrap.php';

header('Content-Type: text/plain; charset=utf-8');
echo robotsTxtContent();
