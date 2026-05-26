<?php
require_once CORE_PATH . '/includes/admin-i18n-ui.php';

initAdminLang();
seedAdminLangFiles();

$pageTitle = $pageTitle ?? at('nav.dashboard');
$activeNav = $activeNav ?? '';

function adminNav(string $active): string
{
    $items = [
        'dashboard' => ['index.php', 'fa-gauge', 'nav.dashboard'],
        'projects' => ['projects.php', 'fa-folder-open', 'nav.projects'],
        'services' => ['services.php', 'fa-briefcase', 'nav.services'],
        'technologies' => ['technologies.php', 'fa-microchip', 'nav.technologies'],
        'settings' => ['settings.php', 'fa-gear', 'nav.settings'],
        'leads' => ['leads.php', 'fa-inbox', 'nav.leads'],
        'languages' => ['languages.php', 'fa-language', 'nav.languages'],
        'translations' => ['translations.php', 'fa-globe', 'nav.translations'],
    ];
    $html = '';
    foreach ($items as $key => [$href, $icon, $labelKey]) {
        $cls = $key === $active ? ' active' : '';
        $html .= '<a class="adm-nav-item' . $cls . '" href="' . $href . '"><i class="fa-solid ' . $icon . '" aria-hidden="true"></i> ' . htmlspecialchars(at($labelKey)) . '</a>';
    }
    return $html;
}

$admLang = adminLang();
?>
<!DOCTYPE html>
<html lang="<?= htmlspecialchars($admLang) ?>">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
<title><?= htmlspecialchars($pageTitle) ?> — MirTech Admin</title>
<meta name="csrf-token" content="<?= htmlspecialchars(adminCsrfToken(), ENT_QUOTES, 'UTF-8') ?>">
<?php require CORE_PATH . '/includes/head-fonts.php'; ?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
<link rel="stylesheet" href="<?= asset('admin/admin.css') ?>">
<link rel="stylesheet" href="<?= asset('assets/css/typography-az.css') ?>">
</head>
<body class="adm-body">
<div class="adm-backdrop" id="admBackdrop" hidden aria-hidden="true"></div>
<header class="adm-mobile-bar">
  <button type="button" class="adm-menu-toggle" id="admMenuToggle" aria-label="<?= htmlspecialchars(at('nav.menu_open')) ?>" aria-expanded="false" aria-controls="admSidebar">
    <i class="fa-solid fa-bars" aria-hidden="true"></i>
  </button>
  <h1 class="adm-mobile-title"><?= htmlspecialchars($pageTitle) ?></h1>
  <a href="logout.php" class="adm-mobile-logout" aria-label="<?= htmlspecialchars(at('nav.logout')) ?>">
    <i class="fa-solid fa-right-from-bracket" aria-hidden="true"></i>
  </a>
</header>
<aside class="adm-sidebar" id="admSidebar" aria-label="Admin">
  <div class="adm-sidebar-head">
    <a href="index.php" class="adm-brand"><i class="fa-solid fa-code"></i> Mir<span>Tech</span></a>
    <button type="button" class="adm-sidebar-close" id="admSidebarClose" aria-label="<?= htmlspecialchars(at('nav.menu_close')) ?>">
      <i class="fa-solid fa-xmark" aria-hidden="true"></i>
    </button>
  </div>
  <?= adminLangSwitcher() ?>
  <nav class="adm-nav"><?= adminNav($activeNav) ?></nav>
  <?= adminVendorCredit() ?>
  <a href="logout.php" class="adm-logout"><i class="fa-solid fa-right-from-bracket"></i> <?= htmlspecialchars(at('nav.logout')) ?></a>
</aside>
<main class="adm-main">
  <header class="adm-top">
    <h1><?= htmlspecialchars($pageTitle) ?></h1>
  </header>
  <div class="adm-content">
