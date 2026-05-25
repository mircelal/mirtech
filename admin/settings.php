<?php
declare(strict_types=1);
require_once dirname(__DIR__) . '/config.php';
requireAuth();

$pageTitle = 'Parametrlər';
$activeNav = 'settings';
$message = '';

$settings = readJson('settings.json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $settings['hero_eyebrow'] = trim($_POST['hero_eyebrow'] ?? '');
    $settings['hero_title'] = trim($_POST['hero_title'] ?? '');
    $settings['hero_title_highlight'] = trim($_POST['hero_title_highlight'] ?? '');
    $settings['hero_subtitle'] = trim($_POST['hero_subtitle'] ?? '');
    $settings['footer_year'] = (int)($_POST['footer_year'] ?? date('Y'));

    $settings['contact']['whatsapp'] = trim($_POST['whatsapp'] ?? '');
    $settings['contact']['whatsapp_raw'] = preg_replace('/\D/', '', $_POST['whatsapp_raw'] ?? '');
    $settings['contact']['email'] = trim($_POST['email'] ?? '');
    $settings['contact']['website'] = trim($_POST['website'] ?? '');
    $settings['contact']['website_url'] = trim($_POST['website_url'] ?? '');

    $stats = [];
    for ($i = 0; $i < 4; $i++) {
        if (!empty($_POST['stat_value'][$i])) {
            $stats[] = [
                'value' => trim($_POST['stat_value'][$i]),
                'suffix' => trim($_POST['stat_suffix'][$i] ?? ''),
                'label' => trim($_POST['stat_label'][$i] ?? ''),
                'color' => $_POST['stat_color'][$i] ?? 'blue',
            ];
        }
    }
    if ($stats) {
        $settings['stats'] = $stats;
    }

    $settings['homepage'] = [
        'projects_limit' => (int)($_POST['hp_projects'] ?? 6),
        'technologies_limit' => (int)($_POST['hp_technologies'] ?? 10),
        'services_limit' => (int)($_POST['hp_services'] ?? 4),
    ];

    $oldSmtp = $settings['smtp'] ?? [];
    $smtpPass = trim($_POST['smtp_password'] ?? '');
    $settings['smtp'] = [
        'enabled' => !empty($_POST['smtp_enabled']),
        'host' => trim($_POST['smtp_host'] ?? ''),
        'port' => (int)($_POST['smtp_port'] ?? 587),
        'encryption' => $_POST['smtp_encryption'] ?? 'tls',
        'username' => trim($_POST['smtp_username'] ?? ''),
        'password' => $smtpPass !== '' ? $smtpPass : (string)($oldSmtp['password'] ?? ''),
        'from_email' => trim($_POST['smtp_from_email'] ?? ''),
        'from_name' => trim($_POST['smtp_from_name'] ?? 'MirTech'),
        'notify_email' => trim($_POST['smtp_notify_email'] ?? ''),
    ];

    writeJson('settings.json', $settings);
    $message = 'Parametrlər saxlanıldı.';
}

$stats = $settings['stats'] ?? [];
$contact = $settings['contact'] ?? [];
$smtp = $settings['smtp'] ?? [];
$smtpEnabled = !empty($smtp['enabled']);

require '_layout.php';
?>

<?php if ($message): ?><div class="adm-alert adm-alert-ok"><?= htmlspecialchars($message) ?></div><?php endif; ?>

