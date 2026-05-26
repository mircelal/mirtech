<?php
require_once CORE_PATH . '/includes/admin-lang.php';
require_once CORE_PATH . '/includes/admin-i18n-ui.php';
requireAuth();
initAdminLang();

$pageTitle = at('nav.languages');
$activeNav = 'languages';
$message = '';
$error = '';

$path = DATA_PATH . '/languages.json';
$languages = readLanguagesMeta();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    adminVerifyCsrf();
    $action = $_POST['action'] ?? '';
    if ($action === 'add') {
        $code = strtolower(preg_replace('/[^a-z]/', '', $_POST['code'] ?? ''));
        $name = trim($_POST['name'] ?? '');
        $native = trim($_POST['native'] ?? $name);
        if (strlen($code) < 2) {
            $error = 'Dil kodu ən azı 2 hərf (a-z).';
        } else {
            foreach ($languages as $l) {
                if (($l['code'] ?? '') === $code) {
                    $error = 'Bu dil artıq mövcuddur.';
                    break;
                }
            }
            if (!$error) {
                $languages[] = [
                    'code' => $code,
                    'name' => $name ?: strtoupper($code),
                    'native' => $native ?: $name,
                    'enabled' => true,
                ];
                $langFile = DATA_PATH . '/lang/' . $code . '.json';
                if (!is_file($langFile)) {
                    writeJson('lang/' . $code . '.json', i18nDefaultStrings('en'));
                }
                $message = 'Dil əlavə edildi.';
            }
        }
    } elseif ($action === 'save') {
        $posted = $_POST['lang'] ?? [];
        $defaultCode = (string)($_POST['default_code'] ?? defaultLang());
        if (is_array($posted)) {
            foreach ($languages as $i => $l) {
                $code = (string)($l['code'] ?? '');
                if ($code === '' || !isset($posted[$code])) {
                    continue;
                }
                $row = $posted[$code];
                $languages[$i]['enabled'] = !empty($row['enabled']);
                $languages[$i]['default'] = $code === $defaultCode;
                $languages[$i]['name'] = trim($row['name'] ?? $l['name'] ?? '');
                $languages[$i]['native'] = trim($row['native'] ?? $l['native'] ?? '');
            }
            $hasDefault = false;
            foreach ($languages as $l) {
                if (!empty($l['default'])) {
                    $hasDefault = true;
                }
            }
            if (!$hasDefault) {
                $error = 'Default dil seçin.';
            } else {
                writeJson('languages.json', array_values($languages));
                $message = 'Dillər saxlanıldı.';
            }
        }
    }
    $languages = readLanguagesMeta();
}

require '_layout.php';
?>

<?php if ($message): ?><div class="adm-alert adm-alert-ok"><?= htmlspecialchars($message) ?></div><?php endif; ?>
<?php if ($error): ?><div class="adm-alert adm-alert-err"><?= htmlspecialchars($error) ?></div><?php endif; ?>

<div class="adm-card">
  <h2>Sayt dilləri</h2>
  <form class="adm-form" method="post">
    <?= adminCsrfField() ?>
    <input type="hidden" name="action" value="save">
    <table class="adm-table">
      <thead>
        <tr><th>Kod</th><th>Ad</th><th>Native</th><th>Aktiv</th><th>Default</th></tr>
      </thead>
      <tbody>
      <?php foreach ($languages as $l):
        $code = (string)($l['code'] ?? '');
      ?>
        <tr>
          <td><strong><?= htmlspecialchars(strtoupper($code)) ?></strong></td>
          <td><input name="lang[<?= htmlspecialchars($code) ?>][name]" value="<?= htmlspecialchars($l['name'] ?? '') ?>"></td>
          <td><input name="lang[<?= htmlspecialchars($code) ?>][native]" value="<?= htmlspecialchars($l['native'] ?? '') ?>"></td>
          <td><input type="checkbox" name="lang[<?= htmlspecialchars($code) ?>][enabled]" value="1" <?= !empty($l['enabled']) ? 'checked' : '' ?>></td>
          <td><input type="radio" name="default_code" value="<?= htmlspecialchars($code) ?>" <?= !empty($l['default']) ? 'checked' : '' ?>></td>
        </tr>
      <?php endforeach; ?>
      </tbody>
    </table>
    <p class="adm-hint">Default dil URL-də <code>?lang=</code> olmadan göstərilir.</p>
    <div class="adm-actions">
      <button type="submit" class="adm-btn"><i class="fa-solid fa-save"></i> Saxla</button>
    </div>
  </form>
</div>

<div class="adm-card">
  <h2>Yeni dil</h2>
  <form class="adm-form adm-row" method="post">
    <?= adminCsrfField() ?>
    <input type="hidden" name="action" value="add">
    <div><label>Kod</label><input name="code" pattern="[a-z]{2,5}" required placeholder="de"></div>
    <div><label>Ad</label><input name="name" placeholder="German"></div>
    <div><label>Native</label><input name="native" placeholder="Deutsch"></div>
    <div style="align-self:flex-end"><button type="submit" class="adm-btn adm-btn-ghost">Əlavə et</button></div>
  </form>
</div>

<?php require '_footer.php';
