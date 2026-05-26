<?php
declare(strict_types=1);

require dirname(__DIR__) . '/core/bootstrap.php';

header('Content-Type: application/xml; charset=utf-8');
header('X-Robots-Tag: noindex');
echo generateSitemapXml();