<form class="adm-form adm-card" method="post">
  <h2>Hero bölməsi</h2>
  <label>Eyebrow</label>
  <input name="hero_eyebrow" value="<?= htmlspecialchars($settings['hero_eyebrow'] ?? '') ?>">
  <label>Başlıq (1-ci sətir)</label>
  <input name="hero_title" value="<?= htmlspecialchars($settings['hero_title'] ?? '') ?>">
  <label>Başlıq (vurğulu)</label>
  <input name="hero_title_highlight" value="<?= htmlspecialchars($settings['hero_title_highlight'] ?? '') ?>">
  <label>Alt mətn</label>
  <textarea name="hero_subtitle"><?= htmlspecialchars($settings['hero_subtitle'] ?? '') ?></textarea>

  <h2 style="margin-top:24px">Statistika (4 ədəd)</h2>
  <?php for ($i = 0; $i < 4; $i++):
    $st = $stats[$i] ?? ['value'=>'','suffix'=>'','label'=>'','color'=>'blue'];
  ?>
  <div class="adm-row" style="margin-top:12px">
    <div><label>Dəyər</label><input name="stat_value[]" value="<?= htmlspecialchars($st['value']) ?>"></div>
    <div><label>Suffix (+, %)</label><input name="stat_suffix[]" value="<?= htmlspecialchars($st['suffix'] ?? '') ?>"></div>
    <div><label>Etiket</label><input name="stat_label[]" value="<?= htmlspecialchars($st['label'] ?? '') ?>"></div>
    <div>
      <label>Rəng</label>
      <select name="stat_color[]">
        <?php foreach (['blue','teal','amber','purple'] as $c): ?>
          <option value="<?= $c ?>" <?= ($st['color'] ?? '') === $c ? 'selected' : '' ?>><?= $c ?></option>
        <?php endforeach; ?>
      </select>
    </div>
  </div>
  <?php endfor; ?>

  <h2 style="margin-top:24px">Əlaqə</h2>
  <div class="adm-row">
    <div><label>WhatsApp (göstərilən)</label><input name="whatsapp" value="<?= htmlspecialchars($contact['whatsapp'] ?? '') ?>"></div>
    <div><label>WhatsApp (rəqəm)</label><input name="whatsapp_raw" value="<?= htmlspecialchars($contact['whatsapp_raw'] ?? '') ?>"></div>
  </div>
  <label>Email</label>
  <input name="email" value="<?= htmlspecialchars($contact['email'] ?? '') ?>">
  <div class="adm-row">
    <div><label>Sayt adı</label><input name="website" value="<?= htmlspecialchars($contact['website'] ?? '') ?>"></div>
    <div><label>Sayt URL</label><input name="website_url" value="<?= htmlspecialchars($contact['website_url'] ?? '') ?>"></div>
  </div>
  <label>Footer il</label>
  <input type="number" name="footer_year" value="<?= (int)($settings['footer_year'] ?? date('Y')) ?>">

  <h2 style="margin-top:24px">Ana səhifə limitləri</h2>
  <p style="font-size:12px;color:var(--muted);margin-bottom:12px">Yüzlərlə layihə olsa belə, ana səhifədə yalnız «seçilmiş» + limit qədər göstərilir.</p>
  <?php $hp = $settings['homepage'] ?? []; ?>
  <div class="adm-row">
    <div><label>Seçilmiş layihə (max)</label><input type="number" name="hp_projects" min="1" max="12" value="<?= (int)($hp['projects_limit'] ?? 6) ?>"></div>
    <div><label>Seçilmiş texnologiya (max)</label><input type="number" name="hp_technologies" min="1" max="20" value="<?= (int)($hp['technologies_limit'] ?? 10) ?>"></div>
    <div><label>Seçilmiş xidmət (max)</label><input type="number" name="hp_services" min="1" max="8" value="<?= (int)($hp['services_limit'] ?? 4) ?>"></div>
  </div>
  <h2 style="margin-top:32px">SMTP — təklif bildirişi</h2>
  <p style="font-size:12px;color:var(--muted);margin-bottom:16px">
    Kalkulyatordan təklif göndəriləndə seçilmiş emailə avtomatik xəbərdarlıq gedir.
    Gmail üçün: <strong>2FA</strong> + <a href="https://myaccount.google.com/apppasswords" target="_blank" rel="noopener">tətbiq şifrəsi</a>.
  </p>
  <label style="display:flex;align-items:center;gap:8px;margin-bottom:16px">
    <input type="checkbox" name="smtp_enabled" value="1" <?= $smtpEnabled ? 'checked' : '' ?>>
    SMTP aktiv (təklifləri emailə göndər)
  </label>
  <label>Bildiriş alacaq email (sizin ünvanınız)</label>
  <input type="email" name="smtp_notify_email" placeholder="<?= htmlspecialchars($contact['email'] ?? 'info@mirtech.az') ?>" value="<?= htmlspecialchars($smtp['notify_email'] ?? '') ?>">
  <p style="font-size:11px;color:var(--muted);margin:-8px 0 12px">Boş buraxsanız, «Əlaqə email» istifadə olunur.</p>
  <div class="adm-row">
    <div><label>SMTP server</label><input name="smtp_host" value="<?= htmlspecialchars($smtp['host'] ?? 'smtp.gmail.com') ?>" placeholder="smtp.gmail.com"></div>
    <div><label>Port</label><input type="number" name="smtp_port" value="<?= (int)($smtp['port'] ?? 587) ?>"></div>
    <div>
      <label>Şifrələmə</label>
      <select name="smtp_encryption">
        <?php foreach (['tls' => 'TLS (587)', 'ssl' => 'SSL (465)', 'none' => 'Yoxdur (25)'] as $k => $v): ?>
          <option value="<?= $k ?>" <?= ($smtp['encryption'] ?? 'tls') === $k ? 'selected' : '' ?>><?= $v ?></option>
        <?php endforeach; ?>
      </select>
    </div>
  </div>
  <div class="adm-row">
    <div><label>SMTP istifadəçi</label><input name="smtp_username" autocomplete="off" value="<?= htmlspecialchars($smtp['username'] ?? '') ?>" placeholder="email@gmail.com"></div>
    <div><label>SMTP şifrə</label><input type="password" name="smtp_password" autocomplete="new-password" placeholder="<?= !empty($smtp['password']) ? '•••••••• (saxlanılıb)' : 'Tətbiq şifrəsi' ?>"></div>
  </div>
  <div class="adm-row">
    <div><label>Göndərən email</label><input type="email" name="smtp_from_email" value="<?= htmlspecialchars($smtp['from_email'] ?? '') ?>" placeholder="noreply@mirtech.az"></div>
    <div><label>Göndərən ad</label><input name="smtp_from_name" value="<?= htmlspecialchars($smtp['from_name'] ?? 'MirTech') ?>"></div>
  </div>

  <div class="adm-actions">
    <button type="submit" class="adm-btn">Saxla</button>
    <button type="button" class="adm-btn adm-btn-ghost" id="btnSmtpTest">Test email göndər</button>
  </div>
  <p id="smtpTestResult" style="font-size:13px;margin-top:10px;display:none"></p>
</form>

<script>
(function () {
  const btn = document.getElementById('btnSmtpTest');
  const out = document.getElementById('smtpTestResult');
  if (!btn) return;
  btn.addEventListener('click', async function () {
    btn.disabled = true;
    out.style.display = 'block';
    out.textContent = 'Göndərilir... (əvvəlcə parametrləri Saxla)';
    out.style.color = 'var(--muted)';
    try {
      const r = await fetch('smtp-test.php', { method: 'POST', credentials: 'same-origin' });
      const data = await r.json();
      if (data.ok) {
        out.style.color = 'var(--teal)';
        out.textContent = 'Test mesajı göndərildi. Gelen qutusunu yoxlayın (spam da baxın).';
      } else {
        out.style.color = 'var(--red)';
        out.textContent = 'Xəta: ' + (data.error || 'naməlum');
      }
    } catch (e) {
      out.style.color = 'var(--red)';
      out.textContent = 'Şəbəkə xətası';
    }
    btn.disabled = false;
  });
})();
</script>

<?php require '_footer.php';
