<?php
declare(strict_types=1);
require_once dirname(__DIR__) . '/config.php';
requireAuth();

$pageTitle = 'Müraciətlər';
$activeNav = 'leads';
$message = '';

$leads = readJson('leads.json');

if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['action'] ?? '') === 'delete') {
    $id = (int)($_POST['id'] ?? 0);
    $leads = array_values(array_filter($leads, fn($l) => (int)($l['id'] ?? 0) !== $id));
    writeJson('leads.json', $leads);
    $message = 'Müraciət silindi.';
}

require '_layout.php';
?>

<?php if ($message): ?><div class="adm-alert adm-alert-ok"><?= htmlspecialchars($message) ?></div><?php endif; ?>

<div class="adm-card">
  <h2>Kalkulyator / əlaqə müraciətləri</h2>
  <?php if (empty($leads)): ?>
    <p style="color:var(--muted);font-size:13px">Hələ müraciət yoxdur.</p>
  <?php else: ?>
  <table class="adm-table">
    <thead>
      <tr>
        <th>Tarix</th><th>Ad</th><th>Telefon</th><th>Email</th>
        <th>Layihə</th><th>Qiymət</th><th>Mail</th><th>Qeyd</th><th></th>
      </tr>
    </thead>
    <tbody>
    <?php foreach ($leads as $lead): ?>
      <tr>
        <td><?= htmlspecialchars($lead['created_at'] ?? '') ?></td>
        <td><?= htmlspecialchars($lead['name'] ?? '') ?></td>
        <td><?= htmlspecialchars($lead['phone'] ?? '') ?></td>
        <td><?= htmlspecialchars($lead['email'] ?? '') ?></td>
        <td style="max-width:140px;font-size:12px">
          <?= htmlspecialchars($lead['project_type'] ?? '') ?>
          <?php if (!empty($lead['details']['summary'])): ?>
            <br><span style="color:var(--muted);font-size:11px"><?= htmlspecialchars((string)$lead['details']['summary']) ?></span>
          <?php endif; ?>
        </td>
        <td><?= htmlspecialchars($lead['total'] ?? '') ?></td>
        <td style="font-size:11px">
          <?php if (!empty($lead['email_sent'])): ?>
            <span class="badge badge-completed">Göndərildi</span>
          <?php elseif (isset($lead['email_sent']) && !$lead['email_sent']): ?>
            <span class="badge badge-started" title="<?= htmlspecialchars($lead['email_error'] ?? '') ?>">Mail xətası</span>
          <?php else: ?>
            <span style="color:var(--muted)">—</span>
          <?php endif; ?>
        </td>
        <td style="max-width:180px;font-size:12px"><?= htmlspecialchars($lead['note'] ?? '') ?></td>
        <td>
          <form method="post" onsubmit="return confirm('Silinsin?')">
            <input type="hidden" name="action" value="delete">
            <input type="hidden" name="id" value="<?= (int)($lead['id'] ?? 0) ?>">
            <button type="submit" class="adm-btn adm-btn-danger" style="padding:6px 10px;font-size:12px">Sil</button>
          </form>
        </td>
      </tr>
    <?php endforeach; ?>
    </tbody>
  </table>
  <?php endif; ?>
</div>

<?php require '_footer.php';
