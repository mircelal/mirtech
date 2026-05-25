<?php
/** @var array $p */
$status = $p['status'] ?? 'ongoing';
$pulse = $status === 'ongoing' ? ' pulse' : '';
$img = trim($p['image'] ?? '');
$href = projectUrl($p);
?>
<a href="<?= htmlspecialchars($href) ?>" class="proj-card proj-card-link">
  <div class="proj-media">
    <?php if ($img && is_file(ROOT_PATH . '/' . $img)): ?>
      <img src="<?= asset($img) ?>" alt="<?= htmlspecialchars($p['name']) ?>" loading="lazy" width="400" height="240">
    <?php else: ?>
      <div class="proj-placeholder" aria-hidden="true"><i class="fa-solid fa-layer-group"></i></div>
    <?php endif; ?>
    <span class="proj-badge <?= htmlspecialchars($status) ?><?= $pulse ?>"><?= projectStatusLabel($status) ?></span>
  </div>
  <div class="proj-body">
    <h3 class="proj-name"><?= htmlspecialchars($p['name']) ?></h3>
    <p class="proj-desc"><?= htmlspecialchars($p['desc'] ?? '') ?></p>
    <div class="proj-meta">
      <span><?= htmlspecialchars($p['category'] ?? '') ?> · <?= (int)($p['year'] ?? 0) ?></span>
      <span class="proj-more">Ətraflı <i class="fa-solid fa-arrow-right"></i></span>
    </div>
  </div>
</a>
