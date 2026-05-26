<?php
require_once CORE_PATH . '/includes/admin-i18n-ui.php';
requireAuth();
initAdminLang();

$pageTitle = at('nav.leads');
$activeNav = 'leads';
$message = '';

$leads = readJson('leads.json');
$viewId = (int)($_GET['id'] ?? 0);
$viewLead = $viewId > 0 ? findLeadById($leads, $viewId) : null;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['action'] ?? '') === 'delete') {
    adminVerifyCsrf();
    $id = (int)($_POST['id'] ?? 0);
    $leads = array_values(array_filter($leads, fn($l) => (int)($l['id'] ?? 0) !== $id));
    writeJson('leads.json', $leads);
    $message = 'Müraciət silindi.';
    if ($viewId === $id) {
        header('Location: leads.php');
        exit;
    }
    $viewLead = $viewId > 0 ? findLeadById($leads, $viewId) : null;
}

require '_layout.php';
?>

<?php if ($message): ?><div class="adm-alert adm-alert-ok"><?= htmlspecialchars($message) ?></div><?php endif; ?>

<?php if ($viewLead): ?>
<?php
  $detailRows = leadDetailRows($viewLead['details'] ?? []);
  $waUrl = leadWhatsAppUrl($viewLead);
?>
<div class="adm-card adm-lead-detail">
  <div class="adm-lead-detail-head">
    <a href="leads.php" class="adm-btn adm-btn-ghost adm-btn-sm"><i class="fa-solid fa-arrow-left"></i> Siyahıya qayıt</a>
    <div class="adm-lead-detail-actions">
      <a href="<?= htmlspecialchars($waUrl) ?>" class="adm-btn adm-btn-sm" target="_blank" rel="noopener" style="background:#25d366;border-color:#25d366">
        <i class="fa-brands fa-whatsapp"></i> WhatsApp
      </a>
      <?php if (!empty($viewLead['phone'])): ?>
        <a href="tel:<?= htmlspecialchars(preg_replace('/\s+/', '', (string)$viewLead['phone'])) ?>" class="adm-btn adm-btn-ghost adm-btn-sm">
          <i class="fa-solid fa-phone"></i> Zəng et
        </a>
      <?php endif; ?>
      <?php if (!empty($viewLead['email'])): ?>
        <a href="mailto:<?= htmlspecialchars((string)$viewLead['email']) ?>" class="adm-btn adm-btn-ghost adm-btn-sm">
          <i class="fa-solid fa-envelope"></i> Email
        </a>
      <?php endif; ?>
      <form method="post" style="display:inline" onsubmit="return confirm('Bu müraciət silinsin?')">
        <?= adminCsrfField() ?>
        <input type="hidden" name="action" value="delete">
        <input type="hidden" name="id" value="<?= (int)($viewLead['id'] ?? 0) ?>">
        <button type="submit" class="adm-btn adm-btn-danger adm-btn-sm"><i class="fa-solid fa-trash"></i> Sil</button>
      </form>
    </div>
  </div>

  <div class="adm-lead-detail-grid">
    <section class="adm-lead-block">
      <h3>Müştəri</h3>
      <dl class="adm-dl">
        <dt>ID</dt><dd>#<?= (int)($viewLead['id'] ?? 0) ?></dd>
        <dt>Tarix</dt><dd><?= htmlspecialchars($viewLead['created_at'] ?? '') ?></dd>
        <dt>Ad</dt><dd><strong><?= htmlspecialchars($viewLead['name'] ?? '') ?></strong></dd>
        <dt>Telefon</dt><dd><?= htmlspecialchars($viewLead['phone'] ?? '') ?></dd>
        <dt>Email</dt><dd><?= htmlspecialchars($viewLead['email'] ?? '—') ?></dd>
        <dt>Qeyd</dt><dd class="adm-dl-note"><?= nl2br(htmlspecialchars($viewLead['note'] ?? '—')) ?></dd>
      </dl>
    </section>

    <section class="adm-lead-block adm-lead-block-highlight">
      <h3>Təxmini qiymət</h3>
      <p class="adm-lead-price"><?= htmlspecialchars($viewLead['total'] ?? '—') ?></p>
      <p class="adm-lead-type"><?= htmlspecialchars($viewLead['project_type'] ?? '—') ?></p>
      <p class="adm-lead-mail-status">
        <?php if (!empty($viewLead['email_sent'])): ?>
          <span class="badge badge-completed">Email göndərildi</span>
        <?php elseif (isset($viewLead['email_sent']) && !$viewLead['email_sent']): ?>
          <span class="badge badge-started" title="<?= htmlspecialchars($viewLead['email_error'] ?? '') ?>">Email xətası</span>
        <?php else: ?>
          <span style="color:var(--muted);font-size:12px">Email statusu yoxdur</span>
        <?php endif; ?>
      </p>
    </section>
  </div>

  <section class="adm-lead-block adm-lead-block-full">
    <h3>Kalkulyator seçimləri</h3>
    <?php if ($detailRows === []): ?>
      <p style="color:var(--muted);font-size:13px">Detallı seçim məlumatı saxlanmayıb.</p>
    <?php else: ?>
      <dl class="adm-dl adm-dl-grid">
        <?php foreach ($detailRows as [$label, $value]): ?>
          <dt><?= htmlspecialchars($label) ?></dt>
          <dd><?= htmlspecialchars($value) ?></dd>
        <?php endforeach; ?>
      </dl>
    <?php endif; ?>
  </section>

  <?php if (!empty($viewLead['details']) && is_array($viewLead['details'])): ?>
  <details class="adm-lead-raw">
    <summary>Texniki JSON (developer)</summary>
    <pre><?= htmlspecialchars(json_encode($viewLead['details'], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE)) ?></pre>
  </details>
  <?php endif; ?>
