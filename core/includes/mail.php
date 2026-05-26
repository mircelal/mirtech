<?php
declare(strict_types=1);

/**
 * SMTP ilə e-poçt (PHP mail() və xarici kitabxana olmadan).
 */

function mailSettings(): array
{
    $settings = readJson('settings.json');
    $smtp = is_array($settings['smtp'] ?? null) ? $settings['smtp'] : [];
    $contact = $settings['contact'] ?? [];

    return [
        'enabled' => !empty($smtp['enabled']),
        'host' => trim((string)($smtp['host'] ?? '')),
        'port' => (int)($smtp['port'] ?? 587),
        'encryption' => (string)($smtp['encryption'] ?? 'tls'),
        'username' => trim((string)($smtp['username'] ?? '')),
        'password' => (string)($smtp['password'] ?? ''),
        'from_email' => trim((string)($smtp['from_email'] ?? '')) ?: trim((string)($contact['email'] ?? '')),
        'from_name' => trim((string)($smtp['from_name'] ?? '')) ?: 'MirTech',
        'notify_email' => trim((string)($smtp['notify_email'] ?? '')) ?: trim((string)($contact['email'] ?? '')),
    ];
}

function buildLeadEmailHtml(array $lead): string
{
    $name = htmlspecialchars((string)($lead['name'] ?? ''), ENT_QUOTES, 'UTF-8');
    $phone = htmlspecialchars((string)($lead['phone'] ?? ''), ENT_QUOTES, 'UTF-8');
    $email = htmlspecialchars((string)($lead['email'] ?? '—'), ENT_QUOTES, 'UTF-8');
    $note = nl2br(htmlspecialchars((string)($lead['note'] ?? '—'), ENT_QUOTES, 'UTF-8'));
    $type = htmlspecialchars((string)($lead['project_type'] ?? '—'), ENT_QUOTES, 'UTF-8');
    $total = htmlspecialchars((string)($lead['total'] ?? '—'), ENT_QUOTES, 'UTF-8');
    $created = htmlspecialchars((string)($lead['created_at'] ?? date('Y-m-d H:i:s')), ENT_QUOTES, 'UTF-8');
    $summary = '';
    $details = $lead['details'] ?? [];
    if (is_array($details) && !empty($details['summary'])) {
        $summary = htmlspecialchars((string)$details['summary'], ENT_QUOTES, 'UTF-8');
    }

    $adminUrl = url('admin/leads.php');

    return <<<HTML
<!DOCTYPE html>
<html lang="az">
<head><meta charset="UTF-8"></head>
<body style="font-family:Segoe UI,Arial,sans-serif;background:#f4f6f9;padding:24px;color:#1a1a2e">
  <div style="max-width:560px;margin:0 auto;background:#fff;border-radius:12px;padding:28px;border:1px solid #e2e8f0">
    <h1 style="margin:0 0 8px;font-size:20px;color:#2563eb">Yeni qiymət təklifi</h1>
    <p style="margin:0 0 20px;color:#64748b;font-size:14px">MirTech sayt kalkulyatoru · {$created}</p>
    <table style="width:100%;border-collapse:collapse;font-size:14px">
      <tr><td style="padding:8px 0;color:#64748b;width:120px">Ad</td><td style="padding:8px 0;font-weight:600">{$name}</td></tr>
      <tr><td style="padding:8px 0;color:#64748b">Telefon</td><td style="padding:8px 0"><a href="tel:{$phone}">{$phone}</a></td></tr>
      <tr><td style="padding:8px 0;color:#64748b">Email</td><td style="padding:8px 0">{$email}</td></tr>
      <tr><td style="padding:8px 0;color:#64748b">Layihə</td><td style="padding:8px 0">{$type}</td></tr>
      <tr><td style="padding:8px 0;color:#64748b">Təxmini qiymət</td><td style="padding:8px 0;font-weight:700;color:#2563eb">{$total}</td></tr>
    </table>
    <p style="margin:16px 0 6px;font-size:12px;color:#64748b;text-transform:uppercase">Qısa xülasə</p>
    <p style="margin:0 0 16px;font-size:14px">{$summary}</p>
    <p style="margin:16px 0 6px;font-size:12px;color:#64748b;text-transform:uppercase">Qeyd</p>
    <p style="margin:0 0 20px;font-size:14px">{$note}</p>
    <a href="{$adminUrl}" style="display:inline-block;background:#2563eb;color:#fff;text-decoration:none;padding:12px 20px;border-radius:8px;font-weight:600;font-size:14px">Admin — müraciətlər</a>
  </div>
</body>
</html>
HTML;
}

