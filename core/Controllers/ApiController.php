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

        $name = trim($input['name'] ?? '');
        $phone = trim($input['phone'] ?? '');

        if ($name === '' || $phone === '') {
            self::jsonError('Ad və telefon tələb olunur', 400);
            return;
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
    }

    private static function jsonError(string $message, int $code): void
    {
        http_response_code($code);
        echo json_encode(['ok' => false, 'error' => $message]);
    }
}
