<?php
/** @var array $settings */
/** @var string $pageTitle */
/** @var string $pageDescription */
/** @var string $activeNav home|projects|tech|calculator|contact */
$settings = getSettingsLocalized();
$sc = siteContact();
$contact = $sc['contact'];
$waLink = $sc['whatsapp_link'];
$siteName = $settings['site_name'] ?? t('site.name');
$title = ($pageTitle ?? $siteName) . ' — ' . ($settings['tagline'] ?? $siteName);
$desc = $pageDescription ?? t('meta.home_desc');
$navActive = $activeNav ?? 'home';
$bodyClass = trim($bodyClass ?? '');
$lang = currentLang();
?>
<!DOCTYPE html>
<html lang="<?= htmlspecialchars($lang) ?>">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
<title><?= htmlspecialchars($title) ?></title>
<meta name="description" content="<?= htmlspecialchars($desc) ?>">
<?= hreflangLinks() ?>
<?php require __DIR__ . '/head-fonts.php'; ?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
<link rel="stylesheet" href="<?= asset('assets/css/site.css') ?>">
<link rel="stylesheet" href="<?= asset('assets/css/typography-az.css') ?>">
<?php if (!empty($extraStyles)): foreach ((array)$extraStyles as $css): ?>
<link rel="stylesheet" href="<?= htmlspecialchars($css) ?>">
<?php endforeach; endif; ?>
</head>
<body<?= $bodyClass !== '' ? ' class="' . htmlspecialchars($bodyClass) . '"' : '' ?>>

<header class="site-header">
  <div class="wrap header-inner">
    <a href="<?= url() ?>" class="brand">
      <span class="brand-mark"><i class="fa-solid fa-code"></i></span>
      <span class="brand-text">Mir<span>Tech</span></span>
    </a>
    <nav class="site-nav" aria-label="<?= htmlspecialchars(t('nav.home')) ?>">
      <a href="<?= url() ?>" class="<?= $navActive === 'home' ? 'is-active' : '' ?>"><?= htmlspecialchars(t('nav.home')) ?></a>
      <a href="<?= url('projects.php') ?>" class="<?= $navActive === 'projects' ? 'is-active' : '' ?>"><?= htmlspecialchars(t('nav.projects')) ?></a>
      <a href="<?= url('technologies.php') ?>" class="<?= $navActive === 'tech' ? 'is-active' : '' ?>"><?= htmlspecialchars(t('nav.tech')) ?></a>
      <a href="<?= url('calculator.php') ?>" class="<?= $navActive === 'calculator' ? 'is-active' : '' ?>"><?= htmlspecialchars(t('nav.calculator')) ?></a>
      <a href="<?= url() ?>#contact" class="<?= $navActive === 'contact' ? 'is-active' : '' ?>"><?= htmlspecialchars(t('nav.contact')) ?></a>
    </nav>
    <div class="header-actions">
      <div class="lang-switcher" role="navigation" aria-label="<?= htmlspecialchars(t('lang.switch')) ?>">
        <?php foreach (enabledLangs() as $l):
          $code = (string)($l['code'] ?? '');
          if ($code === '') continue;
          $active = $code === $lang ? ' is-active' : '';
        ?>
        <a href="<?= htmlspecialchars(langUrl($code)) ?>" class="lang-btn<?= $active ?>" hreflang="<?= htmlspecialchars($code) ?>" lang="<?= htmlspecialchars($code) ?>"><?= strtoupper(htmlspecialchars($code)) ?></a>
        <?php endforeach; ?>
      </div>
      <a href="<?= htmlspecialchars($waLink) ?>" class="btn btn-sm btn-primary header-cta" target="_blank" rel="noopener" aria-label="WhatsApp">
        <i class="fa-brands fa-whatsapp"></i><span class="hide-mobile"> <?= htmlspecialchars(t('cta.whatsapp')) ?></span>
      </a>
      <button type="button" class="nav-toggle" id="navToggle" aria-label="<?= htmlspecialchars(t('nav.menu_open')) ?>" aria-expanded="false" aria-controls="mobileDrawer">
        <i class="fa-solid fa-bars" aria-hidden="true"></i>
      </button>
    </div>
  </div>
</header>

<div class="nav-backdrop" id="navBackdrop" hidden></div>
<aside class="mobile-drawer" id="mobileDrawer" hidden aria-hidden="true" aria-label="<?= htmlspecialchars(t('nav.menu')) ?>">
  <div class="mobile-drawer-head">
    <span class="mobile-drawer-title"><?= htmlspecialchars(t('nav.menu')) ?></span>
    <button type="button" class="nav-close" id="navClose" aria-label="<?= htmlspecialchars(t('nav.menu_close')) ?>">
      <i class="fa-solid fa-xmark" aria-hidden="true"></i>
    </button>
  </div>
  <nav class="mobile-drawer-nav">
    <a href="<?= url() ?>" class="<?= $navActive === 'home' ? 'is-active' : '' ?>"><i class="fa-solid fa-house"></i> <?= htmlspecialchars(t('nav.home')) ?></a>
    <a href="<?= url('projects.php') ?>" class="<?= $navActive === 'projects' ? 'is-active' : '' ?>"><i class="fa-solid fa-folder-open"></i> <?= htmlspecialchars(t('nav.projects')) ?></a>
    <a href="<?= url('technologies.php') ?>" class="<?= $navActive === 'tech' ? 'is-active' : '' ?>"><i class="fa-solid fa-microchip"></i> <?= htmlspecialchars(t('nav.tech')) ?></a>
    <a href="<?= url('calculator.php') ?>" class="<?= $navActive === 'calculator' ? 'is-active' : '' ?>"><i class="fa-solid fa-calculator"></i> <?= htmlspecialchars(t('nav.calculator')) ?></a>
    <a href="<?= url() ?>#contact" class="<?= $navActive === 'contact' ? 'is-active' : '' ?>"><i class="fa-solid fa-envelope"></i> <?= htmlspecialchars(t('nav.contact')) ?></a>
  </nav>
  <div class="mobile-drawer-foot">
    <div class="lang-switcher lang-switcher-drawer">
      <?php foreach (enabledLangs() as $l):
        $code = (string)($l['code'] ?? '');
        if ($code === '') continue;
        $active = $code === $lang ? ' is-active' : '';
      ?>
      <a href="<?= htmlspecialchars(langUrl($code)) ?>" class="lang-btn<?= $active ?>"><?= strtoupper(htmlspecialchars($code)) ?></a>
      <?php endforeach; ?>
    </div>
    <a href="<?= htmlspecialchars($waLink) ?>" class="btn btn-primary btn-block" target="_blank" rel="noopener"><i class="fa-brands fa-whatsapp"></i> <?= htmlspecialchars(t('cta.whatsapp_full')) ?></a>
  </div>
</aside>
