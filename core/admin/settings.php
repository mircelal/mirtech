<?php
require_once CORE_PATH . '/includes/admin-lang.php';
require_once CORE_PATH . '/includes/admin-i18n-ui.php';
requireAuth();
initAdminLang();

$pageTitle = at('nav.settings');
$activeNav = 'settings';
$message = '';

$settings = readJson('settings.json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    adminVerifyCsrf();
    $settings['translations'] = adminSaveSettingsTranslations($_POST, $settings);
    $def = defaultLang();
    $block = $settings['translations'][$def] ?? [];
    $settings['tagline'] = trim((string)($block['tagline'] ?? $settings['tagline'] ?? ''));
    $settings['hero_eyebrow'] = trim((string)($block['hero_eyebrow'] ?? ''));
    $settings['hero_title'] = trim((string)($block['hero_title'] ?? ''));
    $settings['hero_title_highlight'] = trim((string)($block['hero_title_highlight'] ?? ''));
    $settings['hero_subtitle'] = trim((string)($block['hero_subtitle'] ?? ''));
    if (!empty($block['stats'])) {
        $settings['stats'] = $block['stats'];
    }
    if (!empty($block['why'])) {
        $settings['why'] = $block['why'];
    }
    if (!empty($block['included'])) {
        $settings['included'] = $block['included'];
    }
    $settings['footer_year'] = (int)($_POST['footer_year'] ?? date('Y'));

    $settings['contact']['whatsapp'] = trim($_POST['whatsapp'] ?? '');
    $settings['contact']['whatsapp_raw'] = preg_replace('/\D/', '', $_POST['whatsapp_raw'] ?? '');
    $settings['contact']['email'] = trim($_POST['email'] ?? '');
    $settings['contact']['website'] = trim($_POST['website'] ?? '');
    $settings['contact']['website_url'] = trim($_POST['website_url'] ?? '');

    $stats = [];
    for ($i = 0; $i < 4; $i++) {
        if (!empty($_POST['stat_value'][$i])) {
            $stats[] = [
                'value' => trim($_POST['stat_value'][$i]),
                'suffix' => trim($_POST['stat_suffix'][$i] ?? ''),
                'label' => trim($_POST['stat_label'][$i] ?? ''),
                'color' => $_POST['stat_color'][$i] ?? 'blue',
            ];
        }
    }
    if ($stats) {
        $settings['stats'] = $stats;
    }

    $settings['homepage'] = [
        'projects_limit' => (int)($_POST['hp_projects'] ?? 6),
        'technologies_limit' => (int)($_POST['hp_technologies'] ?? 10),
        'services_limit' => (int)($_POST['hp_services'] ?? 4),
    ];

    $oldSmtp = $settings['smtp'] ?? [];
    $smtpPass = trim($_POST['smtp_password'] ?? '');
    $settings['smtp'] = [
        'enabled' => !empty($_POST['smtp_enabled']),
        'host' => trim($_POST['smtp_host'] ?? ''),
        'port' => (int)($_POST['smtp_port'] ?? 587),
        'encryption' => $_POST['smtp_encryption'] ?? 'tls',
        'username' => trim($_POST['smtp_username'] ?? ''),
        'password' => $smtpPass !== '' ? $smtpPass : (string)($oldSmtp['password'] ?? ''),
        'from_email' => trim($_POST['smtp_from_email'] ?? ''),
        'from_name' => trim($_POST['smtp_from_name'] ?? 'MirTech'),
        'notify_email' => trim($_POST['smtp_notify_email'] ?? ''),
    ];

    $sameAsRaw = trim($_POST['seo_same_as'] ?? '');
    $sameAs = array_values(array_filter(array_map('trim', preg_split('/\r\n|\r|\n/', $sameAsRaw) ?: [])));
    $settings['seo'] = [
        'og_image' => trim($_POST['seo_og_image'] ?? ''),
        'logo_url' => trim($_POST['seo_logo_url'] ?? ''),
        'google_site_verification' => trim($_POST['seo_google_verification'] ?? ''),
        'twitter_site' => trim($_POST['seo_twitter_site'] ?? ''),
        'twitter_creator' => trim($_POST['seo_twitter_creator'] ?? ''),
        'same_as' => $sameAs,
        'founding_date' => trim($_POST['seo_founding_date'] ?? '2010') ?: '2010',
        'area_served' => trim($_POST['seo_area_served'] ?? 'AZ') ?: 'AZ',
    ];

    writeJson('settings.json', $settings);
    $message = 'Parametrlər saxlanıldı.';
}

