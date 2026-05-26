<?php
require_once CORE_PATH . '/includes/admin-i18n-ui.php';
requireAuth();
initAdminLang();

$pageTitle = at('nav.dashboard');
$activeNav = 'dashboard';

$projects = readJson('projects.json');
$services = readJson('services.json');
$leads = readJson('leads.json');

require '_layout.php';
?>

<div class="adm-grid">
  <div class="adm-stat"><div class="adm-stat-n"><?= count($projects) ?></div><div class="adm-stat-l"><?= htmlspecialchars(at('dashboard.projects')) ?></div></div>
  <div class="adm-stat"><div class="adm-stat-n"><?= count($services) ?></div><div class="adm-stat-l"><?= htmlspecialchars(at('dashboard.services')) ?></div></div>
  <div class="adm-stat"><div class="adm-stat-n"><?= count($leads) ?></div><div class="adm-stat-l"><?= htmlspecialchars(at('dashboard.leads')) ?></div></div>
  <div class="adm-stat"><div class="adm-stat-n"><?= count(array_filter($projects, fn($p) => ($p['status'] ?? '') === 'ongoing')) ?></div><div class="adm-stat-l"><?= htmlspecialchars(at('dashboard.active')) ?></div></div>
</div>

<div class="adm-card">
  <h2><?= htmlspecialchars(at('dashboard.recent_leads')) ?></h2>
  <?php if (empty($leads)): ?>
    <p class="adm-hint"><?= htmlspecialchars(at('dashboard.no_leads')) ?></p>
  <?php else: ?>
  <table class="adm-table">
    <thead><tr><th>Tarix</th><th>Ad</th><th>Telefon</th><th>Qiymət</th></tr></thead>
    <tbody>
    <?php foreach (array_slice($leads, 0, 8) as $lead): ?>
      <tr>
        <td><?= htmlspecialchars($lead['created_at'] ?? '') ?></td>
        <td><a href="leads.php?id=<?= (int)($lead['id'] ?? 0) ?>" class="adm-lead-link"><?= htmlspecialchars($lead['name'] ?? '') ?></a></td>
        <td><?= htmlspecialchars($lead['phone'] ?? '') ?></td>
        <td><?= htmlspecialchars($lead['total'] ?? '') ?></td>
      </tr>
    <?php endforeach; ?>
    </tbody>
  </table>
  <p style="margin-top:12px"><a href="leads.php" class="adm-btn adm-btn-ghost">Hamısına bax</a></p>
  <?php endif; ?>
</div>

<?php require '_footer.php';
