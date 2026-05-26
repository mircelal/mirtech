<?php
declare(strict_types=1);

function view(string $name, array $data = []): void
{
    extract($data, EXTR_SKIP);
    $file = VIEWS_PATH . '/' . str_replace('.', '/', $name) . '.php';
    if (!is_file($file)) {
        throw new RuntimeException('View not found: ' . $name);
    }
    include $file;
}