$stats = $settings['stats'] ?? [];
$seo = $settings['seo'] ?? [];
$contact = $settings['contact'] ?? [];
$smtp = $settings['smtp'] ?? [];
$smtpEnabled = !empty($smtp['enabled']);
$hp = $settings['homepage'] ?? [];

require '_layout.php';
?>

<?php if ($message): ?><div class="adm-alert adm-alert-ok"><?= htmlspecialchars($message) ?></div><?php endif; ?>

<form class="adm-settings" method="post" id="settingsForm">
    <?= adminCsrfField() ?>
  <nav class="adm-settings-tabs" aria-label="Parametr bölmələri">
    <button type="button" class="adm-settings-tab is-active" data-settings-tab="hero">
      <i class="fa-solid fa-house" aria-hidden="true"></i><span>Hero</span>
    </button>
    <button type="button" class="adm-settings-tab" data-settings-tab="stats">
      <i class="fa-solid fa-chart-simple" aria-hidden="true"></i><span>Statistika</span>
    </button>
    <button type="button" class="adm-settings-tab" data-settings-tab="contact">
      <i class="fa-solid fa-address-book" aria-hidden="true"></i><span>Əlaqə</span>
    </button>
    <button type="button" class="adm-settings-tab" data-settings-tab="homepage">
      <i class="fa-solid fa-table-cells-large" aria-hidden="true"></i><span>Ana səhifə</span>
    </button>
    <button type="button" class="adm-settings-tab" data-settings-tab="seo">
      <i class="fa-solid fa-magnifying-glass-chart" aria-hidden="true"></i><span>SEO</span>
    </button>
    <button type="button" class="adm-settings-tab" data-settings-tab="smtp">
      <i class="fa-solid fa-envelope" aria-hidden="true"></i><span>Email / SMTP</span>
    </button>
  </nav>

  <div class="adm-settings-panels">
    <!-- Hero -->
    <section class="adm-settings-panel adm-card adm-form is-active" data-settings-panel="hero">
      <header class="adm-settings-panel-head">
        <h2>Ana səhifə — Hero</h2>
        <p>Əsas başlıq və qısa təqdimat mətni.</p>
      </header>
      <div class="adm-i18n-box">
      <?= adminLangTabs('adm-lang', 'content') ?>
      <div class="adm-i18n-panels">
      <?php foreach (adminContentLangs() as $li => $l):
        $code = (string)($l['code'] ?? '');
        $panelActive = ($code === defaultLang()) ? ' is-active' : '';
        $trStats = $settings['translations'][$code]['stats'] ?? ($code === defaultLang() ? $stats : []);
      ?>
      <div class="adm-lang-panel<?= $panelActive ?>" data-lang-panel="<?= htmlspecialchars($code) ?>" data-lang-scope="content">
        <label>Tagline (<?= strtoupper(htmlspecialchars($code)) ?>)</label>
        <input name="tr_<?= htmlspecialchars($code) ?>_tagline" value="<?= htmlspecialchars(adminTr($settings, $code, 'tagline')) ?>">
        <label>Eyebrow</label>
        <input name="tr_<?= htmlspecialchars($code) ?>_hero_eyebrow" value="<?= htmlspecialchars(adminTr($settings, $code, 'hero_eyebrow')) ?>">
        <label>Başlıq — 1-ci sətir</label>
        <input name="tr_<?= htmlspecialchars($code) ?>_hero_title" value="<?= htmlspecialchars(adminTr($settings, $code, 'hero_title')) ?>">
        <label>Başlıq — vurğulu</label>
        <input name="tr_<?= htmlspecialchars($code) ?>_hero_title_highlight" value="<?= htmlspecialchars(adminTr($settings, $code, 'hero_title_highlight')) ?>">
        <label>Alt mətn</label>
        <textarea name="tr_<?= htmlspecialchars($code) ?>_hero_subtitle" rows="3"><?= htmlspecialchars(adminTr($settings, $code, 'hero_subtitle')) ?></textarea>
        <h3 style="margin:20px 0 10px;font-size:14px;color:var(--head)">Statistika</h3>
        <div class="adm-stat-cards">
          <?php for ($i = 0; $i < 4; $i++):
            $st = $trStats[$i] ?? ['value' => '', 'suffix' => '', 'label' => '', 'color' => 'blue'];
          ?>
          <div class="adm-stat-card">
            <span class="adm-stat-card-num">#<?= $i + 1 ?></span>
            <div class="adm-row adm-row-stat">
              <div>
                <label>Dəyər</label>
                <input name="tr_<?= htmlspecialchars($code) ?>_stat_value[]" value="<?= htmlspecialchars($st['value'] ?? '') ?>">
              </div>
              <div>
                <label>Suffix</label>
                <input name="tr_<?= htmlspecialchars($code) ?>_stat_suffix[]" value="<?= htmlspecialchars($st['suffix'] ?? '') ?>">
              </div>
            </div>
            <label>Etiket</label>
            <input name="tr_<?= htmlspecialchars($code) ?>_stat_label[]" value="<?= htmlspecialchars($st['label'] ?? '') ?>">
            <label>Rəng</label>
            <select name="tr_<?= htmlspecialchars($code) ?>_stat_color[]">
              <?php foreach (['blue' => 'Mavi', 'teal' => 'Yaşıl', 'amber' => 'Amber', 'purple' => 'Bənövşəyi'] as $c => $lbl): ?>
                <option value="<?= $c ?>" <?= ($st['color'] ?? '') === $c ? 'selected' : '' ?>><?= $lbl ?></option>
              <?php endforeach; ?>
            </select>
          </div>
          <?php endfor; ?>
        </div>
        <h3 style="margin:20px 0 10px;font-size:14px;color:var(--head)">Niyə MirTech (why)</h3>
        <?php
        $trWhy = $settings['translations'][$code]['why'] ?? ($code === defaultLang() ? ($settings['why'] ?? []) : []);
        for ($wi = 0; $wi < 3; $wi++):
          $w = $trWhy[$wi] ?? ['title' => '', 'desc' => '', 'icon' => 'fa-star', 'color' => 'blue'];
        ?>
        <div class="adm-row" style="margin-bottom:8px;padding:10px;background:var(--ink3);border-radius:8px">
          <div><label>Başlıq</label><input name="tr_<?= htmlspecialchars($code) ?>_why_title[]" value="<?= htmlspecialchars($w['title'] ?? '') ?>"></div>
          <div><label>İkon</label><input name="tr_<?= htmlspecialchars($code) ?>_why_icon[]" value="<?= htmlspecialchars($w['icon'] ?? 'fa-star') ?>"></div>
        </div>
        <textarea name="tr_<?= htmlspecialchars($code) ?>_why_desc[]" rows="2" placeholder="Təsvir" style="width:100%;margin-bottom:12px"><?= htmlspecialchars($w['desc'] ?? '') ?></textarea>
        <input type="hidden" name="tr_<?= htmlspecialchars($code) ?>_why_color[]" value="<?= htmlspecialchars($w['color'] ?? 'blue') ?>">
        <?php endfor; ?>
        <label>Daxil olanlar (hər sətirdə)</label>
        <textarea name="tr_<?= htmlspecialchars($code) ?>_included" rows="4"><?= htmlspecialchars(implode("\n", $settings['translations'][$code]['included'] ?? ($code === defaultLang() ? ($settings['included'] ?? []) : []))) ?></textarea>
      </div>
      <?php endforeach; ?>
      </div>
      </div>
    </section>

    <section class="adm-settings-panel adm-card adm-form" data-settings-panel="seo" hidden>
      <header class="adm-settings-panel-head">
        <h2>SEO və Google</h2>
        <p>Open Graph, doğrulama və strukturlaşdırılmış məlumat üçün.</p>
      </header>
      <p class="adm-hint">Sayt URL-i <strong>Əlaqə</strong> tabındakı «Sayt URL» sahəsindən götürülür (canonical, sitemap).</p>
      <label>Varsayılan OG şəkil (URL və ya yol, məs. assets/img/og-default.svg)</label>
      <input name="seo_og_image" value="<?= htmlspecialchars($seo['og_image'] ?? '') ?>" placeholder="https://mirtech.az/assets/img/og-default.svg">
      <label>Logo URL (schema.org Organization)</label>
      <input name="seo_logo_url" value="<?= htmlspecialchars($seo['logo_url'] ?? '') ?>">
      <label>Google Search Console doğrulama kodu</label>
      <input name="seo_google_verification" value="<?= htmlspecialchars($seo['google_site_verification'] ?? '') ?>" placeholder="meta content dəyəri">
      <div class="adm-row">
        <div>
          <label>Twitter @site</label>
          <input name="seo_twitter_site" value="<?= htmlspecialchars($seo['twitter_site'] ?? '') ?>" placeholder="@mirtech">
        </div>
        <div>
          <label>Twitter @creator</label>
          <input name="seo_twitter_creator" value="<?= htmlspecialchars($seo['twitter_creator'] ?? '') ?>">
        </div>
      </div>
      <label>Sosial profillər (hər sətirdə bir URL — sameAs)</label>
      <textarea name="seo_same_as" rows="4" placeholder="https://github.com/..."><?= htmlspecialchars(implode("\n", $seo['same_as'] ?? [])) ?></textarea>
      <div class="adm-row">
        <div>
          <label>Təsis ili</label>
          <input name="seo_founding_date" value="<?= htmlspecialchars($seo['founding_date'] ?? '2010') ?>">
        </div>
        <div>
          <label>Xidmət regionu (ISO)</label>
          <input name="seo_area_served" value="<?= htmlspecialchars($seo['area_served'] ?? 'AZ') ?>">
        </div>
      </div>
      <p class="adm-hint">Sitemap: <a href="<?= htmlspecialchars(asset('sitemap.xml')) ?>" target="_blank" rel="noopener"><?= htmlspecialchars(asset('sitemap.xml')) ?></a> · robots.txt: <a href="<?= htmlspecialchars(asset('robots.txt')) ?>" target="_blank" rel="noopener"><?= htmlspecialchars(asset('robots.txt')) ?></a></p>
    </section>

    <!-- Statistika (köhnə tab — hero içindədir) -->
    <section class="adm-settings-panel adm-card adm-form" data-settings-panel="stats" hidden>
      <p class="adm-hint">Statistika mətnləri indi <strong>Hero</strong> tabında hər dil üçün redaktə olunur.</p>
    </section>

    <!-- Əlaqə -->
    <section class="adm-settings-panel adm-card adm-form" data-settings-panel="contact" hidden>
      <header class="adm-settings-panel-head">
        <h2>Əlaqə və footer</h2>
        <p>WhatsApp, email və sayt linkləri.</p>
      </header>
      <div class="adm-row">
        <div>
          <label>WhatsApp (göstərilən)</label>
          <input name="whatsapp" value="<?= htmlspecialchars($contact['whatsapp'] ?? '') ?>" placeholder="+994 70 000 00 00">
        </div>
        <div>
          <label>WhatsApp (rəqəm, wa.me)</label>
          <input name="whatsapp_raw" value="<?= htmlspecialchars($contact['whatsapp_raw'] ?? '') ?>" placeholder="994700000000">
        </div>
      </div>
      <label>Email</label>
      <input type="email" name="email" value="<?= htmlspecialchars($contact['email'] ?? '') ?>">
      <div class="adm-row">
        <div>
          <label>Sayt adı</label>
          <input name="website" value="<?= htmlspecialchars($contact['website'] ?? '') ?>">
        </div>
        <div>
          <label>Sayt URL</label>
          <input type="url" name="website_url" value="<?= htmlspecialchars($contact['website_url'] ?? '') ?>" placeholder="https://">
        </div>
      </div>
      <label>Footer — il</label>
      <input type="number" name="footer_year" min="2000" max="2100" value="<?= (int)($settings['footer_year'] ?? date('Y')) ?>">
    </section>

    <!-- Ana səhifə -->
    <section class="adm-settings-panel adm-card adm-form" data-settings-panel="homepage" hidden>
      <header class="adm-settings-panel-head">
        <h2>Ana səhifə limitləri</h2>
        <p>Seçilmiş elementlərin maksimum sayı (hamısı göstərilmir).</p>
      </header>
      <div class="adm-hp-cards">
        <div class="adm-hp-card">
          <i class="fa-solid fa-folder-open" aria-hidden="true"></i>
          <label>Layihələr (max)</label>
          <input type="number" name="hp_projects" min="1" max="12" value="<?= (int)($hp['projects_limit'] ?? 6) ?>">
        </div>
        <div class="adm-hp-card">
          <i class="fa-solid fa-microchip" aria-hidden="true"></i>
          <label>Texnologiyalar (max)</label>
          <input type="number" name="hp_technologies" min="1" max="20" value="<?= (int)($hp['technologies_limit'] ?? 10) ?>">
        </div>
        <div class="adm-hp-card">
          <i class="fa-solid fa-briefcase" aria-hidden="true"></i>
          <label>Xidmətlər (max)</label>
          <input type="number" name="hp_services" min="1" max="8" value="<?= (int)($hp['services_limit'] ?? 4) ?>">
        </div>
      </div>
    </section>

    <!-- SMTP -->
    <section class="adm-settings-panel adm-card adm-form" data-settings-panel="smtp" hidden>
      <header class="adm-settings-panel-head">
        <h2>Email / SMTP</h2>
        <p>Kalkulyator sorğuları bu ünvana göndərilir.</p>
      </header>
      <label class="adm-check">
        <input type="checkbox" name="smtp_enabled" value="1" <?= $smtpEnabled ? 'checked' : '' ?>>
        <span>SMTP aktiv — təklif bildirişləri emailə getsin</span>
      </label>
      <div class="adm-settings-hint">
        Gmail: <strong>2FA</strong> + <a href="https://myaccount.google.com/apppasswords" target="_blank" rel="noopener">tətbiq şifrəsi</a>.
        Əvvəlcə parametrləri saxlayın, sonra test edin.
      </div>
      <label>Bildiriş emaili (sizin ünvanınız)</label>
      <input type="email" name="smtp_notify_email" placeholder="<?= htmlspecialchars($contact['email'] ?? 'info@mirtech.az') ?>" value="<?= htmlspecialchars($smtp['notify_email'] ?? '') ?>">
      <p class="adm-field-hint">Boşdursa, «Əlaqə» tabındakı email istifadə olunur.</p>
      <div class="adm-row">
        <div>
          <label>SMTP server</label>
          <input name="smtp_host" value="<?= htmlspecialchars($smtp['host'] ?? 'smtp.gmail.com') ?>">
        </div>
        <div>
          <label>Port</label>
          <input type="number" name="smtp_port" value="<?= (int)($smtp['port'] ?? 587) ?>">
        </div>
      </div>
      <label>Şifrələmə</label>
      <select name="smtp_encryption">
        <?php foreach (['tls' => 'TLS (587)', 'ssl' => 'SSL (465)', 'none' => 'Yoxdur (25)'] as $k => $v): ?>
          <option value="<?= $k ?>" <?= ($smtp['encryption'] ?? 'tls') === $k ? 'selected' : '' ?>><?= $v ?></option>
        <?php endforeach; ?>
      </select>
      <div class="adm-row">
        <div>
          <label>SMTP istifadəçi</label>
          <input name="smtp_username" autocomplete="off" value="<?= htmlspecialchars($smtp['username'] ?? '') ?>" placeholder="email@gmail.com">
        </div>
        <div>
          <label>SMTP şifrə</label>
          <input type="password" name="smtp_password" autocomplete="new-password" placeholder="<?= !empty($smtp['password']) ? '•••••••• (dəyişmək üçün yazın)' : 'Tətbiq şifrəsi' ?>">
        </div>
      </div>
      <div class="adm-row">
        <div>
          <label>Göndərən email</label>
          <input type="email" name="smtp_from_email" value="<?= htmlspecialchars($smtp['from_email'] ?? '') ?>">
        </div>
        <div>
          <label>Göndərən ad</label>
          <input name="smtp_from_name" value="<?= htmlspecialchars($smtp['from_name'] ?? 'MirTech') ?>">
        </div>
      </div>
      <p id="smtpTestResult" class="adm-smtp-result" hidden role="status"></p>
    </section>
  </div>

  <div class="adm-settings-bar">
    <button type="submit" class="adm-btn adm-settings-save">
      <i class="fa-solid fa-floppy-disk" aria-hidden="true"></i> Saxla
    </button>
    <button type="button" class="adm-btn adm-btn-ghost" id="btnSmtpTest" data-smtp-only>
      <i class="fa-solid fa-paper-plane" aria-hidden="true"></i> Test email
    </button>
  </div>
