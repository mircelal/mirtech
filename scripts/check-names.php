<?php
$p = json_decode(file_get_contents(dirname(__DIR__) . '/data/projects.json'), true);
$n = array_column($p, 'name');
echo 'unique: ' . count(array_unique($n)) . ' / ' . count($n) . PHP_EOL;
$dups = array_diff_assoc($n, array_unique($n));
if ($dups) {
    echo 'Duplicates: ' . implode(', ', array_unique($dups)) . PHP_EOL;
}
foreach (array_slice($n, 0, 12) as $x) {
    echo "- $x\n";
}
