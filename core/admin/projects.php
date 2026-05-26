<?php
require_once CORE_PATH . '/includes/admin-lang.php';
require_once CORE_PATH . '/includes/admin-i18n-ui.php';
requireAuth();
initAdminLang();

$pageTitle = at('projects.title');
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
        $message = at('projects.deleted');
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
            $existing = [];
            if ($isEdit) {
                foreach ($projects as $p) {
                    if ((int)$p['id'] === $id) {
                        $existing = $p;
                        break;
                    }
                }
            }
            $translations = adminSaveProjectTranslations($_POST, $existing);
            $def = defaultLang();
            $defBlock = $translations[$def] ?? [];
            $item = [
                'id' => $isEdit ? $id : nextId($projects),
                'name' => trim((string)($defBlock['name'] ?? $_POST['name'] ?? '')),
                'desc' => trim((string)($defBlock['desc'] ?? '')),
                'overview' => trim((string)($defBlock['overview'] ?? '')),
                'status' => $_POST['status'] ?? 'ongoing',
                'url' => trim($_POST['url'] ?? ''),
                'year' => (int)($_POST['year'] ?? date('Y')),
                'category' => trim((string)($defBlock['category'] ?? '')),
                'duration' => trim((string)($defBlock['duration'] ?? '')),
                'progress_overall' => max(0, min(100, (int)($_POST['progress_overall'] ?? 0))),
                'image' => $image,
                'sort' => (int)($_POST['sort'] ?? 0),
                'featured' => !empty($_POST['featured']),
                'technologies' => parseTechnologiesInput($_POST['technologies'] ?? ''),
                'features' => is_array($defBlock['features'] ?? null) ? $defBlock['features'] : [],
                'timeline' => is_array($defBlock['timeline'] ?? null) ? $defBlock['timeline'] : [],
                'stats' => is_array($defBlock['stats'] ?? null) ? $defBlock['stats'] : [],
                'translations' => $translations,
            ];
            if ($isEdit) {
                foreach ($projects as $i => $p) {
                    if ((int)$p['id'] === $id) {
                        $projects[$i] = $item;
                        break;
                    }
                }
                $message = at('projects.saved');
            } else {
                $projects[] = $item;
                $message = at('projects.added');
            }
            usort($projects, fn($a, $b) => ($a['sort'] ?? 0) <=> ($b['sort'] ?? 0));
            writeJson('projects.json', $projects);
        }
    }
    $projects = readJson('projects.json');
    usort($projects, fn($a, $b) => ($a['sort'] ?? 0) <=> ($b['sort'] ?? 0));
}

$edit = null;
$showForm = isset($_GET['new']) || isset($_GET['edit']);
if (isset($_GET['edit'])) {
    $eid = (int)$_GET['edit'];
    foreach ($projects as $p) {
        if ((int)$p['id'] === $eid) {
            $edit = $p;
            break;
        }
    }
}

$listPage = max(1, (int)($_GET['page'] ?? 1));
$perPage = ADMIN_PROJECTS_PER_PAGE;
$paged = paginate($projects, $listPage, $perPage);

require '_layout.php';
?>

<?php if ($message): ?><div class="adm-alert adm-alert-ok"><?= htmlspecialchars($message) ?></div><?php endif; ?>
<?php if ($error): ?><div class="adm-alert adm-alert-err"><?= htmlspecialchars($error) ?></div><?php endif; ?>

<?php if ($showForm): ?>
<div class="adm-card adm-card-form">
  <div class="adm-card-head-row">
    <h2><?= $edit ? htmlspecialchars(at('projects.edit')) : htmlspecialchars(at('projects.new')) ?></h2>
    <a href="projects.php" class="adm-btn adm-btn-ghost adm-btn-sm"><i class="fa-solid fa-arrow-left"></i> <?= htmlspecialchars(at('projects.all')) ?></a>
  </div>
  <?php require __DIR__ . '/includes/project-form.php'; ?>
</div>
<?php else: ?>
<div class="adm-card-head-actions" style="margin-bottom:16px">
  <a href="projects.php?new=1" class="adm-btn"><i class="fa-solid fa-plus"></i> <?= htmlspecialchars(at('projects.new')) ?></a>
</div>
<?php endif; ?>

