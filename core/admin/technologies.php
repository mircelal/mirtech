<?php
require_once CORE_PATH . '/includes/admin-lang.php';
require_once CORE_PATH . '/includes/admin-i18n-ui.php';
requireAuth();
initAdminLang();

$pageTitle = at('nav.technologies');
$activeNav = 'technologies';
$message = '';

$techs = readJson('technologies.json');
usort($techs, fn($a, $b) => ($a['sort'] ?? 0) <=> ($b['sort'] ?? 0));

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    adminVerifyCsrf();
    $action = $_POST['action'] ?? '';
    if ($action === 'delete') {
        $id = (int)($_POST['id'] ?? 0);
        $techs = array_values(array_filter($techs, fn($t) => (int)$t['id'] !== $id));
        writeJson('technologies.json', $techs);
        $message = 'Texnologiya silindi.';
    } else {
        $id = (int)($_POST['id'] ?? 0);
        $isEdit = $id > 0;
        $existing = [];
        if ($isEdit) {
            foreach ($techs as $t) {
                if ((int)$t['id'] === $id) {
                    $existing = $t;
                    break;
                }
            }
        }
        $translations = $existing['translations'] ?? [];
        if (!is_array($translations)) {
            $translations = [];
        }
        foreach (adminContentLangs() as $l) {
            $code = (string)($l['code'] ?? '');
            if ($code === '') {
                continue;
            }
            $translations[$code] = ['name' => trim((string)($_POST['tr_' . $code . '_name'] ?? ''))];
        }
        $def = defaultLang();
        $defName = trim((string)($translations[$def]['name'] ?? $_POST['name'] ?? ''));
        $item = [
            'id' => $isEdit ? $id : nextId($techs),
            'name' => $defName,
            'translations' => $translations,
            'category' => $_POST['category'] ?? 'web',
            'icon' => trim($_POST['icon'] ?? 'fa-code'),
            'icon_type' => $_POST['icon_type'] ?? 'devicon',
            'brand' => trim($_POST['brand'] ?? ''),
            'sort' => (int)($_POST['sort'] ?? 0),
            'featured' => !empty($_POST['featured']),
        ];
        if ($isEdit) {
            foreach ($techs as $i => $t) {
                if ((int)$t['id'] === $id) {
                    $techs[$i] = $item;
                    break;
                }
            }
            $message = 'Yeniləndi.';
        } else {
            $techs[] = $item;
            $message = 'Əlavə edildi.';
        }
        usort($techs, fn($a, $b) => ($a['sort'] ?? 0) <=> ($b['sort'] ?? 0));
        writeJson('technologies.json', $techs);
    }
    $techs = readJson('technologies.json');
    usort($techs, fn($a, $b) => ($a['sort'] ?? 0) <=> ($b['sort'] ?? 0));
}

$edit = null;
if (isset($_GET['edit'])) {
    $eid = (int)$_GET['edit'];
    foreach ($techs as $t) {
        if ((int)$t['id'] === $eid) {
            $edit = $t;
            break;
        }
    }
}

$cats = [];
foreach (techCategoryOrder() as $k) {
    $cats[$k] = techCategoryLabel($k);
}

require '_layout.php';
?>

<?php if ($message): ?><div class="adm-alert adm-alert-ok"><?= htmlspecialchars($message) ?></div><?php endif; ?>

