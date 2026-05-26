<?php
require_once CORE_PATH . '/includes/admin-i18n-ui.php';
requireAuth();
initAdminLang();

$pageTitle = at('nav.translations');
$activeNav = 'translations';
$message = '';
$error = '';

$langCode = strtolower(trim($_GET['lang'] ?? 'en'));
if (!isValidLang($langCode)) {
    $langCode = defaultLang();
}

$groups = [
    'nav' => 'Naviqasiya',
    'footer' => 'Footer',
    'home' => 'Ana səhifə',
    'projects' => 'Layihələr',
    'project' => 'Layihə detalı',
    'tech' => 'Texnologiyalar',
    'calc' => 'Kalkulyator',
    'status' => 'Status',
    'meta' => 'Meta',
    'site' => 'Sayt',
    'lang' => 'Dil',
    'cta' => 'CTA',
];

$path = DATA_PATH . '/lang/' . $langCode . '.json';
$strings = is_file($path) ? json_decode(file_get_contents($path) ?: '{}', true) : [];
if (!is_array($strings)) {
    $strings = [];
}
$defaults = i18nDefaultStrings($langCode);
$strings = array_merge($defaults, $strings);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    adminVerifyCsrf();
    $langCode = strtolower(trim($_POST['lang'] ?? $langCode));
    if (!isValidLang($langCode)) {
        $error = 'Yanlış dil.';
    } else {
        $posted = $_POST['key'] ?? [];
        if (!is_array($posted)) {
            $posted = [];
        }
        foreach ($posted as $k => $v) {
            $k = (string)$k;
            if ($k === '') {
                continue;
            }
            $strings[$k] = trim((string)$v);
        }
        writeJson('lang/' . $langCode . '.json', $strings);
        $message = 'Tərcümələr saxlanıldı (' . strtoupper($langCode) . ').';
    }
}

$activeGroup = $_GET['group'] ?? 'nav';
if (!isset($groups[$activeGroup])) {
    $activeGroup = 'nav';
}

$filtered = [];
$prefix = $activeGroup . '.';
foreach ($strings as $k => $v) {
    if (str_starts_with($k, $prefix) || ($activeGroup === 'calc' && str_starts_with($k, 'calc.'))) {
        $filtered[$k] = $v;
    }
}
ksort($filtered);

require '_layout.php';
?>

<?php if ($message): ?><div class="adm-alert adm-alert-ok"><?= htmlspecialchars($message) ?></div><?php endif; ?>
<?php if ($error): ?><div class="adm-alert adm-alert-err"><?= htmlspecialchars($error) ?></div><?php endif; ?>

<div class="adm-card">
  <h2>UI tərcümələri</h2>
  <div class="adm-lang-tabs" role="tablist" style="margin-bottom:16px">
    <?php foreach (enabledLangs() as $l):
      $c = (string)($l['code'] ?? '');
      $active = $c === $langCode ? ' is-active' : '';
    ?>
    <a class="adm-lang-tab<?= $active ?>" href="?lang=<?= urlencode($c) ?>&group=<?= urlencode($activeGroup) ?>"><?= htmlspecialchars($l['native'] ?? $c) ?></a>
    <?php endforeach; ?>
  </div>
  <nav class="adm-settings-tabs" style="margin-bottom:16px">
    <?php foreach ($groups as $gid => $label): ?>
    <a class="adm-settings-tab<?= $gid === $activeGroup ? ' is-active' : '' ?>" href="?lang=<?= urlencode($langCode) ?>&group=<?= urlencode($gid) ?>"><?= htmlspecialchars($label) ?></a>
    <?php endforeach; ?>
  </nav>

  <form class="adm-form" method="post">
    <?= adminCsrfField() ?>
    <input type="hidden" name="lang" value="<?= htmlspecialchars($langCode) ?>">
    <?php if (empty($filtered)): ?>
      <p class="adm-hint">Bu qrupda açar yoxdur.</p>
    <?php else: ?>
      <?php foreach ($filtered as $key => $val): ?>
      <label style="margin-top:12px"><code><?= htmlspecialchars($key) ?></code></label>
      <input name="key[<?= htmlspecialchars($key) ?>]" value="<?= htmlspecialchars((string)$val) ?>">
      <?php endforeach; ?>
    <?php endif; ?>
    <div class="adm-actions">
      <button type="submit" class="adm-btn"><i class="fa-solid fa-save"></i> Saxla</button>
    </div>
  </form>
</div>

<?php require '_footer.php';