<?php if (!$showForm): ?>
<div class="adm-card">
  <div class="adm-card-head-row">
    <h2><?= htmlspecialchars(at('projects.all')) ?></h2>
    <p class="adm-list-meta">
      <?= htmlspecialchars(at('pagination.total', ['n' => (string)$paged['total']])) ?>
      <?php if ($paged['total_pages'] > 1): ?>
        · <?= htmlspecialchars(at('pagination.page', ['page' => (string)$paged['page'], 'total' => (string)$paged['total_pages']])) ?>
      <?php endif; ?>
    </p>
  </div>
  <div class="adm-table-wrap">
  <table class="adm-table">
    <thead><tr><th><?= htmlspecialchars(at('table.image')) ?></th><th><?= htmlspecialchars(at('table.name')) ?></th><th>★</th><th><?= htmlspecialchars(at('table.status')) ?></th><th><?= htmlspecialchars(at('table.year')) ?></th><th></th></tr></thead>
    <tbody>
    <?php foreach ($paged['items'] as $p): ?>
      <tr>
        <td>
          <?php if (!empty($p['image'])): ?>
            <img src="<?= htmlspecialchars(asset($p['image'])) ?>" alt="" class="adm-thumb">
          <?php else: ?>
            <span class="adm-muted-dash">—</span>
          <?php endif; ?>
        </td>
        <td><strong class="adm-cell-title"><?= htmlspecialchars(localized($p, 'name') ?: ($p['name'] ?? '')) ?></strong><br><span class="adm-cell-sub"><?= htmlspecialchars(localized($p, 'category') ?: ($p['category'] ?? '')) ?></span></td>
        <td><?= !empty($p['featured']) ? '★' : '—' ?></td>
        <td><span class="badge badge-<?= htmlspecialchars($p['status'] ?? 'ongoing') ?>"><?= htmlspecialchars(at('projects.status.' . ($p['status'] ?? 'ongoing'))) ?></span></td>
        <td><?= (int)($p['year'] ?? 0) ?></td>
        <td class="adm-row-actions">
          <a href="../project.php?id=<?= (int)$p['id'] ?>" class="adm-btn adm-btn-ghost adm-btn-sm" target="_blank"><?= htmlspecialchars(at('common.view')) ?></a>
          <a href="?edit=<?= (int)$p['id'] ?>" class="adm-btn adm-btn-ghost adm-btn-sm"><?= htmlspecialchars(at('common.edit')) ?></a>
          <form method="post" class="adm-inline-form" onsubmit="return confirm('<?= htmlspecialchars(at('common.confirm_delete'), ENT_QUOTES) ?>')">
            <input type="hidden" name="action" value="delete">
            <input type="hidden" name="id" value="<?= (int)$p['id'] ?>">
            <button type="submit" class="adm-btn adm-btn-danger adm-btn-sm"><?= htmlspecialchars(at('common.delete')) ?></button>
          </form>
        </td>
      </tr>
    <?php endforeach; ?>
    </tbody>
  </table>
  </div>

  <?php if ($paged['total_pages'] > 1): ?>
  <nav class="adm-pagination" aria-label="<?= htmlspecialchars(at('pagination.page', ['page' => '1', 'total' => '1'])) ?>">
    <?php if ($paged['page'] > 1): ?>
      <a href="<?= htmlspecialchars(adminListUrl('projects.php', ['page' => $paged['page'] - 1])) ?>" class="adm-btn adm-btn-ghost adm-btn-sm" aria-label="Previous"><i class="fa-solid fa-chevron-left"></i></a>
    <?php endif; ?>
    <?php
    $start = max(1, $paged['page'] - 2);
    $end = min($paged['total_pages'], $paged['page'] + 2);
    for ($i = $start; $i <= $end; $i++):
    ?>
      <a href="<?= htmlspecialchars(adminListUrl('projects.php', ['page' => $i])) ?>" class="adm-page-num<?= $i === $paged['page'] ? ' is-active' : '' ?>"><?= $i ?></a>
    <?php endfor; ?>
    <?php if ($paged['page'] < $paged['total_pages']): ?>
      <a href="<?= htmlspecialchars(adminListUrl('projects.php', ['page' => $paged['page'] + 1])) ?>" class="adm-btn adm-btn-ghost adm-btn-sm" aria-label="Next"><i class="fa-solid fa-chevron-right"></i></a>
    <?php endif; ?>
  </nav>
  <?php endif; ?>
</div>
<?php endif; ?>

<?php require '_footer.php';
