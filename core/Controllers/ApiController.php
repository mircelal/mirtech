<?php
declare(strict_types=1);

namespace App\Controllers;

class ApiController
{
    public static function dispatch(string $action): void
    {
        header('Content-Type: application/json; charset=utf-8');

        match ($action) {
            'lead' => self::lead(),
            default => self::jsonError('Not found', 404),
        };
    }

    public static function lead(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            self::jsonError('Method not allowed', 405);
            return;
        }

        $input = json_decode(file_get_contents('php://input') ?: '{}', true);
        if (!is_array($input)) {
            $input = $_POST;
        }

        $name = sanitizeLeadString((string)($input['name'] ?? ''), 120);
        $phone = sanitizeLeadString((string)($input['phone'] ?? ''), 40);

        if ($name === '' || $phone === '') {
            self::jsonError('Ad və telefon tələb olunur', 400);
            return;
        }

        $mailResult = saveLead([
            'name' => $name,
            'phone' => $phone,
            'email' => sanitizeLeadString((string)($input['email'] ?? ''), 160),
            'note' => sanitizeLeadString((string)($input['note'] ?? ''), 2000),
            'project_type' => sanitizeLeadString((string)($input['project_type'] ?? ''), 200),
            'total' => sanitizeLeadString((string)($input['total'] ?? ''), 80),
            'details' => sanitizeLeadDetails($input['details'] ?? []),
        ]);

        echo json_encode([
            'ok' => true,
            'id' => $mailResult['id'] ?? null,
            'email_sent' => $mailResult['email_sent'] ?? false,
            'email_error' => $mailResult['email_error'] ?? null,
        ]);
    }

    private static function jsonError(string $message, int $code): void
    {
        http_response_code($code);
        echo json_encode(['ok' => false, 'error' => $message]);
    }
}
