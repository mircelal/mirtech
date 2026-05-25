<?php
declare(strict_types=1);
require_once dirname(__DIR__) . '/config.php';
requireAuth();

$pageTitle = 'Layihələr';
$activeNav = 'projects';
$message = '';
$error = '';

$projects = readJson('projects.json');
usort($projects, fn($a, $b) => ($a['sort'] ?? 0) <=> ($b['sort'] ?? 0));

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';

    if ($action === 'delete') {
        $id = (int)($_POST['id'] ?? 0);
        foreach ($projects as $i => $p) {
            if ((int)$p['id'] === $id) {
                deleteProjectImage($p['image'] ?? '');
                unset($projects[$i]);
                break;
            }
        }
        $projects = array_values($projects);
        writeJson('projects.json', $projects);
        $message = 'Layihə silindi.';
    } else {
        $id = (int)($_POST['id'] ?? 0);
        $isEdit = $id > 0;
        $oldImage = '';
        if ($isEdit) {
            foreach ($projects as $p) {
                if ((int)$p['id'] === $id) {
                    $oldImage = $p['image'] ?? '';
                    break;
                }
            }
        }

        $removeImage = !empty($_POST['remove_image']);
        $image = $oldImage;
        if ($removeImage) {
            deleteProjectImage($image);
            $image = '';
        }
        if (!empty($_FILES['image']['name'])) {
            $uploaded = uploadProjectImage($_FILES['image'], $removeImage ? null : $oldImage);
            if ($uploaded) {
                $image = $uploaded;
            } else {
                $error = 'Şəkil yüklənmədi (max 3MB, JPG/PNG/WebP/GIF).';
            }
        }

        if (!$error) {
            $item = [
                'id' => $isEdit ? $id : nextId($projects),
                'name' => trim($_POST['name'] ?? ''),
                'desc' => trim($_POST['desc'] ?? ''),
                'overview' => trim($_POST['overview'] ?? ''),
                'status' => $_POST['status'] ?? 'ongoing',
                'url' => trim($_POST['url'] ?? ''),
                'year' => (int)($_POST['year'] ?? date('Y')),
                'category' => trim($_POST['category'] ?? ''),
                'duration' => trim($_POST['duration'] ?? ''),
                'progress_overall' => max(0, min(100, (int)($_POST['progress_overall'] ?? 0))),
                'image' => $image,
                'sort' => (int)($_POST['sort'] ?? 0),
                'featured' => !empty($_POST['featured']),
                'technologies' => parseTechnologiesInput($_POST['technologies'] ?? ''),
                'features' => parseLines($_POST['features'] ?? ''),
                'timeline' => parseTimelineFromPost(),
                'stats' => parseStatsFromPost(),
            ];
            if ($isEdit) {
                foreach ($projects as $i => $p) {
                    if ((int)$p['id'] === $id) {
                        $projects[$i] = $item;
                        break;
                    }
                }
                $message = 'Layihə yeniləndi.';
            } else {
                $projects[] = $item;
                $message = 'Layihə əlavə edildi.';
            }
            usort($projects, fn($a, $b) => ($a['sort'] ?? 0) <=> ($b['sort'] ?? 0));
            writeJson('projects.json', $projects);
        }
    }
    $projects = readJson('projects.json');
    usort($projects, fn($a, $b) => ($a['sort'] ?? 0) <=> ($b['sort'] ?? 0));
}

$edit = null;
if (isset($_GET['edit'])) {
    $eid = (int)$_GET['edit'];
    foreach ($projects as $p) {
        if ((int)$p['id'] === $eid) {
            $edit = $p;
            break;
        }
    }
}

require '_layout.php';
?>

<?php if ($message): ?><div class="adm-alert adm-alert-ok"><?= htmlspecialchars($message) ?></div><?php endif; ?>
<?php if ($error): ?><div class="adm-alert adm-alert-err"><?= htmlspecialchars($error) ?></div><?php endif; ?>

