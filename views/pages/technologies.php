<main class="page-main page-list">
  <div class="wrap page-hero page-hero-compact page-list-hero">
    <p class="eyebrow">Stack</p>
    <h1><?= htmlspecialchars(t('tech.title')) ?></h1>
    <p class="page-lead page-lead-full"><?= htmlspecialchars(t('tech.lead', ['n' => (string)count($allTech)])) ?></p>
    <p class="page-lead page-lead-short"><?= htmlspecialchars(t('tech.lead_short', ['n' => (string)count($allTech)])) ?></p>
  </div>

  <div class="wrap">
    <form class="filter-bar" method="get" action="<?= queryUrl('technologies.php') ?>">
      <div class="filter-search">
        <i class="fa-solid fa-magnifying-glass"></i>
        <input type="search" name="q" value="<?= htmlspecialchars($_GET['q'] ?? '') ?>" placeholder="<?= htmlspecialchars(t('tech.search')) ?>">
      </div>
      <select name="cat">
        <option value=""><?= htmlspecialchars(t('tech.all_cats')) ?></option>
        <?php foreach ($catOrder as $c): ?>
          <option value="<?= $c ?>" <?= $catFilter === $c ? 'selected' : '' ?>><?= techCategoryLabel($c) ?></option>
        <?php endforeach; ?>
      </select>
      <button type="submit" class="btn btn-primary"><?= htmlspecialchars(t('projects.search_btn')) ?></button>
      <?php if ($q || $catFilter): ?>
        <a href="<?= url('technologies.php') ?>" class="btn btn-ghost"><?= htmlspecialchars(t('projects.reset')) ?></a>
      <?php endif; ?>
    </form>

    <p class="results-meta"><?= htmlspecialchars(t('tech.results', ['n' => (string)count($technologies)])) ?></p>

    <?php if (empty($technologies)): ?>
      <div class="empty-state">
        <i class="fa-solid fa-microchip"></i>
        <p><?= htmlspecialchars(t('tech.empty')) ?></p>
      </div>
    <?php else: ?>
      <?php foreach ($catOrder as $cat):
        if (empty($techByCat[$cat])) continue;
      ?>
      <section class="tech-section">
        <h2 class="tech-section-title"><?= techCategoryLabel($cat) ?></h2>
        <div class="tech-grid-full">
          <?php foreach ($techByCat[$cat] as $t):
            $tName = localized($t, 'name') ?: ($t['name'] ?? '');
          ?>
          <div class="tech-card brand-<?= htmlspecialchars($t['brand'] ?? '') ?>">
            <?= renderTechIcon($t) ?>
            <span title="<?= htmlspecialchars($tName) ?>"><?= htmlspecialchars($tName) ?></span>
            <?php if (!empty($t['featured'])): ?><em class="tech-star" title="★">★</em><?php endif; ?>
          </div>
          <?php endforeach; ?>
        </div>
      </section>
      <?php endforeach; ?>
    <?php endif; ?>
  </div>
</main>
