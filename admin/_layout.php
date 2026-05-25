<?php
declare(strict_types=1);
require_once dirname(__DIR__) . '/config.php';

$pageTitle = $pageTitle ?? 'Admin';
$activeNav = $activeNav ?? '';

function adminNav(string $active): string
{
    $items = [
        'dashboard' => ['index.php', 'fa-gauge', 'Panel'],
        'projects' => ['projects.php', 'fa-folder-open', 'Layihələr'],
        'services' => ['services.php', 'fa-briefcase', 'Xidmətlər'],
        'technologies' => ['technologies.php', 'fa-microchip', 'Texnologiyalar'],
        'settings' => ['settings.php', 'fa-gear', 'Parametrlər'],
        'leads' => ['leads.php', 'fa-inbox', 'Müraciətlər'],
    ];
    $html = '';
    foreach ($items as $key => [$href, $icon, $label]) {
        $cls = $key === $active ? ' active' : '';
        $html .= '<a class="adm-nav-item' . $cls . '" href="' . $href . '"><i class="fa-solid ' . $icon . '" aria-hidden="true"></i> ' . htmlspecialchars($label) . '</a>';
    }
    return $html;
}
?>
<!DOCTYPE html>
<html lang="az">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
<title><?= htmlspecialchars($pageTitle) ?> — MirTech Admin</title>
<?php require dirname(__DIR__) . '/includes/head-fonts.php'; ?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
<link rel="stylesheet" href="admin.css">
<link rel="stylesheet" href="<?= asset('assets/css/typography-az.css') ?>">
</head>
<body class="adm-body">
<div class="adm-backdrop" id="admBackdrop" hidden aria-hidden="true"></div>
<header class="adm-mobile-bar">
  <button type="button" class="adm-menu-toggle" id="admMenuToggle" aria-label="Menyunu aç" aria-expanded="false" aria-controls="admSidebar">
    <i class="fa-solid fa-bars" aria-hidden="true"></i>
  </button>
  <h1 class="adm-mobile-title"><?= htmlspecialchars($pageTitle) ?></h1>
  <a href="logout.php" class="adm-mobile-logout" aria-label="Çıxış">
    <i class="fa-solid fa-right-from-bracket" aria-hidden="true"></i>
  </a>
</header>
<aside class="adm-sidebar" id="admSidebar" aria-label="Admin naviqasiya">
  <div class="adm-sidebar-head">
    <a href="index.php" class="adm-brand"><i class="fa-solid fa-code"></i> Mir<span>Tech</span></a>
    <button type="button" class="adm-sidebar-close" id="admSidebarClose" aria-label="Menyunu bağla">
      <i class="fa-solid fa-xmark" aria-hidden="true"></i>
    </button>
  </div>
  <nav class="adm-nav"><?= adminNav($activeNav) ?></nav>
  <a href="logout.php" class="adm-logout"><i class="fa-solid fa-right-from-bracket"></i> Çıxış</a>
</aside>
<main class="adm-main">
  <header class="adm-top">
    <h1><?= htmlspecialchars($pageTitle) ?></h1>
  </header>
  <div class="adm-content">