function buildLeadEmailText(array $lead): string
{
    $lines = [
        'Yeni qiymət təklifi — MirTech',
        'Tarix: ' . ($lead['created_at'] ?? date('Y-m-d H:i:s')),
        'Ad: ' . ($lead['name'] ?? ''),
        'Telefon: ' . ($lead['phone'] ?? ''),
        'Email: ' . ($lead['email'] ?? '—'),
        'Layihə: ' . ($lead['project_type'] ?? '—'),
        'Qiymət: ' . ($lead['total'] ?? '—'),
    ];
    $details = $lead['details'] ?? [];
    if (is_array($details) && !empty($details['summary'])) {
        $lines[] = 'Xülasə: ' . $details['summary'];
    }
    if (!empty($lead['note'])) {
        $lines[] = 'Qeyd: ' . $lead['note'];
    }
    $lines[] = 'Admin: ' . url('admin/leads.php');
    return implode("\n", $lines);
}

/**
 * @return array{ok:bool,error:?string}
 */
function smtpSend(array $cfg, string $to, string $subject, string $htmlBody, ?string $replyTo = null, ?string $plainBody = null): array
{
    if ($cfg['host'] === '' || $to === '') {
        return ['ok' => false, 'error' => 'SMTP host və ya alıcı boşdur'];
    }
    if ($cfg['from_email'] === '') {
        return ['ok' => false, 'error' => 'Göndərən email təyin edilməyib'];
    }

    $enc = strtolower($cfg['encryption'] ?? 'tls');
    $port = (int)$cfg['port'];
    if ($port <= 0) {
        $port = $enc === 'ssl' ? 465 : 587;
    }

    $remote = ($enc === 'ssl' ? 'ssl://' : 'tcp://') . $cfg['host'] . ':' . $port;
    $errno = 0;
    $errstr = '';
    $socket = @stream_socket_client($remote, $errno, $errstr, 20, STREAM_CLIENT_CONNECT);
    if (!$socket) {
        return ['ok' => false, 'error' => "Bağlantı xətası: {$errstr} ({$errno})"];
    }

    stream_set_timeout($socket, 20);

    try {
        smtpExpect(smtpRead($socket), [220]);

        $ehloHost = 'mirtech.local';
        smtpCmd($socket, "EHLO {$ehloHost}\r\n");
        smtpExpect(smtpRead($socket), [250]);

        if ($enc === 'tls') {
            smtpCmd($socket, "STARTTLS\r\n");
            smtpExpect(smtpRead($socket), [220]);
            if (!stream_socket_enable_crypto($socket, true, STREAM_CRYPTO_METHOD_TLS_CLIENT)) {
                throw new RuntimeException('TLS aktivləşdirilmədi');
            }
            smtpCmd($socket, "EHLO {$ehloHost}\r\n");
            smtpExpect(smtpRead($socket), [250]);
        }

        if ($cfg['username'] !== '') {
            smtpCmd($socket, "AUTH LOGIN\r\n");
            smtpExpect(smtpRead($socket), [334]);
            smtpCmd($socket, base64_encode($cfg['username']) . "\r\n");
            smtpExpect(smtpRead($socket), [334]);
            smtpCmd($socket, base64_encode($cfg['password']) . "\r\n");
            smtpExpect(smtpRead($socket), [235]);
        }

        $from = $cfg['from_email'];
        smtpCmd($socket, "MAIL FROM:<{$from}>\r\n");
        smtpExpect(smtpRead($socket), [250]);

        smtpCmd($socket, "RCPT TO:<{$to}>\r\n");
        smtpExpect(smtpRead($socket), [250, 251]);

        smtpCmd($socket, "DATA\r\n");
        smtpExpect(smtpRead($socket), [354]);

        $subjectEnc = '=?UTF-8?B?' . base64_encode($subject) . '?=';
        $fromNameEnc = '=?UTF-8?B?' . base64_encode($cfg['from_name']) . '?=';
        $textBody = $plainBody ?? strip_tags(str_replace(['<br>', '<br/>', '<br />'], "\n", $htmlBody));
        $boundary = 'mirtech_' . bin2hex(random_bytes(8));

        $headers = [
            "From: {$fromNameEnc} <{$from}>",
            "To: <{$to}>",
            "Subject: {$subjectEnc}",
            'MIME-Version: 1.0',
            "Content-Type: multipart/alternative; boundary=\"{$boundary}\"",
            'Date: ' . date('r'),
        ];
        if ($replyTo && filter_var($replyTo, FILTER_VALIDATE_EMAIL)) {
            $headers[] = "Reply-To: {$replyTo}";
        }

        $message = implode("\r\n", $headers) . "\r\n\r\n";
        $message .= "--{$boundary}\r\nContent-Type: text/plain; charset=UTF-8\r\nContent-Transfer-Encoding: base64\r\n\r\n";
        $message .= chunk_split(base64_encode($textBody));
        $message .= "--{$boundary}\r\nContent-Type: text/html; charset=UTF-8\r\nContent-Transfer-Encoding: base64\r\n\r\n";
        $message .= chunk_split(base64_encode($htmlBody));
        $message .= "--{$boundary}--\r\n";
        $message = preg_replace('/\r\n\./', "\r\n..", $message);

        smtpCmd($socket, $message . "\r\n.\r\n");
        smtpExpect(smtpRead($socket), [250]);

        smtpCmd($socket, "QUIT\r\n");
        smtpRead($socket);

        return ['ok' => true, 'error' => null];
    } catch (Throwable $e) {
        return ['ok' => false, 'error' => $e->getMessage()];
    } finally {
        fclose($socket);
    }
}

