<?php
/** @var array $settings */
/** @var string $pageTitle */
/** @var string $pageDescription */
/** @var string $activeNav home|projects|tech|calculator|contact */
$sc = siteContact();
$contact = $sc['contact'];
$waLink = $sc['whatsapp_link'];
$siteName = $settings['site_name'] ?? 'MirTech';
$title = ($pageTitle ?? $siteName) . ' — ' . ($settings['tagline'] ?? 'MirTech');
$desc = $pageDescription ?? 'MirTech — veb, mobil, ERP və bulud həlləri.';
$navActive = $activeNav ?? 'home';
$bodyClass = trim($bodyClass ?? '');
?>
<!DOCTYPE html>
<html lang="az">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
<title><?= htmlspecialchars($title) ?></title>
<meta name="description" content="<?= htmlspecialchars($desc) ?>">
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
    <nav class="site-nav" aria-label="Əsas naviqasiya">
      <a href="<?= url() ?>" class="<?= $navActive === 'home' ? 'is-active' : '' ?>">Ana səhifə</a>
      <a href="<?= url('projects.php') ?>" class="<?= $navActive === 'projects' ? 'is-active' : '' ?>">Layihələr</a>
      <a href="<?= url('technologies.php') ?>" class="<?= $navActive === 'tech' ? 'is-active' : '' ?>">Texnologiya</a>
      <a href="<?= url('calculator.php') ?>" class="<?= $navActive === 'calculator' ? 'is-active' : '' ?>">Qiymət</a>
      <a href="<?= url() ?>#contact" class="<?= $navActive === 'contact' ? 'is-active' : '' ?>">Əlaqə</a>
    </nav>
    <div class="header-actions">
      <a href="<?= htmlspecialchars($waLink) ?>" class="btn btn-sm btn-primary header-cta" target="_blank" rel="noopener" aria-label="WhatsApp">
        <i class="fa-brands fa-whatsapp"></i><span class="hide-mobile"> Yazın</span>
      </a>
      <button type="button" class="nav-toggle" id="navToggle" aria-label="Menyunu aç" aria-expanded="false" aria-controls="mobileDrawer">
        <i class="fa-solid fa-bars" aria-hidden="true"></i>
      </button>
    </div>
  </div>
</header>

<div class="nav-backdrop" id="navBackdrop" hidden></div>
<aside class="mobile-drawer" id="mobileDrawer" hidden aria-hidden="true" aria-label="Mobil menyu">
  <div class="mobile-drawer-head">
    <span class="mobile-drawer-title">Menyu</span>
    <button type="button" class="nav-close" id="navClose" aria-label="Menyunu bağla">
      <i class="fa-solid fa-xmark" aria-hidden="true"></i>
    </button>
  </div>
  <nav class="mobile-drawer-nav">
    <a href="<?= url() ?>" class="<?= $navActive === 'home' ? 'is-active' : '' ?>"><i class="fa-solid fa-house"></i> Ana səhifə</a>
    <a href="<?= url('projects.php') ?>" class="<?= $navActive === 'projects' ? 'is-active' : '' ?>"><i class="fa-solid fa-folder-open"></i> Layihələr</a>
    <a href="<?= url('technologies.php') ?>" class="<?= $navActive === 'tech' ? 'is-active' : '' ?>"><i class="fa-solid fa-microchip"></i> Texnologiya</a>
    <a href="<?= url('calculator.php') ?>" class="<?= $navActive === 'calculator' ? 'is-active' : '' ?>"><i class="fa-solid fa-calculator"></i> Qiymət hesabla</a>
    <a href="<?= url() ?>#contact" class="<?= $navActive === 'contact' ? 'is-active' : '' ?>"><i class="fa-solid fa-envelope"></i> Əlaqə</a>
  </nav>
  <div class="mobile-drawer-foot">
    <a href="<?= htmlspecialchars($waLink) ?>" class="btn btn-primary btn-block" target="_blank" rel="noopener"><i class="fa-brands fa-whatsapp"></i> WhatsApp ilə yazın</a>
  </div>
</aside>