</div>
<?php endif; ?>

<div class="adm-card">
  <h2>Kalkulyator müraciətləri <?= $viewLead ? '' : '(' . count($leads) . ')' ?></h2>
  <?php if (empty($leads)): ?>
    <p style="color:var(--muted);font-size:13px">Hələ müraciət yoxdur.</p>
  <?php else: ?>
  <table class="adm-table adm-table-leads">
    <thead>
      <tr>
        <th>Tarix</th>
        <th>Ad</th>
        <th>Telefon</th>
        <th>Layihə</th>
        <th>Qiymət</th>
        <th>Mail</th>
        <th></th>
      </tr>
    </thead>
    <tbody>
    <?php foreach ($leads as $lead):
      $lid = (int)($lead['id'] ?? 0);
      $isActive = $viewLead && $lid === (int)($viewLead['id'] ?? 0);
    ?>
      <tr class="<?= $isActive ? 'is-active' : '' ?>">
        <td><?= htmlspecialchars($lead['created_at'] ?? '') ?></td>
        <td>
          <a href="leads.php?id=<?= $lid ?>" class="adm-lead-link">
            <strong><?= htmlspecialchars($lead['name'] ?? '') ?></strong>
          </a>
        </td>
        <td><?= htmlspecialchars($lead['phone'] ?? '') ?></td>
        <td style="max-width:160px;font-size:12px">
          <?= htmlspecialchars($lead['project_type'] ?? '') ?>
          <?php if (!empty($lead['details']['summary'])): ?>
            <br><span style="color:var(--muted);font-size:11px"><?= htmlspecialchars((string)$lead['details']['summary']) ?></span>
          <?php endif; ?>
        </td>
        <td><strong style="color:var(--head)"><?= htmlspecialchars($lead['total'] ?? '') ?></strong></td>
        <td style="font-size:11px">
          <?php if (!empty($lead['email_sent'])): ?>
            <span class="badge badge-completed">OK</span>
          <?php elseif (isset($lead['email_sent']) && !$lead['email_sent']): ?>
            <span class="badge badge-started" title="<?= htmlspecialchars($lead['email_error'] ?? '') ?>">Xəta</span>
          <?php else: ?>
            <span style="color:var(--muted)">—</span>
          <?php endif; ?>
        </td>
        <td class="adm-lead-row-actions">
          <a href="leads.php?id=<?= $lid ?>" class="adm-btn adm-btn-ghost adm-btn-sm">
            <i class="fa-solid fa-eye"></i> Detallar
          </a>
        </td>
      </tr>
    <?php endforeach; ?>
    </tbody>
  </table>
  <?php endif; ?>
</div>

<?php require '_footer.php';