function smtpCmd($socket, string $cmd): void
{
    fwrite($socket, $cmd);
}

/** @return string[] */
function smtpRead($socket): array
{
    $lines = [];
    while ($line = fgets($socket, 515)) {
        $lines[] = rtrim($line, "\r\n");
        if (isset($line[3]) && $line[3] === ' ') {
            break;
        }
    }
    return $lines;
}

/** @param int[] $codes */
function smtpExpect(array $lines, array $codes): void
{
    if ($lines === []) {
        throw new RuntimeException('SMTP cavabı boşdur');
    }
    $code = (int)substr($lines[0], 0, 3);
    if (!in_array($code, $codes, true)) {
        throw new RuntimeException('SMTP xətası: ' . implode(' | ', $lines));
    }
}

/**
 * @return array{ok:bool,error:?string}
 */
function sendLeadViaPhpMail(array $lead, array $cfg, ?string $subject = null, ?string $htmlBody = null, ?string $plainBody = null): array
{
    $to = $cfg['notify_email'];
    if ($to === '') {
        return ['ok' => false, 'error' => 'Bildiriş emaili təyin edilməyib'];
    }

    $type = trim((string)($lead['project_type'] ?? ''));
    $subject = $subject ?? ('Yeni təklif — MirTech' . ($type !== '' ? ' · ' . $type : ''));
    $htmlBody = $htmlBody ?? buildLeadEmailHtml($lead);
    $plainBody = $plainBody ?? buildLeadEmailText($lead);
    $from = $cfg['from_email'] !== '' ? $cfg['from_email'] : $to;
    $fromName = $cfg['from_name'] !== '' ? $cfg['from_name'] : 'MirTech';
    $fromHeader = function_exists('mb_encode_mimeheader')
        ? mb_encode_mimeheader($fromName, 'UTF-8') . " <{$from}>"
        : "{$fromName} <{$from}>";

    $boundary = 'mirtech_' . bin2hex(random_bytes(8));
    $replyTo = trim((string)($lead['email'] ?? ''));
    $replyTo = filter_var($replyTo, FILTER_VALIDATE_EMAIL) ? $replyTo : $from;

    $headers = [
        'MIME-Version: 1.0',
        'From: ' . $fromHeader,
        "Reply-To: {$replyTo}",
        "Content-Type: multipart/alternative; boundary=\"{$boundary}\"",
    ];

    $body = "--{$boundary}\r\n";
    $body .= "Content-Type: text/plain; charset=UTF-8\r\nContent-Transfer-Encoding: base64\r\n\r\n";
    $body .= chunk_split(base64_encode($plainBody));
    $body .= "--{$boundary}\r\n";
    $body .= "Content-Type: text/html; charset=UTF-8\r\nContent-Transfer-Encoding: base64\r\n\r\n";
    $body .= chunk_split(base64_encode($htmlBody));
    $body .= "--{$boundary}--";

    $subjectEnc = '=?UTF-8?B?' . base64_encode($subject) . '?=';
    $ok = @mail($to, $subjectEnc, $body, implode("\r\n", $headers));

    return ['ok' => $ok, 'error' => $ok ? null : 'PHP mail() göndərmədi'];
}

