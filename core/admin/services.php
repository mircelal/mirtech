<?php
require_once CORE_PATH . '/includes/admin-lang.php';
require_once CORE_PATH . '/includes/admin-i18n-ui.php';
requireAuth();
initAdminLang();

$pageTitle = at('nav.services');
$activeNav = 'services';
$message = '';

$services = readJson('services.json');
usort($services, fn($a, $b) => ($a['sort'] ?? 0) <=> ($b['sort'] ?? 0));

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    adminVerifyCsrf();
    $action = $_POST['action'] ?? '';
    if ($action === 'delete') {
        $id = (int)($_POST['id'] ?? 0);
        $services = array_values(array_filter($services, fn($s) => (int)$s['id'] !== $id));
        writeJson('services.json', $services);
        $message = 'Xidmət silindi.';
    } else {
        $id = (int)($_POST['id'] ?? 0);
        $isEdit = $id > 0;
        $existing = [];
        if ($isEdit) {
            foreach ($services as $s) {
                if ((int)$s['id'] === $id) {
                    $existing = $s;
                    break;
                }
            }
        }
        $translations = adminSaveServiceTranslations($_POST, $existing);
        $def = defaultLang();
        $defBlock = $translations[$def] ?? [];
        $item = [
            'id' => $isEdit ? $id : nextId($services),
            'title' => trim((string)($defBlock['title'] ?? '')),
            'desc' => trim((string)($defBlock['desc'] ?? '')),
            'price' => trim((string)($defBlock['price'] ?? '')),
            'icon' => trim($_POST['icon'] ?? 'fa-code'),
            'color' => $_POST['color'] ?? 'blue',
            'sort' => (int)($_POST['sort'] ?? 0),
            'featured' => !empty($_POST['featured']),
            'translations' => $translations,
        ];
        if ($isEdit) {
            foreach ($services as $i => $s) {
                if ((int)$s['id'] === $id) {
                    $services[$i] = $item;
                    break;
                }
            }
            $message = 'Xidmət yeniləndi.';
        } else {
            $services[] = $item;
            $message = 'Xidmət əlavə edildi.';
        }
        usort($services, fn($a, $b) => ($a['sort'] ?? 0) <=> ($b['sort'] ?? 0));
        writeJson('services.json', $services);
    }
    $services = readJson('services.json');
    usort($services, fn($a, $b) => ($a['sort'] ?? 0) <=> ($b['sort'] ?? 0));
}

$edit = null;
if (isset($_GET['edit'])) {
    $eid = (int)$_GET['edit'];
    foreach ($services as $s) {
        if ((int)$s['id'] === $eid) {
            $edit = $s;
            break;
        }
    }
}

require '_layout.php';
?>

<?php if ($message): ?><div class="adm-alert adm-alert-ok"><?= htmlspecialchars($message) ?></div><?php endif; ?>

<div class="adm-card">
  <h2><?= $edit ? 'Xidməti redaktə et' : 'Yeni xidmət' ?></h2>
  <form class="adm-form" method="post">
    <?= adminCsrfField() ?>
    <?php if ($edit): ?><input type="hidden" name="id" value="<?= (int)$edit['id'] ?>"><?php endif; ?>
    <?= adminLangTabs() ?>
    <?php foreach (adminContentLangs() as $li => $l):
      $code = (string)($l['code'] ?? '');
      $panelActive = ($code === defaultLang()) ? ' is-active' : '';
    ?>
    <div class="adm-lang-panel<?= $panelActive ?>" data-lang-panel="<?= htmlspecialchars($code) ?>" data-lang-scope="content">
      <label>Başlıq (<?= strtoupper(htmlspecialchars($code)) ?>)</label>
      <input name="tr_<?= htmlspecialchars($code) ?>_title" value="<?= htmlspecialchars(adminTr($edit ?? [], $code, 'title')) ?>" <?= $code === defaultLang() ? 'required' : '' ?>>
      <label>Təsvir</label>
      <textarea name="tr_<?= htmlspecialchars($code) ?>_desc"><?= htmlspecialchars(adminTr($edit ?? [], $code, 'desc')) ?></textarea>
      <label>Qiymət</label>
      <input name="tr_<?= htmlspecialchars($code) ?>_price" value="<?= htmlspecialchars(adminTr($edit ?? [], $code, 'price')) ?>">
    </div>
    <?php endforeach; ?>
    <div class="adm-row">
      <div><label>Font Awesome ikon</label><input name="icon" placeholder="fa-code" value="<?= htmlspecialchars($edit['icon'] ?? 'fa-code') ?>"></div>
    </div>
    <div class="adm-row">
      <div>
        <label>Rəng</label>
        <select name="color">
          <?php foreach (['blue','teal','amber','purple','gold'] as $c): ?>
            <option value="<?= $c ?>" <?= ($edit['color'] ?? '') === $c ? 'selected' : '' ?>><?= $c ?></option>
          <?php endforeach; ?>
        </select>
      </div>
      <div><label>Sıra</label><input type="number" name="sort" value="<?= (int)($edit['sort'] ?? 0) ?>"></div>
    </div>
    <label style="text-transform:none;font-weight:500;display:flex;align-items:center;gap:8px">
      <input type="checkbox" name="featured" value="1" <?= !empty($edit['featured']) ? 'checked' : '' ?>> Ana səhifədə göstər
    </label>
    <div class="adm-actions">
      <button type="submit" class="adm-btn">Saxla</button>
      <?php if ($edit): ?><a href="services.php" class="adm-btn adm-btn-ghost">Ləğv et</a><?php endif; ?>
    </div>
  </form>
</div>

<div class="adm-card">
  <h2>Bütün xidmətlər</h2>
  <table class="adm-table">
    <thead><tr><th>Başlıq</th><th>Qiymət</th><th>Sıra</th><th></th></tr></thead>
    <tbody>
    <?php foreach ($services as $s): ?>
      <tr>
        <td><?= htmlspecialchars($s['title']) ?></td>
        <td><?= htmlspecialchars($s['price'] ?? '') ?></td>
        <td><?= (int)($s['sort'] ?? 0) ?></td>
        <td>
          <a href="?edit=<?= (int)$s['id'] ?>" class="adm-btn adm-btn-ghost" style="padding:6px 10px;font-size:12px">Redaktə</a>
          <form method="post" style="display:inline" onsubmit="return confirm('Silinsin?')">
            <?= adminCsrfField() ?>
            <input type="hidden" name="action" value="delete">
            <input type="hidden" name="id" value="<?= (int)$s['id'] ?>">
            <button type="submit" class="adm-btn adm-btn-danger" style="padding:6px 10px;font-size:12px">Sil</button>
          </form>
        </td>
      </tr>
    <?php endforeach; ?>
    </tbody>
  </table>
</div>

<?php require '_footer.php';
