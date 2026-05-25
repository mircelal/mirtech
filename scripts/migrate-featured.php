<?php
require dirname(__DIR__) . '/config.php';
foreach (['projects.json', 'services.json', 'technologies.json'] as $file) {
    $items = readJson($file);
    foreach ($items as $i => $item) {
        if (!array_key_exists('featured', $item)) {
            $sort = (int)($item['sort'] ?? 99);
            if ($file === 'projects.json') {
                $items[$i]['featured'] = $sort <= 6;
            } elseif ($file === 'services.json') {
                $items[$i]['featured'] = $sort <= 4;
            } else {
                $items[$i]['featured'] = $sort <= 10;
            }
        }
    }
    writeJson($file, $items);
    echo "Updated $file\n";
}