<div class="adm-card">
  <h2><?= $edit ? 'Layihəni redaktə et' : 'Yeni layihə' ?></h2>
  <form class="adm-form" method="post" enctype="multipart/form-data">
    <?php if ($edit): ?><input type="hidden" name="id" value="<?= (int)$edit['id'] ?>"><?php endif; ?>
    <div class="adm-row">
      <div><label>Ad</label><input name="name" required value="<?= htmlspecialchars($edit['name'] ?? '') ?>"></div>
      <div><label>Kateqoriya</label><input name="category" value="<?= htmlspecialchars($edit['category'] ?? '') ?>"></div>
    </div>
    <label>Təsvir</label>
    <textarea name="desc"><?= htmlspecialchars($edit['desc'] ?? '') ?></textarea>
    <div class="adm-row">
      <div>
        <label>Status</label>
        <select name="status">
          <?php foreach (['started' => 'Başlandı', 'ongoing' => 'Davam edir', 'completed' => 'Tamamlandı'] as $k => $v): ?>
            <option value="<?= $k ?>" <?= ($edit['status'] ?? '') === $k ? 'selected' : '' ?>><?= $v ?></option>
          <?php endforeach; ?>
        </select>
      </div>
      <div><label>İl</label><input type="number" name="year" value="<?= (int)($edit['year'] ?? date('Y')) ?>"></div>
    </div>
    <div class="adm-row">
      <div><label>URL</label><input name="url" placeholder="https://" value="<?= htmlspecialchars($edit['url'] ?? '') ?>"></div>
      <div><label>Sıra</label><input type="number" name="sort" value="<?= (int)($edit['sort'] ?? 0) ?>"></div>
    </div>
    <label style="text-transform:none;font-weight:500;display:flex;align-items:center;gap:8px;margin-top:12px">
      <input type="checkbox" name="featured" value="1" <?= !empty($edit['featured']) ? 'checked' : '' ?>>
      Ana səhifədə göstər (seçilmiş)
    </label>

    <h3 style="color:var(--head);margin:24px 0 12px;font-size:15px">Daxili səhifə məzmunu</h3>
    <label>Ətraflı təsvir (overview)</label>
    <textarea name="overview" rows="4"><?= htmlspecialchars($edit['overview'] ?? '') ?></textarea>
    <div class="adm-row">
      <div><label>Müddət</label><input name="duration" placeholder="6–12 ay" value="<?= htmlspecialchars($edit['duration'] ?? '') ?>"></div>
      <div><label>Ümumi tamamlanma %</label><input type="number" name="progress_overall" min="0" max="100" value="<?= (int)($edit['progress_overall'] ?? 0) ?>"></div>
    </div>
    <label>Texnologiyalar (vergüllə və ya sətir-sətir)</label>
    <textarea name="technologies" rows="2" placeholder="PHP, Laravel, Flutter"><?= htmlspecialchars(implode(', ', $edit['technologies'] ?? [])) ?></textarea>
    <label>Funksiyalar (hər sətirdə bir)</label>
    <textarea name="features" rows="4"><?= htmlspecialchars(implode("\n", $edit['features'] ?? [])) ?></textarea>

    <label style="margin-top:16px">İnkişaf planı (mərhələlər)</label>
    <?php
    $tl = $edit['timeline'] ?? [['title' => '', 'desc' => '', 'progress' => 0, 'status' => 'pending']];
    while (count($tl) < 4) {
        $tl[] = ['title' => '', 'desc' => '', 'progress' => 0, 'status' => 'pending'];
    }
    foreach (array_slice($tl, 0, 6) as $step):
    ?>
    <div class="adm-row" style="margin-bottom:8px;padding:10px;background:var(--ink3);border-radius:8px">
      <div><label>Mərhələ</label><input name="tl_title[]" value="<?= htmlspecialchars($step['title'] ?? '') ?>"></div>
      <div><label>%</label><input type="number" name="tl_progress[]" min="0" max="100" value="<?= (int)($step['progress'] ?? 0) ?>"></div>
      <div>
        <label>Status</label>
        <select name="tl_status[]">
          <option value="done" <?= ($step['status'] ?? '') === 'done' ? 'selected' : '' ?>>Bitib</option>
          <option value="active" <?= ($step['status'] ?? '') === 'active' ? 'selected' : '' ?>>Aktiv</option>
          <option value="pending" <?= ($step['status'] ?? '') === 'pending' ? 'selected' : '' ?>>Gözləyir</option>
        </select>
      </div>
    </div>
    <input name="tl_desc[]" placeholder="Qısa təsvir" value="<?= htmlspecialchars($step['desc'] ?? '') ?>" style="width:100%;margin-bottom:12px;padding:8px;background:var(--ink3);border:1px solid var(--border);border-radius:8px;color:var(--head)">
    <?php endforeach; ?>

    <label>Göstəricilər (qrafiklər)</label>
    <?php
    $stList = $edit['stats'] ?? [['label' => '', 'value' => '', 'max' => 100]];
    while (count($stList) < 3) {
        $stList[] = ['label' => '', 'value' => '', 'max' => 100];
    }
    foreach (array_slice($stList, 0, 4) as $st):
    ?>
    <div class="adm-row" style="margin-bottom:8px">
      <div><input name="st_label[]" placeholder="Etiket" value="<?= htmlspecialchars($st['label'] ?? '') ?>"></div>
      <div><input name="st_value[]" placeholder="Dəyər" value="<?= htmlspecialchars($st['value'] ?? '') ?>"></div>
      <div><input type="number" name="st_max[]" placeholder="Max" value="<?= (int)($st['max'] ?? 100) ?>"></div>
    </div>
    <?php endforeach; ?>

    <label>Layihə şəkli</label>
    <input type="file" name="image" accept="image/jpeg,image/png,image/webp,image/gif">
    <?php if (!empty($edit['image'])): ?>
      <img src="../<?= htmlspecialchars($edit['image']) ?>" alt="" class="adm-preview">
      <label style="text-transform:none;font-weight:400;margin-top:8px">
        <input type="checkbox" name="remove_image" value="1"> Şəkli sil
      </label>
    <?php endif; ?>
    <div class="adm-actions">
      <button type="submit" class="adm-btn"><i class="fa-solid fa-save"></i> Saxla</button>
      <?php if ($edit): ?>
        <a href="<?= htmlspecialchars('../project.php?id=' . (int)$edit['id']) ?>" class="adm-btn adm-btn-ghost" target="_blank">Saytda bax</a>
        <a href="projects.php" class="adm-btn adm-btn-ghost">Ləğv et</a>
      <?php endif; ?>
    </div>
  </form>
