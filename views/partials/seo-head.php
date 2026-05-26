<?php
/** @var array $seo */
if (empty($seo)) {
    return;
}
$og = $seo['og'] ?? [];
$tw = $seo['twitter'] ?? [];
$ver = $seo['verification'] ?? [];
?>
<link rel="canonical" href="<?= htmlspecialchars($seo['canonical'] ?? '') ?>">
<meta name="robots" content="<?= htmlspecialchars($seo['robots'] ?? 'index, follow') ?>">
<meta name="googlebot" content="<?= htmlspecialchars($seo['robots'] ?? 'index, follow') ?>">
<?php if (!empty($ver['google'])): ?>
<meta name="google-site-verification" content="<?= htmlspecialchars($ver['google']) ?>">
<?php endif; ?>
<meta name="author" content="<?= htmlspecialchars($seo['siteName'] ?? 'MirTech') ?>">
<meta name="theme-color" content="#0d1117">
<meta property="og:type" content="<?= htmlspecialchars($og['type'] ?? 'website') ?>">
<meta property="og:site_name" content="<?= htmlspecialchars($og['site_name'] ?? '') ?>">
<meta property="og:title" content="<?= htmlspecialchars($og['title'] ?? '') ?>">
<meta property="og:description" content="<?= htmlspecialchars($og['description'] ?? '') ?>">
<meta property="og:url" content="<?= htmlspecialchars($og['url'] ?? '') ?>">
<meta property="og:image" content="<?= htmlspecialchars($og['image'] ?? '') ?>">
<meta property="og:locale" content="<?= htmlspecialchars($og['locale'] ?? 'az_AZ') ?>">
<?php foreach (enabledLangs() as $l):
    $code = (string)($l['code'] ?? '');
    if ($code === '' || $code === ($seo['lang'] ?? '')) continue;
?>
<meta property="og:locale:alternate" content="<?= htmlspecialchars(ogLocale($code)) ?>">
<?php endforeach; ?>
<meta name="twitter:card" content="<?= htmlspecialchars($tw['card'] ?? 'summary_large_image') ?>">
<meta name="twitter:title" content="<?= htmlspecialchars($tw['title'] ?? '') ?>">
<meta name="twitter:description" content="<?= htmlspecialchars($tw['description'] ?? '') ?>">
<meta name="twitter:image" content="<?= htmlspecialchars($tw['image'] ?? '') ?>">
<?php if (!empty($tw['site'])): ?>
<meta name="twitter:site" content="<?= htmlspecialchars($tw['site']) ?>">
<?php endif; ?>
<?php if (!empty($tw['creator'])): ?>
<meta name="twitter:creator" content="<?= htmlspecialchars($tw['creator']) ?>">
<?php endif; ?>
<link rel="icon" href="<?= asset('assets/img/favicon.svg') ?>" type="image/svg+xml">
<link rel="apple-touch-icon" href="<?= asset('assets/img/og-default.svg') ?>">
<?php if (!empty($seo['jsonLd'])): ?>
<script type="application/ld+json"><?= json_encode($seo['jsonLd'], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) ?></script>
<?php endif; ?>
