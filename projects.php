<?php
declare(strict_types=1);
require_once __DIR__ . '/config.php';

$settings = readJson('settings.json');
$allProjects = sortByOrder(readJson('projects.json'));

$status = isset($_GET['status']) && $_GET['status'] !== '' ? $_GET['status'] : null;
$category = isset($_GET['category']) && $_GET['category'] !== '' ? $_GET['category'] : null;
$q = trim($_GET['q'] ?? '');
$page = max(1, (int)($_GET['page'] ?? 1));
$perPage = 12;

$filtered = filterProjects($allProjects, $status, $category, $q ?: null);
$paged = paginate($filtered, $page, $perPage);
$categories = projectCategories($allProjects);

$pageTitle = 'Layihələr';
$pageDescription = 'MirTech portfolio — bütün layihələr.';
$activeNav = 'projects';

require __DIR__ . '/includes/header.php';

function buildProjectsQuery(array $overrides = []): string
{
    $params = [];
    if ($status = $_GET['status'] ?? '') {
        $params['status'] = $status;
    }
    if ($category = $_GET['category'] ?? '') {
        $params['category'] = $category;
    }
    if ($q = trim($_GET['q'] ?? '')) {
        $params['q'] = $q;
    }
    $params = array_merge($params, $overrides);
    return $params ? '?' . http_build_query($params) : '';
}
?>

<main class="page-main page-list">
  <div class="wrap page-hero page-hero-compact page-list-hero">
    <p class="eyebrow">Portfolio</p>
    <h1>Layihələrimiz</h1>
    <p class="page-lead page-lead-full"><?= count($allProjects) ?> layihə — filtrləyin, axtarın, səhifələyin. Yüzlərlə layihə olsa belə, burada idarə olunur.</p>
    <p class="page-lead page-lead-short"><?= count($allProjects) ?> layihə — filtr və axtarış.</p>
  </div>

  <div class="wrap">
    <form class="filter-bar" method="get" action="<?= url('projects.php') ?>">
      <div class="filter-search">
        <i class="fa-solid fa-magnifying-glass"></i>
        <input type="search" name="q" value="<?= htmlspecialchars($q) ?>" placeholder="Layihə adı, təsvir...">
      </div>
      <select name="status" aria-label="Status">
        <option value="">Bütün statuslar</option>
        <?php foreach (['started' => 'Başlandı', 'ongoing' => 'Davam edir', 'completed' => 'Tamamlandı'] as $k => $v): ?>
          <option value="<?= $k ?>" <?= $status === $k ? 'selected' : '' ?>><?= $v ?></option>
        <?php endforeach; ?>
      </select>
      <select name="category" aria-label="Kateqoriya">
        <option value="">Bütün kateqoriyalar</option>
        <?php foreach ($categories as $cat): ?>
          <option value="<?= htmlspecialchars($cat) ?>" <?= $category === $cat ? 'selected' : '' ?>><?= htmlspecialchars($cat) ?></option>
        <?php endforeach; ?>
      </select>
      <button type="submit" class="btn btn-primary">Filtr</button>
      <?php if ($status || $category || $q): ?>
        <a href="<?= url('projects.php') ?>" class="btn btn-ghost">Sıfırla</a>
      <?php endif; ?>
    </form>

    <p class="results-meta"><?= $paged['total'] ?> nəticə · səhifə <?= $paged['page'] ?> / <?= $paged['total_pages'] ?></p>

    <?php if (empty($paged['items'])): ?>
      <div class="empty-state">
        <i class="fa-solid fa-folder-open"></i>
        <p>Heç bir layihə tapılmadı.</p>
        <a href="<?= url('projects.php') ?>" class="btn btn-ghost">Filtrləri təmizlə</a>
      </div>
    <?php else: ?>
    <div class="projects-grid">
      <?php foreach ($paged['items'] as $p):
        include __DIR__ . '/includes/project-card.php';
      endforeach; ?>
    </div>

    <?php if ($paged['total_pages'] > 1): ?>
    <nav class="pagination" aria-label="Səhifələr">
      <?php if ($paged['page'] > 1): ?>
        <a href="<?= url('projects.php') . buildProjectsQuery(['page' => $paged['page'] - 1]) ?>" class="btn btn-ghost"><i class="fa-solid fa-chevron-left"></i></a>
      <?php endif; ?>
      <?php
      $start = max(1, $paged['page'] - 2);
      $end = min($paged['total_pages'], $paged['page'] + 2);
      for ($i = $start; $i <= $end; $i++):
      ?>
        <a href="<?= url('projects.php') . buildProjectsQuery(['page' => $i]) ?>" class="page-num <?= $i === $paged['page'] ? 'is-active' : '' ?>"><?= $i ?></a>
      <?php endfor; ?>
      <?php if ($paged['page'] < $paged['total_pages']): ?>
        <a href="<?= url('projects.php') . buildProjectsQuery(['page' => $paged['page'] + 1]) ?>" class="btn btn-ghost"><i class="fa-solid fa-chevron-right"></i></a>
      <?php endif; ?>
    </nav>
    <?php endif; ?>
    <?php endif; ?>
  </div>
</main>

<?php require __DIR__ . '/includes/footer.php';
