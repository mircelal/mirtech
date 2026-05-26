<?php
/** @var array $p */
/** @var bool $projectCardPriority LCP / above-fold */
$status = $p['status'] ?? 'ongoing';
$priority = !empty($projectCardPriority);
$pulse = $status === 'ongoing' ? ' pulse' : '';
$img = trim($p['image'] ?? '');
$href = projectUrl($p);
$name = localized($p, 'name');
$desc = localized($p, 'desc');
$cat = localized($p, 'category');
?>
<a href="<?= htmlspecialchars($href) ?>" class="proj-card proj-card-link">
  <div class="proj-media">
    <?php if ($img && publicFileExists($img)): ?>
      <img src="<?= asset($img) ?>" alt="<?= htmlspecialchars($name) ?>" width="400" height="240" decoding="async"<?= $priority ? ' loading="eager" fetchpriority="high"' : ' loading="lazy"' ?>>
    <?php else: ?>
      <div class="proj-placeholder" aria-hidden="true"><i class="fa-solid fa-layer-group"></i></div>
    <?php endif; ?>
    <span class="proj-badge <?= htmlspecialchars($status) ?><?= $pulse ?>"><?= projectStatusLabel($status) ?></span>
  </div>
  <div class="proj-body">
    <h3 class="proj-name"><?= htmlspecialchars($name) ?></h3>
    <p class="proj-desc"><?= htmlspecialchars($desc) ?></p>
    <div class="proj-meta">
      <span><?= htmlspecialchars($cat) ?> · <?= (int)($p['year'] ?? 0) ?></span>
      <span class="proj-more"><?= htmlspecialchars(t('projects.more')) ?> <i class="fa-solid fa-arrow-right"></i></span>
    </div>
  </div>
</a>
