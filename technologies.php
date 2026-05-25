<?php
declare(strict_types=1);
require_once __DIR__ . '/config.php';

$settings = readJson('settings.json');
$technologies = sortByOrder(readJson('technologies.json'));
$q = mb_strtolower(trim($_GET['q'] ?? ''));
$catFilter = $_GET['cat'] ?? '';

if ($q) {
    $technologies = array_values(array_filter($technologies, function ($t) use ($q) {
        $hay = mb_strtolower(($t['name'] ?? '') . ' ' . techCategoryLabel($t['category'] ?? ''));
        return str_contains($hay, $q);
    }));
}
if ($catFilter) {
    $technologies = array_values(array_filter($technologies, fn($t) => ($t['category'] ?? '') === $catFilter));
}

$techByCat = [];
foreach ($technologies as $t) {
    $techByCat[$t['category'] ?? 'web'][] = $t;
}
$catOrder = techCategoryOrder();
$allTech = sortByOrder(readJson('technologies.json'));

$pageTitle = 'Texnologiyalar';
$pageDescription = 'MirTech texnologiya stack — PHP, Laravel, Flutter, Proxmox və s.';
$activeNav = 'tech';

require __DIR__ . '/includes/header.php';
?>

<main class="page-main page-list">
  <div class="wrap page-hero page-hero-compact page-list-hero">
    <p class="eyebrow">Stack</p>
    <h1>Texnologiyalar</h1>
    <p class="page-lead page-lead-full"><?= count($allTech) ?> alət və platforma. Axtarış və kateqoriya ilə tapın — yüzlərlə olsa belə.</p>
    <p class="page-lead page-lead-short"><?= count($allTech) ?> alət — kateqoriya və axtarış.</p>
  </div>

  <div class="wrap">
    <form class="filter-bar" method="get" action="<?= url('technologies.php') ?>">
      <div class="filter-search">
        <i class="fa-solid fa-magnifying-glass"></i>
        <input type="search" name="q" value="<?= htmlspecialchars($_GET['q'] ?? '') ?>" placeholder="PHP, Flutter, Linux...">
      </div>
      <select name="cat">
        <option value="">Bütün kateqoriyalar</option>
        <?php foreach ($catOrder as $c): ?>
          <option value="<?= $c ?>" <?= $catFilter === $c ? 'selected' : '' ?>><?= techCategoryLabel($c) ?></option>
        <?php endforeach; ?>
      </select>
      <button type="submit" class="btn btn-primary">Axtar</button>
      <?php if ($q || $catFilter): ?>
        <a href="<?= url('technologies.php') ?>" class="btn btn-ghost">Sıfırla</a>
      <?php endif; ?>
    </form>

    <p class="results-meta"><?= count($technologies) ?> texnologiya göstərilir</p>

    <?php if (empty($technologies)): ?>
      <div class="empty-state">
        <i class="fa-solid fa-microchip"></i>
        <p>Tapılmadı.</p>
      </div>
    <?php else: ?>
      <?php foreach ($catOrder as $cat):
        if (empty($techByCat[$cat])) continue;
      ?>
      <section class="tech-section">
        <h2 class="tech-section-title"><?= techCategoryLabel($cat) ?></h2>
        <div class="tech-grid-full">
          <?php foreach ($techByCat[$cat] as $t): ?>
          <div class="tech-card brand-<?= htmlspecialchars($t['brand'] ?? '') ?>">
            <?= renderTechIcon($t) ?>
            <span title="<?= htmlspecialchars($t['name']) ?>"><?= htmlspecialchars($t['name']) ?></span>
            <?php if (!empty($t['featured'])): ?><em class="tech-star" title="Ana səhifədə">★</em><?php endif; ?>
          </div>
          <?php endforeach; ?>
        </div>
      </section>
      <?php endforeach; ?>
    <?php endif; ?>
  </div>
</main>

<?php require __DIR__ . '/includes/footer.php';
