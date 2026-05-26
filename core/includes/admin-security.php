<?php
declare(strict_types=1);

/** Admin panel CSRF token (sessiya). */
function adminCsrfToken(): string
{
    if (empty($_SESSION['admin_csrf_token']) || !is_string($_SESSION['admin_csrf_token'])) {
        $_SESSION['admin_csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['admin_csrf_token'];
}

function adminRegenerateCsrfToken(): void
{
    $_SESSION['admin_csrf_token'] = bin2hex(random_bytes(32));
}

function adminEnsureCsrfToken(): void
{
    adminCsrfToken();
}

function adminCsrfField(): string
{
    return '<input type="hidden" name="csrf_token" value="'
        . htmlspecialchars(adminCsrfToken(), ENT_QUOTES, 'UTF-8') . '">';
}

function adminVerifyCsrf(): void
{
    $sent = '';
    if (!empty($_POST['csrf_token']) && is_string($_POST['csrf_token'])) {
        $sent = $_POST['csrf_token'];
    } elseif (!empty($_SERVER['HTTP_X_CSRF_TOKEN']) && is_string($_SERVER['HTTP_X_CSRF_TOKEN'])) {
        $sent = $_SERVER['HTTP_X_CSRF_TOKEN'];
    }
    $expected = $_SESSION['admin_csrf_token'] ?? '';
    if ($sent === '' || $expected === '' || !hash_equals($expected, $sent)) {
        http_response_code(403);
        header('Content-Type: text/plain; charset=UTF-8');
        echo 'CSRF doğrulaması uğursuz oldu. Səhifəni yeniləyib yenidən cəhd edin.';
        exit;
    }
}
