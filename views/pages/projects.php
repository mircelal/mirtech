<main class="page-main page-list">
  <div class="wrap page-hero page-hero-compact page-list-hero">
    <p class="eyebrow"><?= htmlspecialchars(t('projects.portfolio')) ?></p>
    <h1><?= htmlspecialchars(t('projects.heading')) ?></h1>
    <p class="page-lead page-lead-full"><?= htmlspecialchars(t('projects.lead', ['n' => (string)count($allProjects)])) ?></p>
    <p class="page-lead page-lead-short"><?= htmlspecialchars(t('projects.lead_short', ['n' => (string)count($allProjects)])) ?></p>
  </div>

  <div class="wrap">
    <form class="filter-bar" method="get" action="<?= queryUrl('projects.php') ?>">
      <div class="filter-search">
        <i class="fa-solid fa-magnifying-glass"></i>
        <input type="search" name="q" value="<?= htmlspecialchars($q) ?>" placeholder="<?= htmlspecialchars(t('projects.search')) ?>">
      </div>
      <select name="status" aria-label="Status">
        <option value=""><?= htmlspecialchars(t('projects.all_status')) ?></option>
        <?php foreach (['started', 'ongoing', 'completed'] as $k): ?>
          <option value="<?= $k ?>" <?= $status === $k ? 'selected' : '' ?>><?= htmlspecialchars(projectStatusLabel($k)) ?></option>
        <?php endforeach; ?>
      </select>
      <select name="category" aria-label="Category">
        <option value=""><?= htmlspecialchars(t('projects.all_categories')) ?></option>
        <?php foreach ($categories as $cat): ?>
          <option value="<?= htmlspecialchars($cat) ?>" <?= $category === $cat ? 'selected' : '' ?>><?= htmlspecialchars($cat) ?></option>
        <?php endforeach; ?>
      </select>
      <button type="submit" class="btn btn-primary"><?= htmlspecialchars(t('projects.filter_btn')) ?></button>
      <?php if ($status || $category || $q): ?>
        <a href="<?= url('projects.php') ?>" class="btn btn-ghost"><?= htmlspecialchars(t('projects.reset')) ?></a>
      <?php endif; ?>
    </form>

    <p class="results-meta"><?= htmlspecialchars(t('projects.results_page', [
        'n' => (string)$paged['total'],
        'page' => (string)$paged['page'],
        'total' => (string)$paged['total_pages'],
    ])) ?></p>

    <?php if (empty($paged['items'])): ?>
      <div class="empty-state">
        <i class="fa-solid fa-folder-open"></i>
        <p><?= htmlspecialchars(t('projects.empty')) ?></p>
        <a href="<?= url('projects.php') ?>" class="btn btn-ghost"><?= htmlspecialchars(t('projects.reset')) ?></a>
      </div>
    <?php else: ?>
    <div class="projects-grid">
      <?php foreach ($paged['items'] as $i => $p):
        $projectCardPriority = $i < 4;
        include VIEWS_PATH . '/partials/project-card.php';
      endforeach; ?>
    </div>

    <?php if ($paged['total_pages'] > 1): ?>
    <nav class="pagination" aria-label="<?= htmlspecialchars(t('projects.pagination')) ?>">
      <?php if ($paged['page'] > 1): ?>
        <a href="<?= queryUrl('projects.php', ['status' => $status, 'category' => $category, 'q' => $q ?: null, 'page' => $paged['page'] - 1]) ?>" class="btn btn-ghost"><i class="fa-solid fa-chevron-left"></i></a>
      <?php endif; ?>
      <?php
      $start = max(1, $paged['page'] - 2);
      $end = min($paged['total_pages'], $paged['page'] + 2);
      for ($i = $start; $i <= $end; $i++):
        $pageParams = array_filter(['status' => $status, 'category' => $category, 'q' => $q ?: null, 'page' => $i], fn($v) => $v !== null && $v !== '');
      ?>
        <a href="<?= queryUrl('projects.php', $pageParams) ?>" class="page-num <?= $i === $paged['page'] ? 'is-active' : '' ?>"><?= $i ?></a>
      <?php endfor; ?>
      <?php if ($paged['page'] < $paged['total_pages']): ?>
        <a href="<?= queryUrl('projects.php', ['status' => $status, 'category' => $category, 'q' => $q ?: null, 'page' => $paged['page'] + 1]) ?>" class="btn btn-ghost"><i class="fa-solid fa-chevron-right"></i></a>
      <?php endif; ?>
    </nav>
    <?php endif; ?>
    <?php endif; ?>
  </div>
</main>
