<?php
declare(strict_types=1);
require_once __DIR__ . '/config.php';

$id = (int)($_GET['id'] ?? 0);
$project = $id > 0 ? getProjectById($id) : null;

if (!$project) {
    http_response_code(404);
    $pageTitle = 'Tapılmadı';
    $activeNav = 'projects';
    require __DIR__ . '/includes/header.php';
    echo '<main class="page-main wrap"><div class="empty-state" style="padding:80px 0"><h1 style="color:var(--head)">Layihə tapılmadı</h1><p><a href="' . htmlspecialchars(url('projects.php')) . '">Layihələrə qayıt</a></p></div></main>';
    require __DIR__ . '/includes/footer.php';
    exit;
}

$techs = resolveProjectTechnologies($project);
$timeline = $project['timeline'] ?? [];
$stats = $project['stats'] ?? [];
$features = $project['features'] ?? [];
$overall = projectOverallProgress($project);
$related = relatedProjects($project);
$status = $project['status'] ?? 'ongoing';
$img = trim($project['image'] ?? '');

$pageTitle = $project['name'];
$pageDescription = $project['desc'] ?? '';
$activeNav = 'projects';
$extraScripts = [asset('assets/js/project-detail.js')];
$extraStyles = [asset('assets/css/project-detail.css')];

require __DIR__ . '/includes/header.php';
?>

<main class="page-main project-detail">
  <div class="wrap">
    <nav class="breadcrumb" aria-label="Yol">
      <a href="<?= url() ?>">Ana səhifə</a>
      <span>/</span>
      <a href="<?= url('projects.php') ?>">Layihələr</a>
      <span>/</span>
      <span><?= htmlspecialchars($project['name']) ?></span>
    </nav>
  </div>

  <header class="proj-hero wrap">
    <div class="proj-hero-grid">
      <div class="proj-hero-text">
        <span class="proj-badge-lg <?= htmlspecialchars($status) ?>"><?= projectStatusLabel($status) ?></span>
        <h1><?= htmlspecialchars($project['name']) ?></h1>
        <p class="proj-hero-desc"><?= htmlspecialchars($project['desc'] ?? '') ?></p>
        <div class="proj-hero-meta">
          <span><i class="fa-solid fa-folder"></i> <?= htmlspecialchars($project['category'] ?? '') ?></span>
          <span><i class="fa-solid fa-calendar"></i> <?= (int)($project['year'] ?? 0) ?></span>
          <?php if (!empty($project['duration'])): ?>
            <span><i class="fa-solid fa-clock"></i> <?= htmlspecialchars($project['duration']) ?></span>
          <?php endif; ?>
        </div>
        <div class="proj-hero-actions">
          <?php if (!empty($project['url'])): ?>
            <a href="<?= htmlspecialchars($project['url']) ?>" class="btn btn-primary" target="_blank" rel="noopener">
              Canlı sayt <i class="fa-solid fa-arrow-up-right-from-square"></i>
            </a>
          <?php endif; ?>
          <a href="<?= url('calculator.php') ?>" class="btn btn-ghost">Oxşar layihə qiyməti</a>
        </div>
      </div>
      <div class="proj-hero-visual">
        <?php if ($img && is_file(ROOT_PATH . '/' . $img)): ?>
          <img src="<?= asset($img) ?>" alt="" class="proj-hero-img">
        <?php else: ?>
          <div class="proj-hero-placeholder"><i class="fa-solid fa-diagram-project"></i></div>
        <?php endif; ?>
        <div class="progress-ring" style="--p: <?= $overall ?>" data-progress="<?= $overall ?>">
          <div class="progress-ring-inner">
            <strong><?= $overall ?>%</strong>
            <span>tamamlanma</span>
          </div>
        </div>
      </div>
    </div>
  </header>

  <section class="wrap proj-section">
    <div class="proj-layout">
      <div class="proj-main-col">
        <?php if (!empty($project['overview'])): ?>
        <div class="proj-block">
          <h2><i class="fa-solid fa-file-lines"></i> Layihə haqqında</h2>
          <p class="proj-overview"><?= nl2br(htmlspecialchars($project['overview'])) ?></p>
        </div>
        <?php endif; ?>

        <?php if ($stats): ?>
        <div class="proj-block">
          <h2><i class="fa-solid fa-chart-column"></i> Göstəricilər</h2>
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
          <h2><i class="fa-solid fa-road"></i> İnkişaf planı</h2>
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
          <h2><i class="fa-solid fa-check-double"></i> Əsas funksiyalar</h2>
          <ul class="feature-list">
            <?php foreach ($features as $f): ?>
              <li><i class="fa-solid fa-circle-check"></i> <?= htmlspecialchars($f) ?></li>
            <?php endforeach; ?>
          </ul>
        </div>
        <?php endif; ?>

        <div class="proj-block">
          <h2><i class="fa-solid fa-sitemap"></i> Sistem axını</h2>
          <div class="flow-diagram" aria-hidden="true">
            <div class="flow-node"><i class="fa-solid fa-users"></i><span>İstifadəçi</span></div>
            <div class="flow-arrow"><i class="fa-solid fa-arrow-right"></i></div>
            <div class="flow-node flow-accent"><i class="fa-solid fa-server"></i><span>Backend API</span></div>
            <div class="flow-arrow"><i class="fa-solid fa-arrow-right"></i></div>
            <div class="flow-node"><i class="fa-solid fa-database"></i><span>Məlumat</span></div>
          </div>
          <p class="flow-caption">Sadələşdirilmiş arxitektura sxemi — hər layihəyə uyğunlaşdırılır.</p>
        </div>
      </div>

      <aside class="proj-aside">
        <?php if ($techs): ?>
        <div class="aside-card">
          <h3>Texnologiyalar</h3>
          <div class="tech-stack-list">
            <?php foreach ($techs as $t): ?>
            <span class="tech-stack-item brand-<?= htmlspecialchars($t['brand'] ?? '') ?>">
              <?= renderTechIcon($t) ?>
              <?= htmlspecialchars($t['name']) ?>
            </span>
            <?php endforeach; ?>
          </div>
          <a href="<?= url('technologies.php') ?>" class="aside-link">Bütün stack →</a>
        </div>
        <?php endif; ?>

        <div class="aside-card aside-cta">
          <h3>Oxşar layihə?</h3>
          <p>Qiymət kalkulyatoru ilə təxmini büdcə hesablayın.</p>
          <a href="<?= url('calculator.php') ?>" class="btn btn-primary btn-block">Hesabla</a>
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
    <h2>Əlaqəli layihələr</h2>
    <div class="projects-grid">
      <?php foreach ($related as $p):
        include __DIR__ . '/includes/project-card.php';
      endforeach; ?>
    </div>
  </section>
  <?php endif; ?>
</main>

<?php require __DIR__ . '/includes/footer.php';
