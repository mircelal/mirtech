<?php
declare(strict_types=1);

function view(string $name, array $data = []): void
{
    if (!preg_match('/^[a-zA-Z0-9][a-zA-Z0-9._\\/-]*$/', $name) || str_contains($name, '..')) {
        throw new InvalidArgumentException('Invalid view name');
    }
    $relative = str_replace('.', '/', $name) . '.php';
    $file = VIEWS_PATH . '/' . $relative;
    $viewsRoot = realpath(VIEWS_PATH);
    $resolved = realpath($file);
    if ($viewsRoot === false || $resolved === false || !str_starts_with($resolved, $viewsRoot)) {
        throw new RuntimeException('View not found: ' . $name);
    }
    extract($data, EXTR_SKIP);
    include $resolved;
}
