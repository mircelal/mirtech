<?php
$p = json_decode(file_get_contents(dirname(__DIR__) . '/data/projects.json'), true);
foreach ($p as $x) {
    if (mb_strlen($x['desc'] ?? '') < 50) {
        echo mb_strlen($x['desc']) . ' | ' . ($x['name'] ?? '') . ' | ' . ($x['desc'] ?? '') . PHP_EOL;
    }
}