/**
 * @return array{ok:bool,error:?string}
 */
function sendLeadNotificationEmail(array $lead): array
{
    $cfg = mailSettings();
    if ($cfg['notify_email'] === '') {
        return ['ok' => false, 'error' => 'Bildiriş emaili təyin edilməyib'];
    }

    $type = trim((string)($lead['project_type'] ?? ''));
    $subject = 'Yeni təklif — MirTech' . ($type !== '' ? ' · ' . $type : '');
    $html = buildLeadEmailHtml($lead);
    $text = buildLeadEmailText($lead);
    $replyTo = trim((string)($lead['email'] ?? ''));
    $replyTo = filter_var($replyTo, FILTER_VALIDATE_EMAIL) ? $replyTo : null;

    if ($cfg['enabled']) {
        $smtpResult = smtpSend($cfg, $cfg['notify_email'], $subject, $html, $replyTo, $text);
        if ($smtpResult['ok']) {
            return $smtpResult;
        }
        $fallback = sendLeadViaPhpMail($lead, $cfg, $subject, $html, $text);
        if ($fallback['ok']) {
            return $fallback;
        }
        return ['ok' => false, 'error' => ($smtpResult['error'] ?? 'SMTP xətası') . ' · ' . ($fallback['error'] ?? 'mail() xətası')];
    }

    return sendLeadViaPhpMail($lead, $cfg, $subject, $html, $text);
}

/**
 * @return array{ok:bool,error:?string}
 */
function sendTestNotificationEmail(): array
{
    $cfg = mailSettings();
    if (!$cfg['enabled']) {
        return ['ok' => false, 'error' => 'Əvvəlcə SMTP-ni aktiv edin'];
    }

    $lead = [
        'name' => 'Test Müştəri',
        'phone' => '+994 50 000 00 00',
        'email' => 'test@example.com',
        'note' => 'Bu test mesajıdır — SMTP düzgün işləyir.',
        'project_type' => 'Test (Admin)',
        'total' => '₼1,250',
        'created_at' => date('Y-m-d H:i:s'),
        'details' => ['summary' => 'Test · Standart UI · 30 gün'],
    ];

    $result = sendLeadNotificationEmail($lead);
    if ($result['ok']) {
        return ['ok' => true, 'error' => null];
    }
    return $result;
}
