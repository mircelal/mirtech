<?php
/** @var array $settings */
$settings = getSettingsLocalized();
$sc = siteContact();
$year = (int)($settings['footer_year'] ?? date('Y'));
?>
<footer class="site-footer">
  <div class="wrap footer-grid">
    <div>
      <div class="brand footer-brand"><span class="brand-mark"><i class="fa-solid fa-code"></i></span><span class="brand-text">Mir<span>Tech</span></span></div>
      <p class="footer-tag"><?= htmlspecialchars($settings['tagline'] ?? '') ?></p>
    </div>
    <div class="footer-links-col">
      <span class="footer-label"><?= htmlspecialchars(t('footer.pages')) ?></span>
      <a href="<?= url('projects.php') ?>"><?= htmlspecialchars(t('nav.projects')) ?></a>
      <a href="<?= url('technologies.php') ?>"><?= htmlspecialchars(t('nav.tech')) ?></a>
      <a href="<?= url('calculator.php') ?>"><?= htmlspecialchars(t('nav.calculator')) ?></a>
    </div>
    <div class="footer-links-col">
      <span class="footer-label"><?= htmlspecialchars(t('footer.contact')) ?></span>
      <a href="<?= htmlspecialchars($sc['whatsapp_link']) ?>" target="_blank" rel="noopener">WhatsApp</a>
      <a href="mailto:<?= htmlspecialchars($sc['contact']['email'] ?? '') ?>">Email</a>
    </div>
  </div>
  <div class="wrap footer-bottom">
    <span>© <?= $year ?> MirTech</span>
    <a href="<?= url('admin/login.php') ?>" class="footer-admin"><?= htmlspecialchars(t('footer.admin')) ?></a>
  </div>
</footer>

<script>window.MIRTECH={whatsapp:<?= json_encode($sc['whatsapp_raw']) ?>,base:<?= json_encode(baseUrl()) ?>,lang:<?= json_encode(currentLang()) ?>};</script>
<script src="<?= asset('assets/js/site.js') ?>"></script>
<?php if (!empty($extraScripts)): foreach ((array)$extraScripts as $src): ?>
<script src="<?= htmlspecialchars($src) ?>"></script>
<?php endforeach; endif; ?>
</body>
</html>