<div class="adm-card">
  <h2><?= $edit ? 'Redaktə' : 'Yeni texnologiya' ?></h2>
  <form class="adm-form" method="post">
    <?= adminCsrfField() ?>
    <?php if ($edit): ?><input type="hidden" name="id" value="<?= (int)$edit['id'] ?>"><?php endif; ?>
    <?= adminLangTabs() ?>
    <?php foreach (adminContentLangs() as $li => $l):
      $code = (string)($l['code'] ?? '');
      $panelActive = ($code === defaultLang()) ? ' is-active' : '';
    ?>
    <div class="adm-lang-panel<?= $panelActive ?>" data-lang-panel="<?= htmlspecialchars($code) ?>" data-lang-scope="content">
      <label>Ad (<?= strtoupper(htmlspecialchars($code)) ?>)</label>
      <input name="tr_<?= htmlspecialchars($code) ?>_name" value="<?= htmlspecialchars(adminTr($edit ?? [], $code, 'name')) ?>" <?= $code === defaultLang() ? 'required' : '' ?>>
    </div>
    <?php endforeach; ?>
    <div class="adm-row">
      <div>
        <label>Kateqoriya</label>
        <select name="category">
          <?php foreach ($cats as $k => $v): ?>
            <option value="<?= $k ?>" <?= ($edit['category'] ?? '') === $k ? 'selected' : '' ?>><?= $v ?></option>
          <?php endforeach; ?>
        </select>
      </div>
    </div>
    <div class="adm-row">
      <div>
        <label>İkon kitabxanası</label>
        <select name="icon_type">
          <?php foreach (['devicon' => 'Devicon (tövsiyə)', 'brands' => 'Font Awesome Brands', 'solid' => 'Font Awesome Solid'] as $k => $v): ?>
            <option value="<?= $k ?>" <?= ($edit['icon_type'] ?? 'devicon') === $k ? 'selected' : '' ?>><?= $v ?></option>
          <?php endforeach; ?>
        </select>
      </div>
      <div>
        <label>İkon sinifi</label>
        <input name="icon" value="<?= htmlspecialchars($edit['icon'] ?? 'devicon-php-plain') ?>" placeholder="devicon-docker-plain və ya fa-docker">
      </div>
    </div>
    <p style="font-size:12px;color:var(--muted);margin:-8px 0 12px">
      Nümunə: <code>devicon-nginx-original</code>, <code>devicon-mysql-plain</code>, <code>fa-server</code> (solid)
    </p>
    <div class="adm-row">
      <div><label>Brand slug (CSS rəng)</label><input name="brand" value="<?= htmlspecialchars($edit['brand'] ?? '') ?>"></div>
      <div style="display:flex;align-items:flex-end;gap:10px;padding-bottom:4px">
        <span style="font-size:12px;color:var(--muted)">Önizləmə:</span>
        <span style="font-size:28px;line-height:1"><?= $edit ? renderTechIcon($edit) : '' ?></span>
      </div>
    </div>
    <label>Sıra</label>
    <input type="number" name="sort" value="<?= (int)($edit['sort'] ?? 0) ?>">
    <label style="text-transform:none;font-weight:500;display:flex;align-items:center;gap:8px">
      <input type="checkbox" name="featured" value="1" <?= !empty($edit['featured']) ? 'checked' : '' ?>> Ana səhifədə göstər
    </label>
    <div class="adm-actions">
      <button type="submit" class="adm-btn">Saxla</button>
      <?php if ($edit): ?><a href="technologies.php" class="adm-btn adm-btn-ghost">Ləğv et</a><?php endif; ?>
    </div>
  </form>
</div>

<div class="adm-card">
  <h2>Siyahı</h2>
  <table class="adm-table">
    <thead><tr><th></th><th>Ad</th><th>Kateqoriya</th><th>Sıra</th><th></th></tr></thead>
    <tbody>
    <?php foreach ($techs as $t): ?>
      <tr>
        <td style="font-size:22px;width:40px"><?= renderTechIcon($t) ?></td>
        <td><?= htmlspecialchars($t['name']) ?></td>
        <td><?= techCategoryLabel($t['category'] ?? '') ?></td>
        <td><?= (int)($t['sort'] ?? 0) ?></td>
        <td>
          <a href="?edit=<?= (int)$t['id'] ?>" class="adm-btn adm-btn-ghost" style="padding:6px 10px;font-size:12px">Redaktə</a>
          <form method="post" style="display:inline" onsubmit="return confirm('Silinsin?')">
            <?= adminCsrfField() ?>
            <input type="hidden" name="action" value="delete">
            <input type="hidden" name="id" value="<?= (int)$t['id'] ?>">
            <button type="submit" class="adm-btn adm-btn-danger" style="padding:6px 10px;font-size:12px">Sil</button>
          </form>
        </td>
      </tr>
    <?php endforeach; ?>
    </tbody>
  </table>
</div>

<?php require '_footer.php';