</form>

<script>
(function () {
  const tabs = document.querySelectorAll('[data-settings-tab]');
  const panels = document.querySelectorAll('[data-settings-panel]');
  const smtpTestBtn = document.getElementById('btnSmtpTest');
  const smtpResult = document.getElementById('smtpTestResult');
  const validTabs = ['hero', 'stats', 'contact', 'homepage', 'smtp'];

  function setActive(id) {
    if (!validTabs.includes(id)) id = 'hero';
    tabs.forEach(function (t) {
      const on = t.dataset.settingsTab === id;
      t.classList.toggle('is-active', on);
      t.setAttribute('aria-selected', on ? 'true' : 'false');
    });
    panels.forEach(function (p) {
      const on = p.dataset.settingsPanel === id;
      p.classList.toggle('is-active', on);
      p.hidden = !on;
    });
    if (smtpTestBtn) {
      smtpTestBtn.style.display = id === 'smtp' ? '' : 'none';
    }
    if (history.replaceState) {
      history.replaceState(null, '', '#' + id);
    }
  }

  tabs.forEach(function (t) {
    t.addEventListener('click', function () {
      setActive(t.dataset.settingsTab);
    });
  });

  var hash = (location.hash || '').replace(/^#/, '');
  setActive(validTabs.includes(hash) ? hash : 'hero');

  if (smtpTestBtn && smtpResult) {
    smtpTestBtn.addEventListener('click', async function () {
      smtpTestBtn.disabled = true;
      smtpResult.hidden = false;
      smtpResult.className = 'adm-smtp-result is-pending';
      smtpResult.textContent = 'Göndərilir... (əvvəlcə «Saxla» basın)';
      try {
        var csrf = document.querySelector('meta[name="csrf-token"]');
        var r = await fetch('smtp-test.php', {
          method: 'POST',
          credentials: 'same-origin',
          headers: csrf ? { 'X-CSRF-Token': csrf.content } : {}
        });
        var data = await r.json();
        if (data.ok) {
          smtpResult.className = 'adm-smtp-result is-ok';
          smtpResult.textContent = 'Test mesajı göndərildi. Gələn qutusunu yoxlayın (spam da).';
        } else {
          smtpResult.className = 'adm-smtp-result is-err';
          smtpResult.textContent = 'Xəta: ' + (data.error || 'naməlum');
        }
      } catch (e) {
        smtpResult.className = 'adm-smtp-result is-err';
        smtpResult.textContent = 'Şəbəkə xətası';
      }
      smtpTestBtn.disabled = false;
    });
  }
})();
</script>

<?php require '_footer.php';