</div>

<div class="adm-card">
  <h2>Bütün layihələr</h2>
  <table class="adm-table">
    <thead><tr><th>Şəkil</th><th>Ad</th><th>★</th><th>Status</th><th>İl</th><th></th></tr></thead>
    <tbody>
    <?php foreach ($projects as $p): ?>
      <tr>
        <td>
          <?php if (!empty($p['image'])): ?>
            <img src="../<?= htmlspecialchars($p['image']) ?>" alt="" class="adm-thumb">
          <?php else: ?>
            <span style="color:var(--muted);font-size:11px">—</span>
          <?php endif; ?>
        </td>
        <td><strong style="color:var(--head)"><?= htmlspecialchars($p['name']) ?></strong><br><span style="color:var(--muted);font-size:11px"><?= htmlspecialchars($p['category'] ?? '') ?></span></td>
        <td><?= !empty($p['featured']) ? '★' : '—' ?></td>
        <td><span class="badge badge-<?= htmlspecialchars($p['status'] ?? 'ongoing') ?>"><?= projectStatusLabel($p['status'] ?? '') ?></span></td>
        <td><?= (int)($p['year'] ?? 0) ?></td>
        <td>
          <a href="../project.php?id=<?= (int)$p['id'] ?>" class="adm-btn adm-btn-ghost" style="padding:6px 10px;font-size:12px" target="_blank">Bax</a>
          <a href="?edit=<?= (int)$p['id'] ?>" class="adm-btn adm-btn-ghost" style="padding:6px 10px;font-size:12px">Redaktə</a>
          <form method="post" style="display:inline" onsubmit="return confirm('Silinsin?')">
            <input type="hidden" name="action" value="delete">
            <input type="hidden" name="id" value="<?= (int)$p['id'] ?>">
            <button type="submit" class="adm-btn adm-btn-danger" style="padding:6px 10px;font-size:12px">Sil</button>
          </form>
        </td>
      </tr>
    <?php endforeach; ?>
    </tbody>
  </table>
</div>

<?php require '_footer.php';
