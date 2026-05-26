<main>
  <section class="hero-home">
    <div class="wrap hero-home-inner">
      <p class="pill"><?= htmlspecialchars($settings['hero_eyebrow'] ?? '') ?></p>
      <h1><?= htmlspecialchars($settings['hero_title'] ?? '') ?><br><em><?= htmlspecialchars($settings['hero_title_highlight'] ?? '') ?></em></h1>
      <p class="hero-lead"><?= htmlspecialchars($settings['hero_subtitle'] ?? '') ?></p>
      <div class="hero-cta-row">
        <a href="<?= url('calculator.php') ?>" class="btn btn-primary btn-lg"><i class="fa-solid fa-calculator"></i> <?= htmlspecialchars(t('home.hero.calc')) ?></a>
        <a href="<?= url('projects.php') ?>" class="btn btn-ghost btn-lg"><?= htmlspecialchars(t('home.hero.projects')) ?></a>
      </div>
      <div class="stats-row">
        <?php foreach ($settings['stats'] ?? [] as $st): ?>
        <div class="stat-chip">
          <strong class="<?= statColorClass($st['color'] ?? 'blue') ?>"><?= htmlspecialchars($st['value']) ?><?= htmlspecialchars($st['suffix'] ?? '') ?></strong>
          <span><?= htmlspecialchars($st['label'] ?? '') ?></span>
        </div>
        <?php endforeach; ?>
      </div>
    </div>
  </section>

  <section class="section-tight">
    <div class="wrap">
      <div class="bento-nav">
        <a href="<?= url('projects.php') ?>" class="bento-tile bento-large">
          <i class="fa-solid fa-folder-open"></i>
          <span class="bento-title"><?= htmlspecialchars(t('home.bento.projects')) ?></span>
          <span class="bento-meta"><?= htmlspecialchars(t('home.bento.projects_meta', ['n' => (string)$totalProjects])) ?></span>
        </a>
        <a href="<?= url('calculator.php') ?>" class="bento-tile">
          <i class="fa-solid fa-wand-magic-sparkles"></i>
          <span class="bento-title"><?= htmlspecialchars(t('home.bento.calc')) ?></span>
          <span class="bento-meta"><?= htmlspecialchars(t('home.bento.calc_meta')) ?></span>
        </a>
        <a href="<?= url('technologies.php') ?>" class="bento-tile">
          <i class="fa-solid fa-microchip"></i>
          <span class="bento-title"><?= htmlspecialchars(t('home.bento.stack')) ?></span>
          <span class="bento-meta"><?= htmlspecialchars(t('home.bento.stack_meta', ['n' => (string)$totalTech])) ?></span>
        </a>
        <a href="<?= url() ?>#contact" class="bento-tile">
          <i class="fa-brands fa-whatsapp"></i>
          <span class="bento-title"><?= htmlspecialchars(t('home.bento.contact')) ?></span>
          <span class="bento-meta"><?= htmlspecialchars(t('home.bento.contact_meta')) ?></span>
        </a>
      </div>
    </div>
  </section>

  <section class="section">
    <div class="wrap section-head-row">
      <div>
        <p class="eyebrow"><?= htmlspecialchars(t('home.featured.eyebrow')) ?></p>
        <h2><?= htmlspecialchars(t('home.featured.title')) ?></h2>
      </div>
      <a href="<?= url('projects.php') ?>" class="link-arrow"><?= htmlspecialchars(t('home.featured.all', ['n' => (string)$totalProjects])) ?> <i class="fa-solid fa-arrow-right"></i></a>
    </div>
    <div class="wrap projects-grid">
      <?php foreach ($featuredProjects as $i => $p):
        $projectCardPriority = $i < 2;
        include VIEWS_PATH . '/partials/project-card.php';
      endforeach; ?>
    </div>
  </section>

  <section class="section section-alt tech-home-section">
    <div class="wrap section-head-row">
      <div>
        <p class="eyebrow"><?= htmlspecialchars(t('home.tech.eyebrow')) ?></p>
        <h2><?= htmlspecialchars(t('home.tech.title')) ?></h2>
      </div>
      <a href="<?= url('technologies.php') ?>" class="link-arrow tech-home-more"><?= htmlspecialchars(t('home.tech.all')) ?> <i class="fa-solid fa-arrow-right"></i></a>
    </div>
    <div class="wrap tech-marquee-wrap">
      <div class="tech-marquee" role="list">
      <?php foreach ($featuredTech as $t):
        $tName = localized($t, 'name') ?: ($t['name'] ?? '');
      ?>
      <span class="tech-pill brand-<?= htmlspecialchars($t['brand'] ?? '') ?>" role="listitem">
        <?= renderTechIcon($t) ?>
        <span class="tech-pill-name"><?= htmlspecialchars($tName) ?></span>
      </span>
      <?php endforeach; ?>
      </div>
    </div>
  </section>

  <section class="section">
    <div class="wrap section-head-row">
      <div>
        <p class="eyebrow"><?= htmlspecialchars(t('home.services.eyebrow')) ?></p>
        <h2><?= htmlspecialchars(t('home.services.title')) ?></h2>
      </div>
      <a href="<?= url('calculator.php') ?>" class="link-arrow"><?= htmlspecialchars(t('home.services.cta')) ?> <i class="fa-solid fa-arrow-right"></i></a>
    </div>
    <div class="wrap services-compact">
      <?php foreach ($featuredServices as $s):
        $color = $s['color'] ?? 'blue';
      ?>
      <div class="service-row c-<?= htmlspecialchars($color) ?>">
        <div class="service-ico"><i class="fa-solid <?= htmlspecialchars($s['icon'] ?? 'fa-code') ?>"></i></div>
        <div>
          <h3><?= htmlspecialchars(localized($s, 'title')) ?></h3>
          <p><?= htmlspecialchars(localized($s, 'desc')) ?></p>
        </div>
        <?php $price = localized($s, 'price'); if ($price !== ''): ?><span class="service-price"><?= htmlspecialchars($price) ?></span><?php endif; ?>
      </div>
      <?php endforeach; ?>
    </div>
  </section>

  <section class="section section-alt">
    <div class="wrap trust-grid">
      <?php foreach (array_slice($settings['why'] ?? [], 0, 3) as $w):
        $c = $w['color'] ?? 'blue';
      ?>
      <div class="trust-card">
        <i class="fa-solid <?= htmlspecialchars($w['icon'] ?? 'fa-star') ?> ic-<?= htmlspecialchars($c) ?>"></i>
        <h3><?= htmlspecialchars($w['title'] ?? '') ?></h3>
        <p><?= htmlspecialchars($w['desc'] ?? '') ?></p>
      </div>
      <?php endforeach; ?>
    </div>
  </section>

  <section id="contact" class="cta-band">
    <div class="wrap cta-band-inner">
      <div>
        <h2><?= htmlspecialchars(t('home.cta.title')) ?></h2>
        <p><?= htmlspecialchars(t('home.cta.sub')) ?></p>
      </div>
      <div class="cta-band-actions">
        <a href="<?= htmlspecialchars($waLink) ?>" class="btn btn-primary btn-lg" target="_blank" rel="noopener"><i class="fa-brands fa-whatsapp"></i> WhatsApp</a>
        <a href="<?= url('calculator.php') ?>" class="btn btn-ghost btn-lg"><?= htmlspecialchars(t('home.cta.calc')) ?></a>
      </div>
    </div>
  </section>
</main>
