<?php
declare(strict_types=1);
header('Content-Type: application/json; charset=utf-8');
require_once dirname(__DIR__) . '/config.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['ok' => false, 'error' => 'Method not allowed']);
    exit;
}

$input = json_decode(file_get_contents('php://input') ?: '{}', true);
if (!is_array($input)) {
    $input = $_POST;
}

$name = trim($input['name'] ?? '');
$phone = trim($input['phone'] ?? '');

if ($name === '' || $phone === '') {
    http_response_code(400);
    echo json_encode(['ok' => false, 'error' => 'Ad və telefon tələb olunur']);
    exit;
}

$mailResult = saveLead([
    'name' => $name,
    'phone' => $phone,
    'email' => trim($input['email'] ?? ''),
    'note' => trim($input['note'] ?? ''),
    'project_type' => trim($input['project_type'] ?? ''),
    'total' => trim($input['total'] ?? ''),
    'details' => $input['details'] ?? [],
]);

echo json_encode([
    'ok' => true,
    'id' => $mailResult['id'] ?? null,
    'email_sent' => $mailResult['email_sent'] ?? false,
    'email_error' => $mailResult['email_error'] ?? null,
]);
