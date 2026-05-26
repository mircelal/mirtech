<main class="page-main project-detail">
  <div class="wrap">
    <nav class="breadcrumb" aria-label="Breadcrumb">
      <a href="<?= url() ?>"><?= htmlspecialchars(t('project.breadcrumb_home')) ?></a>
      <span>/</span>
      <a href="<?= url('projects.php') ?>"><?= htmlspecialchars(t('project.breadcrumb_projects')) ?></a>
      <span>/</span>
      <span><?= htmlspecialchars($pName) ?></span>
    </nav>
  </div>

  <header class="proj-hero wrap">
    <div class="proj-hero-grid">
      <div class="proj-hero-text">
        <span class="proj-badge-lg <?= htmlspecialchars($status) ?>"><?= projectStatusLabel($status) ?></span>
        <h1><?= htmlspecialchars($pName) ?></h1>
        <p class="proj-hero-desc"><?= htmlspecialchars($pDesc) ?></p>
        <div class="proj-hero-meta">
          <span><i class="fa-solid fa-folder"></i> <?= htmlspecialchars($pCategory) ?></span>
          <span><i class="fa-solid fa-calendar"></i> <?= (int)($project['year'] ?? 0) ?></span>
          <?php if ($pDuration !== ''): ?>
            <span><i class="fa-solid fa-clock"></i> <?= htmlspecialchars($pDuration) ?></span>
          <?php endif; ?>
        </div>
        <div class="proj-hero-actions">
          <?php if (!empty($project['url'])): ?>
            <a href="<?= htmlspecialchars($project['url']) ?>" class="btn btn-primary" target="_blank" rel="noopener">
              <?= htmlspecialchars(t('project.visit')) ?> <i class="fa-solid fa-arrow-up-right-from-square"></i>
            </a>
          <?php endif; ?>
          <a href="<?= url('calculator.php') ?>" class="btn btn-ghost"><?= htmlspecialchars(t('nav.calculator')) ?></a>
        </div>
      </div>
      <div class="proj-hero-visual">
        <?php if ($img && publicFileExists($img)): ?>
          <img src="<?= asset($img) ?>" alt="<?= htmlspecialchars($pName) ?>" class="proj-hero-img" width="800" height="480" decoding="async" fetchpriority="high">
        <?php else: ?>
          <div class="proj-hero-placeholder"><i class="fa-solid fa-diagram-project"></i></div>
        <?php endif; ?>
        <?php $overall = projectOverallProgress($project); ?>
        <div class="progress-ring" style="--p: <?= $overall ?>" data-progress="<?= $overall ?>">
          <div class="progress-ring-inner">
            <strong><?= $overall ?>%</strong>
            <span><?= htmlspecialchars(t('project.progress')) ?></span>
          </div>
        </div>
      </div>
    </div>
  </header>

  <section class="wrap proj-section">
    <div class="proj-layout">
      <div class="proj-main-col">
        <?php if ($pOverview !== ''): ?>
        <div class="proj-block">
          <h2><i class="fa-solid fa-file-lines"></i> <?= htmlspecialchars(t('project.overview')) ?></h2>
          <p class="proj-overview"><?= nl2br(htmlspecialchars($pOverview)) ?></p>
        </div>
        <?php endif; ?>

        <?php if ($stats): ?>
        <div class="proj-block">
          <h2><i class="fa-solid fa-chart-column"></i> <?= htmlspecialchars(t('project.stats')) ?></h2>
          <div class="chart-grid">
            <?php foreach ($stats as $i => $st):
              $val = $st['value'] ?? '0';
              $max = (int)($st['max'] ?? 100);
              $num = (float)preg_replace('/[^0-9.]/', '', (string)$val);
              $pct = $max > 0 ? min(100, (int)round(($num / $max) * 100)) : 50;
            ?>
            <div class="chart-card" data-animate-bar>
              <div class="chart-card-head">
                <span><?= htmlspecialchars($st['label'] ?? '') ?></span>
                <strong><?= htmlspecialchars($val) ?></strong>
              </div>
              <div class="chart-bar"><span style="--w: <?= $pct ?>%"></span></div>
            </div>
            <?php endforeach; ?>
          </div>
        </div>
        <?php endif; ?>

        <?php if ($timeline): ?>
        <div class="proj-block">
          <h2><i class="fa-solid fa-road"></i> <?= htmlspecialchars(t('project.timeline')) ?></h2>
          <div class="timeline">
            <?php foreach ($timeline as $i => $step):
              $st = $step['status'] ?? 'pending';
            ?>
            <div class="timeline-item <?= htmlspecialchars($st) ?>">
              <div class="timeline-marker">
                <span class="timeline-dot"></span>
                <?php if ($i < count($timeline) - 1): ?><span class="timeline-line"></span><?php endif; ?>
              </div>
              <div class="timeline-body">
                <div class="timeline-head">
                  <h3><?= htmlspecialchars($step['title'] ?? '') ?></h3>
                  <span class="timeline-pct"><?= (int)($step['progress'] ?? 0) ?>%</span>
                </div>
                <?php if (!empty($step['desc'])): ?>
                  <p><?= htmlspecialchars($step['desc']) ?></p>
                <?php endif; ?>
                <div class="timeline-bar"><span style="--w: <?= (int)($step['progress'] ?? 0) ?>%"></span></div>
              </div>
            </div>
            <?php endforeach; ?>
          </div>
        </div>
        <?php endif; ?>

        <?php if ($features): ?>
        <div class="proj-block">
          <h2><i class="fa-solid fa-check-double"></i> <?= htmlspecialchars(t('project.features')) ?></h2>
          <ul class="feature-list">
            <?php foreach ($features as $f): ?>
              <li><i class="fa-solid fa-circle-check"></i> <?= htmlspecialchars($f) ?></li>
            <?php endforeach; ?>
          </ul>
        </div>
        <?php endif; ?>
      </div>

      <aside class="proj-aside">
        <?php if ($techs): ?>
        <div class="aside-card">
          <h3><?= htmlspecialchars(t('nav.tech')) ?></h3>
          <div class="tech-stack-list">
            <?php foreach ($techs as $t):
              $tName = localized($t, 'name') ?: ($t['name'] ?? '');
            ?>
            <span class="tech-stack-item brand-<?= htmlspecialchars($t['brand'] ?? '') ?>">
              <?= renderTechIcon($t) ?>
              <?= htmlspecialchars($tName) ?>
            </span>
            <?php endforeach; ?>
          </div>
          <a href="<?= url('technologies.php') ?>" class="aside-link"><?= htmlspecialchars(t('home.tech.all')) ?> →</a>
        </div>
        <?php endif; ?>

        <div class="aside-card aside-cta">
          <h3><?= htmlspecialchars(t('project.related')) ?></h3>
          <p><?= htmlspecialchars(t('calc.lead_short')) ?></p>
          <a href="<?= url('calculator.php') ?>" class="btn btn-primary btn-block"><?= htmlspecialchars(t('nav.calculator')) ?></a>
          <?php $sc = siteContact(); ?>
          <a href="<?= htmlspecialchars($sc['whatsapp_link']) ?>" class="btn btn-ghost btn-block" target="_blank" rel="noopener">
            <i class="fa-brands fa-whatsapp"></i> WhatsApp
          </a>
        </div>
      </aside>
    </div>
  </section>

  <?php if ($related): ?>
  <section class="wrap proj-related">
    <h2><?= htmlspecialchars(t('project.related')) ?></h2>
    <div class="projects-grid">
      <?php foreach ($related as $i => $p):
        $projectCardPriority = $i === 0;
        include VIEWS_PATH . '/partials/project-card.php';
      endforeach; ?>
    </div>
  </section>
  <?php endif; ?>
</main>
