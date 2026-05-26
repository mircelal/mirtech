<?php
/** @var array|null $edit */
$edit = $edit ?? null;
$isEdit = $edit !== null;
?>
<form class="adm-form adm-project-form" method="post" enctype="multipart/form-data" id="projectForm">
  <?php if ($isEdit): ?><input type="hidden" name="id" value="<?= (int)$edit['id'] ?>"><?php endif; ?>

  <nav class="adm-form-tabs" role="tablist" aria-label="<?= htmlspecialchars(at('projects.title')) ?>">
    <button type="button" class="adm-form-tab is-active" data-form-tab="basic" role="tab"><?= htmlspecialchars(at('projects.tab.basic')) ?></button>
    <button type="button" class="adm-form-tab" data-form-tab="content" role="tab"><?= htmlspecialchars(at('projects.tab.content')) ?></button>
    <button type="button" class="adm-form-tab" data-form-tab="media" role="tab"><?= htmlspecialchars(at('projects.tab.media')) ?></button>
    <button type="button" class="adm-form-tab" data-form-tab="extra" role="tab"><?= htmlspecialchars(at('projects.tab.extra')) ?></button>
  </nav>

  <section class="adm-form-panel is-active" data-form-panel="basic">
    <div class="adm-compact-grid adm-compact-grid-4">
      <div>
        <label><?= htmlspecialchars(at('projects.status')) ?></label>
        <select name="status">
          <?php foreach (['started', 'ongoing', 'completed'] as $k): ?>
            <option value="<?= $k ?>" <?= ($edit['status'] ?? 'ongoing') === $k ? 'selected' : '' ?>><?= htmlspecialchars(at('projects.status.' . $k)) ?></option>
          <?php endforeach; ?>
        </select>
      </div>
      <div>
        <label><?= htmlspecialchars(at('projects.year')) ?></label>
        <input type="number" name="year" value="<?= (int)($edit['year'] ?? date('Y')) ?>">
      </div>
      <div>
        <label><?= htmlspecialchars(at('projects.sort')) ?></label>
        <input type="number" name="sort" value="<?= (int)($edit['sort'] ?? 0) ?>">
      </div>
      <div>
        <label><?= htmlspecialchars(at('projects.progress')) ?></label>
        <input type="number" name="progress_overall" min="0" max="100" value="<?= (int)($edit['progress_overall'] ?? 0) ?>">
      </div>
    </div>
    <div class="adm-compact-grid adm-compact-grid-2" style="margin-top:12px">
      <div>
        <label><?= htmlspecialchars(at('projects.url')) ?></label>
        <input name="url" placeholder="https://" value="<?= htmlspecialchars($edit['url'] ?? '') ?>">
      </div>
      <div>
        <label><?= htmlspecialchars(at('projects.technologies')) ?></label>
        <input name="technologies" placeholder="<?= htmlspecialchars(at('projects.technologies_hint')) ?>" value="<?= htmlspecialchars(implode(', ', $edit['technologies'] ?? [])) ?>">
      </div>
    </div>
    <label class="adm-check-row">
      <input type="checkbox" name="featured" value="1" <?= !empty($edit['featured']) ? 'checked' : '' ?>>
      <span><?= htmlspecialchars(at('projects.featured')) ?></span>
    </label>
  </section>

  <section class="adm-form-panel" data-form-panel="content" hidden>
    <div class="adm-i18n-box">
      <h3 class="adm-i18n-box-title"><?= htmlspecialchars(at('common.lang_box')) ?></h3>
      <?= adminLangTabs('adm-lang', 'content') ?>
      <div class="adm-i18n-panels">
    <?php foreach (adminContentLangs() as $li => $l):
      $code = (string)($l['code'] ?? '');
      $panelActive = ($code === defaultLang()) ? ' is-active' : '';
      ?>
    <div class="adm-lang-panel<?= $panelActive ?>" data-lang-panel="<?= htmlspecialchars($code) ?>" data-lang-scope="content">
      <div class="adm-compact-grid adm-compact-grid-2">
        <div>
          <label><?= htmlspecialchars(at('projects.name')) ?> (<?= strtoupper(htmlspecialchars($code)) ?>)</label>
          <input name="tr_<?= htmlspecialchars($code) ?>_name" value="<?= htmlspecialchars(adminTr($edit ?? [], $code, 'name')) ?>" <?= $code === defaultLang() ? 'required' : '' ?>>
        </div>
        <div>
          <label><?= htmlspecialchars(at('projects.category')) ?></label>
          <input name="tr_<?= htmlspecialchars($code) ?>_category" value="<?= htmlspecialchars(adminTr($edit ?? [], $code, 'category')) ?>">
        </div>
      </div>
      <div class="adm-compact-grid adm-compact-grid-2">
        <div>
          <label><?= htmlspecialchars(at('projects.desc')) ?></label>
          <textarea name="tr_<?= htmlspecialchars($code) ?>_desc" rows="2"><?= htmlspecialchars(adminTr($edit ?? [], $code, 'desc')) ?></textarea>
        </div>
        <div>
          <label><?= htmlspecialchars(at('projects.duration')) ?></label>
          <input name="tr_<?= htmlspecialchars($code) ?>_duration" placeholder="6–12 ay" value="<?= htmlspecialchars(adminTr($edit ?? [], $code, 'duration')) ?>">
        </div>
      </div>
      <details class="adm-details">
        <summary><?= htmlspecialchars(at('projects.overview')) ?></summary>
        <textarea name="tr_<?= htmlspecialchars($code) ?>_overview" rows="3"><?= htmlspecialchars(adminTr($edit ?? [], $code, 'overview')) ?></textarea>
      </details>
      <details class="adm-details">
        <summary><?= htmlspecialchars(at('projects.features')) ?></summary>
        <textarea name="tr_<?= htmlspecialchars($code) ?>_features" rows="3" placeholder="<?= htmlspecialchars(at('projects.features_hint')) ?>"><?= htmlspecialchars(adminTrLines($edit ?? [], $code, 'features')) ?></textarea>
      </details>
    </div>
    <?php endforeach; ?>
      </div>
    </div>
  </section>

  <section class="adm-form-panel" data-form-panel="media" hidden>
    <label><?= htmlspecialchars(at('projects.image')) ?></label>
    <input type="file" name="image" accept="image/jpeg,image/png,image/webp,image/gif">
    <?php if (!empty($edit['image'])): ?>
      <img src="<?= htmlspecialchars(asset($edit['image'])) ?>" alt="" class="adm-preview">
      <label class="adm-check-row">
        <input type="checkbox" name="remove_image" value="1">
        <span><?= htmlspecialchars(at('projects.remove_image')) ?></span>
      </label>
    <?php endif; ?>
  </section>

  <section class="adm-form-panel" data-form-panel="extra" hidden>
    <div class="adm-i18n-box">
      <h3 class="adm-i18n-box-title"><?= htmlspecialchars(at('projects.extra_hint')) ?></h3>
      <?= adminLangTabs('adm-lang', 'extra') ?>
      <div class="adm-i18n-panels">
    <?php foreach (adminContentLangs() as $li => $l):
      $code = (string)($l['code'] ?? '');
      $panelActive = ($code === defaultLang()) ? ' is-active' : '';
      $tl = ($edit ?? [])['translations'][$code]['timeline'] ?? ($code === defaultLang() ? (($edit ?? [])['timeline'] ?? []) : []);
      $tl = array_slice(array_merge($tl, array_fill(0, 3, ['title' => '', 'desc' => '', 'progress' => 0, 'status' => 'pending'])), 0, 4);
      $stList = ($edit ?? [])['translations'][$code]['stats'] ?? ($code === defaultLang() ? (($edit ?? [])['stats'] ?? []) : []);
      $stList = array_slice(array_merge($stList, array_fill(0, 2, ['label' => '', 'value' => '', 'max' => 100])), 0, 3);
    ?>
    <div class="adm-lang-panel<?= $panelActive ?>" data-lang-panel="<?= htmlspecialchars($code) ?>" data-lang-scope="extra">
      <details class="adm-details" open>
        <summary><?= htmlspecialchars(at('projects.timeline')) ?> (<?= strtoupper(htmlspecialchars($code)) ?>)</summary>
        <table class="adm-mini-table">
          <thead>
            <tr>
              <th><?= htmlspecialchars(at('projects.timeline_title')) ?></th>
              <th>%</th>
              <th><?= htmlspecialchars(at('projects.status')) ?></th>
              <th><?= htmlspecialchars(at('projects.timeline_desc')) ?></th>
            </tr>
          </thead>
          <tbody>
          <?php foreach ($tl as $step): ?>
            <tr>
              <td><input name="tl_title_<?= htmlspecialchars($code) ?>[]" value="<?= htmlspecialchars($step['title'] ?? '') ?>"></td>
              <td class="col-narrow"><input type="number" name="tl_progress_<?= htmlspecialchars($code) ?>[]" min="0" max="100" value="<?= (int)($step['progress'] ?? 0) ?>"></td>
              <td class="col-narrow">
                <select name="tl_status_<?= htmlspecialchars($code) ?>[]">
                  <option value="done" <?= ($step['status'] ?? '') === 'done' ? 'selected' : '' ?>><?= htmlspecialchars(at('projects.tl.done')) ?></option>
                  <option value="active" <?= ($step['status'] ?? '') === 'active' ? 'selected' : '' ?>><?= htmlspecialchars(at('projects.tl.active')) ?></option>
                  <option value="pending" <?= ($step['status'] ?? '') === 'pending' ? 'selected' : '' ?>><?= htmlspecialchars(at('projects.tl.pending')) ?></option>
                </select>
              </td>
              <td><input name="tl_desc_<?= htmlspecialchars($code) ?>[]" value="<?= htmlspecialchars($step['desc'] ?? '') ?>"></td>
            </tr>
          <?php endforeach; ?>
          </tbody>
        </table>
      </details>
      <details class="adm-details">
        <summary><?= htmlspecialchars(at('projects.stats')) ?></summary>
        <table class="adm-mini-table">
          <thead>
            <tr>
              <th><?= htmlspecialchars(at('projects.stats_label')) ?></th>
              <th><?= htmlspecialchars(at('projects.stats_value')) ?></th>
              <th><?= htmlspecialchars(at('projects.stats_max')) ?></th>
            </tr>
          </thead>
          <tbody>
          <?php foreach ($stList as $st): ?>
            <tr>
              <td><input name="st_label_<?= htmlspecialchars($code) ?>[]" value="<?= htmlspecialchars($st['label'] ?? '') ?>"></td>
              <td><input name="st_value_<?= htmlspecialchars($code) ?>[]" value="<?= htmlspecialchars($st['value'] ?? '') ?>"></td>
              <td class="col-narrow"><input type="number" name="st_max_<?= htmlspecialchars($code) ?>[]" value="<?= (int)($st['max'] ?? 100) ?>"></td>
            </tr>
          <?php endforeach; ?>
          </tbody>
        </table>
      </details>
    </div>
    <?php endforeach; ?>
      </div>
    </div>
  </section>

  <div class="adm-actions adm-actions-sticky">
    <button type="submit" class="adm-btn"><i class="fa-solid fa-save"></i> <?= htmlspecialchars(at('common.save')) ?></button>
    <?php if ($isEdit): ?>
      <a href="<?= htmlspecialchars('../project.php?id=' . (int)$edit['id']) ?>" class="adm-btn adm-btn-ghost" target="_blank"><?= htmlspecialchars(at('projects.view_site')) ?></a>
      <a href="projects.php" class="adm-btn adm-btn-ghost"><?= htmlspecialchars(at('common.cancel')) ?></a>
    <?php endif; ?>
  </div>
</form>
