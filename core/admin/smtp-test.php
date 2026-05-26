<?php
requireAuth();

header('Content-Type: application/json; charset=utf-8');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['ok' => false, 'error' => 'Method not allowed']);
    exit;
}

$result = sendTestNotificationEmail();
echo json_encode($result, JSON_UNESCAPED_UNICODE);
