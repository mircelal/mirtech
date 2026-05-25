<?php
declare(strict_types=1);
require_once __DIR__ . '/config.php';

$settings = readJson('settings.json');
$limits = homepageLimits();
$projects = sortByOrder(readJson('projects.json'));
$services = sortByOrder(readJson('services.json'));
$technologies = sortByOrder(readJson('technologies.json'));

$featuredProjects = getFeaturedItems($projects, $limits['projects']);
$featuredServices = getFeaturedItems($services, $limits['services']);
$featuredTech = getFeaturedItems($technologies, $limits['technologies']);

$totalProjects = count($projects);
$totalTech = count($technologies);

$pageTitle = $settings['site_name'] ?? 'MirTech';
$pageDescription = 'MirTech — 15 illik təcrübə. Veb, mobil, ERP və bulud.';
$activeNav = 'home';
$sc = siteContact();
$waLink = $sc['whatsapp_link'];

require __DIR__ . '/includes/header.php';
?>

<main>
  <section class="hero-home">
    <div class="wrap hero-home-inner">
      <p class="pill"><?= htmlspecialchars($settings['hero_eyebrow'] ?? '') ?></p>
      <h1><?= htmlspecialchars($settings['hero_title'] ?? '') ?><br><em><?= htmlspecialchars($settings['hero_title_highlight'] ?? '') ?></em></h1>
      <p class="hero-lead"><?= htmlspecialchars($settings['hero_subtitle'] ?? '') ?></p>
      <div class="hero-cta-row">
        <a href="<?= url('calculator.php') ?>" class="btn btn-primary btn-lg"><i class="fa-solid fa-calculator"></i> Qiymət hesabla</a>
        <a href="<?= url('projects.php') ?>" class="btn btn-ghost btn-lg">Layihələrə bax</a>
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
          <span class="bento-title">Layihələr</span>
          <span class="bento-meta"><?= $totalProjects ?>+ real iş</span>
        </a>
        <a href="<?= url('calculator.php') ?>" class="bento-tile">
          <i class="fa-solid fa-wand-magic-sparkles"></i>
          <span class="bento-title">Ağıllı qiymət</span>
          <span class="bento-meta">5 addım, tövsiyələr</span>
        </a>
        <a href="<?= url('technologies.php') ?>" class="bento-tile">
          <i class="fa-solid fa-microchip"></i>
          <span class="bento-title">Stack</span>
          <span class="bento-meta"><?= $totalTech ?> texnologiya</span>
        </a>
        <a href="<?= url() ?>#contact" class="bento-tile">
          <i class="fa-brands fa-whatsapp"></i>
          <span class="bento-title">Əlaqə</span>
          <span class="bento-meta">Pulsuz məsləhət</span>
        </a>
      </div>
    </div>
  </section>

  <section class="section">
    <div class="wrap section-head-row">
      <div>
        <p class="eyebrow">Seçilmiş layihələr</p>
        <h2>Ən son işlərimiz</h2>
      </div>
      <a href="<?= url('projects.php') ?>" class="link-arrow">Hamısı (<?= $totalProjects ?>) <i class="fa-solid fa-arrow-right"></i></a>
    </div>
    <div class="wrap projects-grid">
      <?php foreach ($featuredProjects as $p):
        include __DIR__ . '/includes/project-card.php';
      endforeach; ?>
    </div>
  </section>

  <section class="section section-alt tech-home-section">
    <div class="wrap section-head-row">
      <div>
        <p class="eyebrow">Texnologiya</p>
        <h2>İstifadə etdiyimiz alətlər</h2>
      </div>
      <a href="<?= url('technologies.php') ?>" class="link-arrow tech-home-more">Tam siyahı <i class="fa-solid fa-arrow-right"></i></a>
    </div>
    <div class="wrap tech-marquee-wrap">
      <div class="tech-marquee" role="list">
      <?php foreach ($featuredTech as $t): ?>
      <span class="tech-pill brand-<?= htmlspecialchars($t['brand'] ?? '') ?>" role="listitem">
        <?= renderTechIcon($t) ?>
        <span class="tech-pill-name"><?= htmlspecialchars($t['name']) ?></span>
      </span>
      <?php endforeach; ?>
      </div>
    </div>
  </section>

  <section class="section">
    <div class="wrap section-head-row">
      <div>
        <p class="eyebrow">Xidmətlər</p>
        <h2>Nə təklif edirik</h2>
      </div>
      <a href="<?= url('calculator.php') ?>" class="link-arrow">Qiymət al <i class="fa-solid fa-arrow-right"></i></a>
    </div>
    <div class="wrap services-compact">
      <?php foreach ($featuredServices as $s):
        $color = $s['color'] ?? 'blue';
      ?>
      <div class="service-row c-<?= htmlspecialchars($color) ?>">
        <div class="service-ico"><i class="fa-solid <?= htmlspecialchars($s['icon'] ?? 'fa-code') ?>"></i></div>
        <div>
          <h3><?= htmlspecialchars($s['title']) ?></h3>
          <p><?= htmlspecialchars($s['desc'] ?? '') ?></p>
        </div>
        <?php if (!empty($s['price'])): ?><span class="service-price"><?= htmlspecialchars($s['price']) ?></span><?php endif; ?>
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
        <h2>Layihənizə başlayaq</h2>
        <p>15 illik təcrübə — veb, mobil, ERP, Proxmox, Nextcloud.</p>
      </div>
      <div class="cta-band-actions">
        <a href="<?= htmlspecialchars($waLink) ?>" class="btn btn-primary btn-lg" target="_blank" rel="noopener"><i class="fa-brands fa-whatsapp"></i> WhatsApp</a>
        <a href="<?= url('calculator.php') ?>" class="btn btn-ghost btn-lg">Qiymət hesabla</a>
      </div>
    </div>
  </section>
</main>

<?php require __DIR__ . '/includes/footer.php';
