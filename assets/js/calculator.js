(function () {
  const TYPE_CATS = [
    { id: 'all', n: 'Hamısı' },
    { id: 'web', n: 'Veb sayt' },
    { id: 'mobile', n: 'Mobil' },
    { id: 'software', n: 'Proqram / Panel' },
    { id: 'desktop', n: 'Desktop' },
    { id: 'infra', n: 'Server' },
  ];

  const TYPES = [
    { id: 'landing', cat: 'web', group: 'web', fa: 'fa-solid fa-rectangle-ad', n: 'Landing Page', d: 'Tək səhifəli tanıtım', b: 350 },
    { id: 'corporate', cat: 'web', group: 'web', fa: 'fa-solid fa-building', n: 'Korporativ sayt', d: 'Şirkət / xidmət', b: 650 },
    { id: 'ecommerce', cat: 'web', group: 'web', fa: 'fa-solid fa-cart-shopping', n: 'E-Ticarət', d: 'Onlayn mağaza', b: 1300 },
    { id: 'portal', cat: 'web', group: 'web', fa: 'fa-solid fa-newspaper', n: 'Portal / Media', d: 'Xəbər, kontent', b: 1100 },
    { id: 'blog', cat: 'web', group: 'web', fa: 'fa-solid fa-pen-nib', n: 'Blog / Jurnal', d: 'Məqalə platforması', b: 450 },
    { id: 'wordpress', cat: 'web', group: 'web', fa: 'fa-brands fa-wordpress', n: 'WordPress', d: 'CMS, WooCommerce', b: 550 },
    { id: 'dle', cat: 'web', group: 'web', fa: 'fa-solid fa-newspaper', n: 'DLE (DataLife)', d: 'Portal, xəbər saytı', b: 750 },

    { id: 'mobile_flutter', cat: 'mobile', group: 'mobile', fa: 'fa-solid fa-mobile-screen', n: 'Mobil (Flutter)', d: 'Android + iOS bir kod', b: 2800 },
    { id: 'mobile_android', cat: 'mobile', group: 'mobile', fa: 'fa-brands fa-android', n: 'Android App', d: 'Kotlin / native', b: 2200 },
    { id: 'mobile_ios', cat: 'mobile', group: 'mobile', fa: 'fa-brands fa-apple', n: 'iOS App', d: 'Swift / native', b: 2400 },
    { id: 'mobile_pwa', cat: 'mobile', group: 'mobile', fa: 'fa-solid fa-mobile-screen-button', n: 'PWA', d: 'Veb əsaslı mobil', b: 900 },

    { id: 'admin_panel', cat: 'software', group: 'software', fa: 'fa-solid fa-sliders', n: 'İdarə Paneli', d: 'Admin dashboard', b: 1800 },
    { id: 'erp', cat: 'software', group: 'software', fa: 'fa-solid fa-gears', n: 'ERP Sistemi', d: 'Anbar, satış, HR', b: 4500 },
    { id: 'crm', cat: 'software', group: 'software', fa: 'fa-solid fa-users-gear', n: 'CRM', d: 'Müştəri, satış', b: 2500 },
    { id: 'custom_app', cat: 'software', group: 'software', fa: 'fa-solid fa-code', n: 'Xüsusi Proqram', d: 'PHP, Python, API', b: 2000 },
    { id: 'api_backend', cat: 'software', group: 'software', fa: 'fa-solid fa-plug', n: 'API / Backend', d: 'REST, inteqrasiya', b: 1500 },

    { id: 'desktop_app', cat: 'desktop', group: 'desktop', fa: 'fa-solid fa-desktop', n: 'Desktop Proqram', d: 'C++, Windows', b: 3500 },
    { id: 'desktop_tool', cat: 'desktop', group: 'desktop', fa: 'fa-solid fa-window-maximize', n: 'Desktop Alət', d: 'Kiçik utilit', b: 1200 },

    { id: 'server_setup', cat: 'infra', group: 'infra', fa: 'fa-solid fa-server', n: 'Server Quraşdırma', d: 'Linux, Nginx, SSL', b: 800 },
    { id: 'proxmox_cloud', cat: 'infra', group: 'infra', fa: 'fa-solid fa-cloud', n: 'Proxmox / VM', d: 'Virtualizasiya', b: 1500 },
    { id: 'nextcloud_setup', cat: 'infra', group: 'infra', fa: 'fa-solid fa-hard-drive', n: 'Nextcloud / NAS', d: 'Fayl buludu', b: 700 },
    { id: 'infra_full', cat: 'infra', group: 'infra', fa: 'fa-solid fa-network-wired', n: 'Tam infrastruktur', d: 'Docker, monitorinq', b: 2500 },
    { id: 'migration', cat: 'infra', group: 'infra', fa: 'fa-solid fa-right-left', n: 'Köçürmə', d: 'Köhnə sistemdən', b: 600 },
  ];

  const SCOPE_WEB_PAGES = [
    { id: 'p1', n: '1–5', extra: 0 },
    { id: 'p2', n: '6–20', extra: 150 },
    { id: 'p3', n: '21–50', extra: 350 },
    { id: 'p4', n: '50+', extra: 700 },
  ];
  const LANG_PRICE = { p1: 80, p2: 180, p3: 380, p4: 700 };
  const LANGS = [
    { id: 'az', n: 'AZ', lock: true },
    { id: 'ru', n: 'RU' },
    { id: 'en', n: 'EN' },
    { id: 'tr', n: 'TR' },
  ];

  const SCOPE_MOBILE_SIZE = [
    { id: 'm1', n: 'Kiçik', d: '5–10 ekran', extra: 0 },
    { id: 'm2', n: 'Orta', d: '11–25 ekran', extra: 450 },
    { id: 'm3', n: 'Böyük', d: '25+ ekran', extra: 950 },
  ];
  const SCOPE_MOBILE_PLATFORM = [
    { id: 'both', n: 'Android + iOS', d: 'İki mağaza', mult: 1.15, types: ['mobile_flutter'] },
    { id: 'android', n: 'Android', d: 'Play Store', mult: 1, types: ['mobile_android', 'mobile_flutter'] },
    { id: 'ios', n: 'iOS', d: 'App Store', mult: 1.05, types: ['mobile_ios', 'mobile_flutter'] },
    { id: 'one', n: 'Flutter (hər ikisi)', d: 'Tək kod bazası', mult: 1, types: ['mobile_flutter'] },
    { id: 'pwa', n: 'PWA', d: 'Brauzer + quraşdırma', mult: 1, types: ['mobile_pwa'] },
  ];

  const SCOPE_SOFT_COMPLEX = [
    { id: 's1', n: 'Sadə', d: 'Əsas CRUD', extra: 0 },
    { id: 's2', n: 'Orta', d: 'Rol, hesabat', extra: 900 },
    { id: 's3', n: 'Mürəkkəb', d: 'Çox modul, workflow', extra: 2200 },
  ];
  const SCOPE_SOFT_USERS = [
    { id: 'u1', n: 'Kiçik komanda', d: '1–10 user', extra: 0 },
    { id: 'u2', n: 'Orta', d: '11–50 user', extra: 350 },
    { id: 'u3', n: 'Böyük', d: '50+ user', extra: 800 },
  ];

  const SCOPE_INFRA = [
    { id: 'i1', n: 'Tək server', d: '1 VM / host', extra: 0 },
    { id: 'i2', n: 'Cluster', d: 'Proxmox, çox VM', extra: 600 },
    { id: 'i3', n: 'Korporativ', d: 'HA, backup, monitor', extra: 1400 },
  ];

  const SCOPE_DESK = [
    { id: 'd1', n: 'Sadə', d: '1 modul', extra: 0 },
    { id: 'd2', n: 'Orta', d: 'Bir neçə modul', extra: 800 },
    { id: 'd3', n: 'Kompleks', d: 'Driver, hardware', extra: 2000 },
  ];

  const SUGGEST = {
    ecommerce: ['cart', 'payment', 'admin', 'search', 'auth'],
    erp: ['crm_m', 'whouse', 'account', 'report', 'auth', 'api'],
    crm: ['crm_m', 'sales', 'report', 'auth', 'api'],
    admin_panel: ['admin', 'auth', 'report', 'search', 'api'],
    corporate: ['admin', 'blog_m', 'search', 'chat', 'seo_extra'],
    portal: ['blog_m', 'slider', 'search', 'admin', 'auth'],
    wordpress: ['admin', 'blog_m', 'search', 'seo_extra', 'auth'],
    dle: ['blog_m', 'slider', 'search', 'admin', 'auth', 'seo_extra'],
    mobile_flutter: ['auth', 'api', 'push', 'maps'],
    mobile_android: ['auth', 'api', 'push'],
    mobile_ios: ['auth', 'api', 'push'],
    mobile_pwa: ['auth', 'api', 'push', 'maps'],
    landing: ['slider', 'gana', 'chat'],
    blog: ['blog_m', 'admin', 'seo_extra'],
    custom_app: ['api', 'auth', 'report', 'admin'],
    desktop_tool: ['auth', 'api'],
    api_backend: ['api', 'auth', 'docker_extra'],
    proxmox_cloud: ['monitor', 'backup_infra', 'docker_extra'],
    infra_full: ['monitor', 'backup_infra', 'docker_extra', 'vpn'],
    server_setup: ['ssl_infra', 'backup_infra'],
    desktop_app: ['auth', 'api', 'report'],
  };

  const SMART = {
    '': { title: 'Başlayaq', text: 'Layihə kateqoriyasını seçin — veb, mobil, proqram və ya server.' },
    landing: { title: 'Landing', text: 'Tez hazırlanır; slider və analytics tövsiyə olunur.' },
    wordpress: { title: 'WordPress', text: 'Tema, plugin və təhlükəsizlik yeniləmələri nəzərə alın.' },
    dle: { title: 'DLE portal', text: 'Xəbər modulu, reklam zonası və admin panel tövsiyə olunur.' },
    portal: { title: 'Portal / DLE', text: 'Modul, SEO və yüksək trafik optimallaşdırması vacibdir.' },
    ecommerce: { title: 'E-ticarət', text: 'Səbət, ödəniş və admin panel satış üçün vacibdir.' },
    mobile_flutter: { title: 'Flutter', text: 'Bir kodla Android və iOS — vaxt və büdcə qənaəti.' },
    mobile_android: { title: 'Android', text: 'Kotlin native — Play Store və push bildirişlər.' },
    mobile_ios: { title: 'iOS', text: 'Swift native — App Store tələbləri nəzərə alınır.' },
    mobile_pwa: { title: 'PWA', text: 'Veb əsaslı mobil — sürətli, mağaza olmadan da işləyir.' },
    crm: { title: 'CRM', text: 'Satış pipeline və müştəri kartları əsas moduldur.' },
    erp: { title: 'ERP', text: 'Anbar, CRM və hesabat modulları ilə planlayın.' },
    admin_panel: { title: 'İdarə paneli', text: 'Rol sistemi və hesabatlar tez-tez lazım olur.' },
    server_setup: { title: 'Server', text: 'Nginx, SSL, backup — minimum təhlükəsizlik paketi.' },
    desktop_app: { title: 'Desktop', text: 'Windows/Linux müştəri proqramı — mürəkkəblikdən asılıdır.' },
  };

  const MCATS = [
    { id: 'all', n: 'Hamısı' },
    { id: 'ui', n: 'UI / Panel' },
    { id: 'shop', n: 'Ticarət' },
    { id: 'erp', n: 'ERP / CRM' },
    { id: 'mobile', n: 'Mobil' },
    { id: 'int', n: 'İnteqrasiya' },
    { id: 'infra', n: 'İnfrastruktur' },
  ];

  const MODS = [
    { id: 'admin', cat: 'ui', groups: ['web', 'software'], n: 'Admin Panel', d: 'Kontent / idarəetmə', p: 280 },
    { id: 'search', cat: 'ui', groups: ['web', 'software'], n: 'Axtarış', d: 'Smart filter', p: 120 },
    { id: 'auth', cat: 'ui', groups: ['web', 'software', 'mobile', 'desktop'], n: 'Login / Rol', d: 'İstifadəçi, icazə', p: 320 },
    { id: 'cart', cat: 'shop', groups: ['web'], n: 'Səbət', d: 'E-ticarət', p: 350 },
    { id: 'payment', cat: 'shop', groups: ['web', 'mobile'], n: 'Ödəniş', d: 'Bank, kart, E-manat', p: 420 },
    { id: 'crm_m', cat: 'erp', groups: ['software'], n: 'CRM Modulu', d: 'Lead, pipeline', p: 750 },
    { id: 'whouse', cat: 'erp', groups: ['software'], n: 'Anbar', d: 'Stok, inventar', p: 650 },
    { id: 'account', cat: 'erp', groups: ['software'], n: 'Mühasibat', d: 'Gəlir / xərc', p: 700 },
    { id: 'sales', cat: 'erp', groups: ['software'], n: 'Satış', d: 'Sifariş, müqavilə', p: 550 },
    { id: 'report', cat: 'erp', groups: ['software', 'desktop'], n: 'Hesabat', d: 'Dashboard, export', p: 400 },
    { id: 'blog_m', cat: 'ui', groups: ['web'], n: 'Blog / Xəbər', d: 'Kateqoriya, şərh', p: 140 },
    { id: 'slider', cat: 'ui', groups: ['web'], n: 'Slider', d: 'Banner', p: 80 },
    { id: 'chat', cat: 'int', groups: ['web'], n: 'Canlı dəstək', d: 'WhatsApp, chat', p: 80 },
    { id: 'api', cat: 'int', groups: ['web', 'software', 'mobile', 'desktop'], n: 'API İnteqrasiya', d: '3-cü tərəf', p: 280 },
    { id: 'push', cat: 'mobile', groups: ['mobile'], n: 'Push bildiriş', d: 'FCM / APNs', p: 350 },
    { id: 'maps', cat: 'mobile', groups: ['mobile', 'web'], n: 'Xəritə', d: 'Google Maps', p: 90 },
    { id: 'gana', cat: 'int', groups: ['web', 'mobile'], n: 'Analytics', d: 'GA4, event', p: 70 },
    { id: 'monitor', cat: 'infra', groups: ['infra'], n: 'Monitorinq', d: 'Grafana, uptime', p: 450 },
    { id: 'backup_infra', cat: 'infra', groups: ['infra', 'web'], n: 'Backup', d: 'Avtomatik yedək', p: 200 },
    { id: 'docker_extra', cat: 'infra', groups: ['infra', 'software'], n: 'Docker', d: 'Konteyner', p: 380 },
    { id: 'vpn', cat: 'infra', groups: ['infra'], n: 'VPN / WireGuard', d: 'Uzaq giriş', p: 250 },
    { id: 'ssl_infra', cat: 'infra', groups: ['infra', 'web'], n: 'SSL / WAF', d: 'HTTPS, təhlükəsizlik', p: 120 },
    { id: 'twofa', cat: 'ui', groups: ['software', 'web'], n: '2FA', d: 'SMS / TOTP', p: 180 },
    { id: 'invoice', cat: 'shop', groups: ['web', 'software'], n: 'Faktura PDF', d: 'Hesab-faktura', p: 200 },
  ];

  const TIERS = [
    { id: 'std', n: 'Standart UI', mult: 1 },
    { id: 'pro', n: 'Xüsusi dizayn (+30%)', mult: 1.3 },
    { id: 'prem', n: 'Premium UX (+60%)', mult: 1.6 },
  ];
  const TIERS_MOBILE = [
    { id: 'std', n: 'Standart mobil UI', mult: 1 },
    { id: 'pro', n: 'Xüsusi dizayn (+35%)', mult: 1.35 },
    { id: 'prem', n: 'Premium animasiya (+65%)', mult: 1.65 },
  ];
  const TIERS_SOFTWARE = [
    { id: 'std', n: 'Standart panel', mult: 1 },
    { id: 'pro', n: 'Xüsusi dashboard (+30%)', mult: 1.3 },
    { id: 'prem', n: 'Korporativ UX (+55%)', mult: 1.55 },
  ];
  const TIERS_INFRA = [
    { id: 'std', n: 'Standart quruluş', mult: 1 },
    { id: 'pro', n: 'HA + sənədləşmə (+25%)', mult: 1.25 },
    { id: 'prem', n: 'Tam outsource (+50%)', mult: 1.5 },
  ];
  const DEADLINES = [
    { id: 'std', n: '30–45 gün', mult: 1 },
    { id: 'fast', n: '15–30 gün (+18%)', mult: 1.18 },
    { id: 'urgent', n: '7–15 gün (+40%)', mult: 1.4 },
  ];
  const DEADLINES_MOBILE = [
    { id: 'std', n: '45–60 gün', mult: 1 },
    { id: 'fast', n: '30–45 gün (+15%)', mult: 1.15 },
    { id: 'urgent', n: '20–30 gün (+35%)', mult: 1.35 },
  ];
  const DEADLINES_SOFTWARE = [
    { id: 'std', n: '60–90 gün', mult: 1 },
    { id: 'fast', n: '45–60 gün (+12%)', mult: 1.12 },
    { id: 'urgent', n: '30–45 gün (+28%)', mult: 1.28 },
  ];
  const DEADLINES_INFRA = [
    { id: 'std', n: '3–7 gün', mult: 1 },
    { id: 'fast', n: '1–3 gün (+20%)', mult: 1.2 },
    { id: 'urgent', n: 'Təcili (+40%)', mult: 1.4 },
  ];

  const EXTRAS_ALL = [
    { id: 'seo_extra', n: 'SEO', p: 220, groups: ['web'] },
    { id: 'hosting', n: 'Hosting + domain', p: 90, groups: ['web'] },
    { id: 'logo', n: 'Logo / brend', p: 160, groups: ['web', 'mobile', 'software'] },
    { id: 'train', n: 'Təlim', p: 150, groups: ['web', 'software', 'infra'] },
    { id: 'content', n: 'Məzmun yazılması', p: 280, groups: ['web'] },
    { id: 'store_publish', n: 'App Store / Play', p: 400, groups: ['mobile'] },
    { id: 'maintain', n: '3 ay dəstək', p: 350, groups: ['web', 'mobile', 'software', 'desktop'] },
    { id: 'maintain_y', n: 'İllik dəstək', p: 1200, groups: ['software', 'infra'] },
    { id: 'migrate', n: 'Köçürmə', p: 250, groups: ['web', 'infra'] },
  ];

  let S = {
    type: null,
    typeCat: 'all',
    page: 'p1',
    mobSize: 'm1',
    mobPlatform: 'one',
    softComplex: 's1',
    softUsers: 'u1',
    infraScale: 'i1',
    deskScope: 'd1',
    langs: ['az'],
    mods: [],
    tier: 'pro',
    dead: 'std',
    extras: [],
  };
  let curStep = 0;
  let activeCat = 'all';
  let activeTypeCat = 'all';
  let prevNum = 0;
  let skipHistory = false;
  let mobileShellReady = false;
  let leadSubmitted = false;
  let leadWaUrl = '';
  const mobileMq = window.matchMedia('(max-width:960px)');

  function isMobileShell() {
    return mobileMq.matches && document.body.classList.contains('calc-app-mode');
  }

  function scrollActiveChip(container, selector) {
    if (!isMobileShell() || !container) return;
    const active = container.querySelector(selector || '.active');
    if (active) active.scrollIntoView({ inline: 'center', block: 'nearest', behavior: 'smooth' });
  }

  function stepTitle(n) {
    if (n === 0) return 'Layihə növü';
    if (n === 1) return $('scopeTitle')?.textContent || 'Layihə həcmi';
    if (n === 2) return $('modPanelTitle')?.textContent || 'Modullar';
    if (n === 3) return 'Dizayn & müddət';
    return 'Pulsuz təklif';
  }

  function bottomCtaConfig() {
    if (curStep === 4 && leadSubmitted) {
      return { label: 'WhatsApp', disabled: false, wa: true };
    }
    const map = [
      { label: 'Davam et', disabled: !S.type },
      { label: 'Modullar', disabled: false },
      { label: 'Dizayn', disabled: false },
      { label: 'Təklif al', disabled: false },
      { label: 'Göndər', disabled: false },
    ];
    return map[curStep] || map[0];
  }

  function runBottomCta() {
    if (curStep === 0) {
      if (S.type) goStep(1);
      return;
    }
    if (curStep === 4 && leadSubmitted && leadWaUrl) {
      window.open(leadWaUrl, '_blank', 'noopener');
      return;
    }
    if (curStep === 4) {
      submitForm();
      return;
    }
    goStep(curStep + 1);
  }

  function syncMobileQuote(total) {
    if (!isMobileShell()) return;
    const tier = $('budgetTier')?.textContent || '—';
    const sub = $('rpSub')?.textContent || 'Seçim gözlənilir';
    const lines = $('bdList')?.innerHTML || '';
    const totalText = $('totalD')?.textContent || '₼0';
    const complexity = $('complexityFill')?.style.width || '0%';
    const priceStr = (total ?? prevNum ?? 0).toLocaleString();
    if ($('calcBottomTier')) $('calcBottomTier').textContent = tier;
    if ($('calcBottomPrice')) $('calcBottomPrice').textContent = priceStr;
    if ($('calcStepSubtitle')) $('calcStepSubtitle').textContent = $('smartTitle')?.textContent || sub;
    if ($('calcSheetTier')) $('calcSheetTier').textContent = tier;
    if ($('calcSheetPrice')) $('calcSheetPrice').textContent = priceStr;
    if ($('calcSheetSub')) $('calcSheetSub').textContent = sub;
    if ($('calcSheetLines')) $('calcSheetLines').innerHTML = lines;
    if ($('calcSheetTotal')) $('calcSheetTotal').textContent = totalText;
    if ($('calcSheetComplexity')) $('calcSheetComplexity').style.width = complexity;
  }

  function updateMobileShell() {
    if (!isMobileShell()) return;
    if ($('calcStepTitle')) $('calcStepTitle').textContent = stepTitle(curStep);
    if ($('calcStepSubtitle')) {
      $('calcStepSubtitle').textContent =
        curStep === 0
          ? $('smartText')?.textContent || 'Layihə növünü seçin'
          : $('smartTitle')?.textContent || $('rpSub')?.textContent || '';
    }
    const back = $('calcAppBack');
    if (back) back.classList.toggle('is-visible', curStep > 0);
    document.querySelectorAll('.calc-progress-seg').forEach((seg) => {
      const i = parseInt(seg.dataset.i, 10);
      seg.classList.toggle('active', i === curStep);
      seg.classList.toggle('done', i < curStep);
    });
    const cta = bottomCtaConfig();
    const btn = $('calcBottomCta');
    if (btn) {
      btn.textContent = cta.label;
      btn.disabled = !!cta.disabled;
    }
    syncMobileQuote(window._calcTotal ?? prevNum);
  }

  function openQuoteSheet() {
    if (!isMobileShell()) return;
    syncMobileQuote(window._calcTotal ?? prevNum);
    $('calcQuoteSheet')?.classList.add('is-open');
    const bd = $('calcSheetBackdrop');
    if (bd) {
      bd.hidden = false;
      bd.classList.add('is-open');
    }
    $('calcQuoteSheet')?.setAttribute('aria-hidden', 'false');
    document.body.classList.add('calc-sheet-open');
  }

  function closeQuoteSheet() {
    $('calcQuoteSheet')?.classList.remove('is-open');
    const bd = $('calcSheetBackdrop');
    if (bd) {
      bd.classList.remove('is-open');
      bd.hidden = true;
    }
    $('calcQuoteSheet')?.setAttribute('aria-hidden', 'true');
    document.body.classList.remove('calc-sheet-open');
  }

  function pushStepHistory(n) {
    if (!isMobileShell() || skipHistory) return;
    history.pushState({ calcStep: n }, '', location.pathname + '#step-' + n);
  }

  function initMobileShell() {
    if (mobileShellReady) return;
    mobileShellReady = true;
    $('calcAppBack')?.addEventListener('click', () => curStep > 0 && goStep(curStep - 1));
    $('calcBottomCta')?.addEventListener('click', runBottomCta);
    $('calcBottomPriceBtn')?.addEventListener('click', openQuoteSheet);
    $('calcSheetClose')?.addEventListener('click', closeQuoteSheet);
    $('calcSheetBackdrop')?.addEventListener('click', closeQuoteSheet);
    $('calcSheetOffer')?.addEventListener('click', () => {
      closeQuoteSheet();
      goStep(4);
    });
    $('calcSheetReset')?.addEventListener('click', () => {
      closeQuoteSheet();
      resetAll();
    });
    window.addEventListener('popstate', (e) => {
      if (!isMobileShell()) return;
      const n = e.state?.calcStep;
      if (typeof n === 'number' && n >= 0 && n <= 4 && canGoToStep(n)) {
        skipHistory = true;
        goStep(n, { fromHistory: true });
        skipHistory = false;
      }
    });
    mobileMq.addEventListener('change', () => {
      if (isMobileShell()) updateMobileShell();
      else closeQuoteSheet();
    });
    if (isMobileShell()) {
      history.replaceState({ calcStep: curStep }, '', location.pathname + '#step-' + curStep);
    }
  }

  function $(id) {
    return document.getElementById(id);
  }

  function getType() {
    return TYPES.find((t) => t.id === S.type);
  }

  function getGroup() {
    return getType()?.group || 'web';
  }

  function getTiers() {
    const g = getGroup();
    if (g === 'infra') return TIERS_INFRA;
    if (g === 'mobile') return TIERS_MOBILE;
    if (g === 'software') return TIERS_SOFTWARE;
    return TIERS;
  }

  function getDeadlines() {
    const g = getGroup();
    if (g === 'infra') return DEADLINES_INFRA;
    if (g === 'mobile') return DEADLINES_MOBILE;
    if (g === 'software') return DEADLINES_SOFTWARE;
    return DEADLINES;
  }

  function getPlatformOptions() {
    const ty = getType();
    if (!ty || ty.group !== 'mobile') return [];
    if (ty.id === 'mobile_pwa') {
      return SCOPE_MOBILE_PLATFORM.filter((p) => p.id === 'pwa');
    }
    if (ty.id === 'mobile_android') {
      return SCOPE_MOBILE_PLATFORM.filter((p) => p.id === 'android');
    }
    if (ty.id === 'mobile_ios') {
      return SCOPE_MOBILE_PLATFORM.filter((p) => p.id === 'ios');
    }
    if (ty.id === 'mobile_flutter') {
      return SCOPE_MOBILE_PLATFORM.filter((p) => ['one', 'both', 'android', 'ios'].includes(p.id));
    }
    return SCOPE_MOBILE_PLATFORM.filter((p) => !p.types || p.types.includes(ty.id));
  }

  function defaultModCat() {
    const ty = getType();
    if (!ty) return 'all';
    if (ty.group === 'mobile') return 'mobile';
    if (ty.group === 'infra') return 'infra';
    if (ty.id === 'ecommerce') return 'shop';
    if (ty.group === 'software') return ty.id === 'erp' || ty.id === 'crm' ? 'erp' : 'ui';
    if (ty.group === 'desktop') return 'ui';
    return 'all';
  }

  function resetScopeForType(typeId) {
    const ty = TYPES.find((t) => t.id === typeId);
    if (!ty) return;
    if (ty.group === 'mobile') {
      if (typeId === 'mobile_android') S.mobPlatform = 'android';
      else if (typeId === 'mobile_ios') S.mobPlatform = 'ios';
      else if (typeId === 'mobile_pwa') S.mobPlatform = 'pwa';
      else if (typeId === 'mobile_flutter') S.mobPlatform = 'one';
      else S.mobPlatform = 'one';
      S.mobSize = 'm1';
    }
    if (ty.group === 'software') {
      S.softComplex = typeId === 'erp' ? 's3' : typeId === 'api_backend' ? 's1' : 's2';
      S.softUsers = typeId === 'erp' ? 'u3' : 'u2';
    }
    if (ty.group === 'infra') {
      S.infraScale = typeId === 'infra_full' ? 'i3' : typeId === 'proxmox_cloud' ? 'i2' : 'i1';
    }
    if (ty.group === 'desktop') {
      S.deskScope = typeId === 'desktop_app' ? 'd2' : 'd1';
    }
    if (ty.group === 'web') {
      S.page = typeId === 'landing' ? 'p1' : typeId === 'portal' || typeId === 'ecommerce' ? 'p3' : 'p2';
      S.langs = ['az'];
    }
  }

  function stepperLabels() {
    const g = getGroup();
    const map = {
      web: ['Həcm', 'Modul', 'Dizayn'],
      mobile: ['App həcmi', 'Funksiya', 'UI / UX'],
      software: ['Sistem', 'Modul', 'Panel UI'],
      infra: ['Miqyas', 'Xidmət', 'Səviyyə'],
      desktop: ['Həcm', 'Modul', 'Dizayn'],
    };
    return map[g] || map.web;
  }

  function canGoToStep(n) {
    if (n === 0) return true;
    if (!S.type) return false;
    return n <= 4;
  }

  function updateSmart() {
    const key = S.type || '';
    const m = SMART[key] || SMART[''];
    if ($('smartTitle')) $('smartTitle').textContent = m.title;
    if ($('smartText')) $('smartText').textContent = m.text;
  }

  function updateScopeUI() {
    const g = getGroup();
    const ty = getType();
    const titles = {
      web: ['Səhifə və dil', 'Veb sayt həcmi və dillər.'],
      mobile: ['Mobil tətbiq həcmi', ty ? `${ty.n} — ekran və platforma seçin.` : 'Ekran sayı və platforma.'],
      software: ['Proqram / panel', 'Sistem mürəkkəbliyi və istifadəçi sayı.'],
      infra: ['İnfrastruktur', 'Server, VM, Proxmox, Nextcloud miqyası.'],
      desktop: ['Desktop proqram', 'Modul sayı və mürəkkəblik.'],
    };
    const [title, hint] = titles[g] || titles.web;
    if ($('scopeTitle')) $('scopeTitle').textContent = title;
    if ($('scopeHint')) $('scopeHint').textContent = hint;

    const lbls = stepperLabels();
    if ($('stepLbl1')) $('stepLbl1').textContent = lbls[0];
    if ($('stepLbl2')) $('stepLbl2').textContent = lbls[1];
    if ($('stepLbl3')) $('stepLbl3').textContent = lbls[2];
    if ($('modPanelTitle')) {
      $('modPanelTitle').textContent =
        g === 'mobile' ? 'Mobil funksiyalar' : g === 'infra' ? 'İnfrastruktur xidmətləri' : g === 'software' ? 'Sistem modulları' : 'Modullar & funksiyalar';
    }
    if ($('modPanelHint')) {
      $('modPanelHint').textContent =
        g === 'mobile'
          ? 'Push, ödəniş, xəritə — yalnız mobil layihəyə uyğun seçimlər.'
          : g === 'software'
            ? 'CRM, anbar, hesabat — proqrama uyğun modullar.'
            : 'Seçilmiş layihə növünə uyğun modullar göstərilir.';
    }

    ['scopeWeb', 'scopeMobile', 'scopeSoftware', 'scopeInfra', 'scopeDesktop'].forEach((id) => {
      const el = $(id);
      if (el) el.hidden = true;
    });
    const map = { web: 'scopeWeb', mobile: 'scopeMobile', software: 'scopeSoftware', infra: 'scopeInfra', desktop: 'scopeDesktop' };
    const panel = $(map[g]);
    if (panel) panel.hidden = false;

    const platWrap = $('mobPlatformWrap');
    const platOpts = getPlatformOptions();
    if (platWrap) {
      platWrap.hidden = g !== 'mobile' || platOpts.length <= 1;
    }
    if (g === 'mobile' && platOpts.length === 1) {
      S.mobPlatform = platOpts[0].id;
    }
  }

  function scopeExtra() {
    const g = getGroup();
    if (g === 'web') {
      const pe = SCOPE_WEB_PAGES.find((p) => p.id === S.page)?.extra || 0;
      const lc = LANG_PRICE[S.page] || 80;
      const el = (S.langs.length - 1) * lc;
      return { extra: pe + el, label: pe ? `Səhifə həcmi +₼${pe}` : null, lang: el };
    }
    if (g === 'mobile') {
      const se = SCOPE_MOBILE_SIZE.find((x) => x.id === S.mobSize)?.extra || 0;
      const platOpts = getPlatformOptions();
      const pm = platOpts.find((x) => x.id === S.mobPlatform)?.mult || 1;
      return { extra: se, platformMult: pm, label: se ? `Ekran +₼${se}` : null };
    }
    if (g === 'software') {
      const ce = SCOPE_SOFT_COMPLEX.find((x) => x.id === S.softComplex)?.extra || 0;
      const ue = SCOPE_SOFT_USERS.find((x) => x.id === S.softUsers)?.extra || 0;
      return { extra: ce + ue, label: `Mürəkkəblik +₼${ce + ue}` };
    }
    if (g === 'infra') {
      const ie = SCOPE_INFRA.find((x) => x.id === S.infraScale)?.extra || 0;
      return { extra: ie, platformMult: 1, label: ie ? `Miqyas +₼${ie}` : null };
    }
    if (g === 'desktop') {
      const de = SCOPE_DESK.find((x) => x.id === S.deskScope)?.extra || 0;
      return { extra: de, platformMult: 1, label: de ? `Həcm +₼${de}` : null };
    }
    return { extra: 0, platformMult: 1 };
  }

  function filteredTypes() {
    if (activeTypeCat === 'all') return TYPES;
    return TYPES.filter((t) => t.cat === activeTypeCat);
  }

  function filteredMods() {
    const g = getGroup();
    let list = MODS.filter((m) => !m.groups || m.groups.includes(g));
    if (activeCat !== 'all') list = list.filter((m) => m.cat === activeCat);
    return list;
  }

  function filteredExtras() {
    const g = getGroup();
    return EXTRAS_ALL.filter((e) => e.groups.includes(g));
  }

  function bindGrid(containerId, items, stateKey, onChange) {
    const g = $(containerId);
    if (!g) return;
    g.innerHTML = items
      .map(
        (item) =>
          `<div class="pi ${S[stateKey] === item.id ? 'active' : ''}" data-id="${item.id}" data-key="${stateKey}"><div class="pi-n">${item.n}</div>${item.d ? `<div class="pi-l">${item.d}</div>` : ''}</div>`
      )
      .join('');
    g.querySelectorAll('.pi').forEach((el) => {
      el.addEventListener('click', () => {
        S[el.dataset.key] = el.dataset.id;
        onChange ? onChange() : renderScopeGrids();
        calc();
      });
    });
  }

  function renderTypeCats() {
    const g = $('typeCatTabs');
    if (!g) return;
    g.innerHTML = TYPE_CATS.map(
      (c) =>
        `<button type="button" class="type-cat-tab ${activeTypeCat === c.id ? 'active' : ''}" data-cat="${c.id}">${c.n}</button>`
    ).join('');
    g.querySelectorAll('.type-cat-tab').forEach((el) => {
      el.addEventListener('click', () => {
        activeTypeCat = el.dataset.cat;
        renderTypeCats();
        Rt();
      });
    });
    scrollActiveChip(g, '.type-cat-tab.active');
  }

  function Rt() {
    const g = $('typeGrid');
    if (!g) return;
    const list = filteredTypes();
    g.innerHTML = list
      .map(
        (t) =>
          `<div class="tc ${S.type === t.id ? 'active' : ''}" data-id="${t.id}"><i class="${t.fa}" style="font-size:1.35rem;margin-bottom:8px;color:var(--accent)"></i><div class="tc-name">${t.n}</div><div class="tc-desc">${t.d}</div><div class="tc-price">₼${t.b}+</div></div>`
      )
      .join('');
    g.querySelectorAll('.tc').forEach((el) => {
      el.addEventListener('click', () => {
        S.type = el.dataset.id;
        S.mods = [];
        const ty = getType();
        if (ty) activeTypeCat = ty.cat;
        resetScopeForType(S.type);
        activeCat = defaultModCat();
        Rt();
        updateScopeUI();
        updateStepper();
        renderScopeGrids();
        Rmc();
        Rm();
        Re();
        Rti();
        Rd();
        calc();
        const btn = $('btnStep0');
        if (btn) btn.disabled = false;
        if (isMobileShell() && curStep === 0) {
          setTimeout(() => {
            if (S.type && curStep === 0) goStep(1);
          }, 400);
        }
      });
    });
  }

  function bindGridCustom(containerId, items, stateKey, onChange) {
    const g = $(containerId);
    if (!g) return;
    if (!items.length) {
      g.innerHTML = '';
      return;
    }
    g.innerHTML = items
      .map(
        (item) =>
          `<div class="pi ${S[stateKey] === item.id ? 'active' : ''}" data-id="${item.id}" data-key="${stateKey}"><div class="pi-n">${item.n}</div>${item.d ? `<div class="pi-l">${item.d}</div>` : ''}</div>`
      )
      .join('');
    g.querySelectorAll('.pi').forEach((el) => {
      el.addEventListener('click', () => {
        S[el.dataset.key] = el.dataset.id;
        onChange ? onChange() : renderScopeGrids();
        calc();
      });
    });
  }

  function renderScopeGrids() {
    bindGrid('pgrGrid', SCOPE_WEB_PAGES, 'page', renderScopeGrids);
    bindGrid('mobScopeGrid', SCOPE_MOBILE_SIZE, 'mobSize', renderScopeGrids);
    bindGridCustom('mobPlatformGrid', getPlatformOptions(), 'mobPlatform', renderScopeGrids);
    bindGrid('softScopeGrid', SCOPE_SOFT_COMPLEX, 'softComplex', renderScopeGrids);
    bindGrid('softUsersGrid', SCOPE_SOFT_USERS, 'softUsers', renderScopeGrids);
    bindGrid('infraScopeGrid', SCOPE_INFRA, 'infraScale', renderScopeGrids);
    bindGrid('deskScopeGrid', SCOPE_DESK, 'deskScope', renderScopeGrids);
    Rl();
  }

  function Rl() {
    if (getGroup() !== 'web') return;
    const c = LANG_PRICE[S.page] || 80;
    const g = $('langRow');
    if (!g) return;
    g.innerHTML = LANGS.map(
      (l) =>
        `<button type="button" class="lang-btn ${S.langs.includes(l.id) ? 'active' : ''}" data-id="${l.id}" ${l.lock ? 'disabled' : ''}>${l.n}${!l.lock ? ` +₼${c}` : ''}</button>`
    ).join('');
    g.querySelectorAll('.lang-btn:not([disabled])').forEach((el) => {
      el.addEventListener('click', () => {
        const id = el.dataset.id;
        S.langs = S.langs.includes(id) ? S.langs.filter((x) => x !== id) : [...S.langs, id];
        if (!S.langs.length) S.langs = ['az'];
        Rl();
        calc();
      });
    });
  }

  function Rmc() {
    const g = $('mfRow');
    if (!g) return;
    const visibleCats = MCATS.filter((c) => {
      if (c.id === 'all') return true;
      if (c.id === 'infra' && getGroup() === 'infra') return true;
      return MODS.some((m) => m.cat === c.id && (!m.groups || m.groups.includes(getGroup())));
    });
    g.innerHTML = visibleCats
      .map((c) => `<button type="button" class="mf-tab ${activeCat === c.id ? 'active' : ''}" data-cat="${c.id}">${c.n}</button>`)
      .join('');
    g.querySelectorAll('.mf-tab').forEach((el) => {
      el.addEventListener('click', () => {
        activeCat = el.dataset.cat;
        Rmc();
        Rm();
      });
    });
    scrollActiveChip(g, '.mf-tab.active');
  }

  function Rm() {
    const g = $('modList');
    if (!g) return;
    const list = filteredMods();
    if (!list.length) {
      g.innerHTML = '<p class="panel-hint">Bu filtr üçün uyğun modul yoxdur — «Hamısı» seçin.</p>';
      return;
    }
    g.innerHTML = list
      .map(
        (m) =>
          `<div class="mr ${S.mods.includes(m.id) ? 'active' : ''}" data-id="${m.id}"><div><div class="tc-name">${m.n}</div><div class="tc-desc">${m.d}</div></div><span class="mr-price">+₼${m.p}</span></div>`
      )
      .join('');
    g.querySelectorAll('.mr').forEach((el) => {
      el.addEventListener('click', () => {
        const id = el.dataset.id;
        S.mods = S.mods.includes(id) ? S.mods.filter((x) => x !== id) : [...S.mods, id];
        Rm();
        calc();
      });
    });
  }

  function Rti() {
    const tiers = getTiers();
    const g = getGroup();
    const tierGrid = $('tierGrid');
    if (!tierGrid) return;
    if ($('tierHint')) {
      const hints = {
        infra: 'Quruluş səviyyəsi və sənədləşmə.',
        mobile: 'Mobil interfeys və animasiya keyfiyyəti.',
        software: 'Admin panel və dashboard dizaynı.',
        desktop: 'Desktop UI keyfiyyəti.',
        web: 'UI/UX və vizual keyfiyyət.',
      };
      $('tierHint').textContent = hints[g] || hints.web;
    }
    tierGrid.innerHTML = tiers.map((t) => `<div class="ti ${S.tier === t.id ? 'active' : ''}" data-id="${t.id}">${t.n}</div>`).join('');
    tierGrid.querySelectorAll('.ti').forEach((el) => {
      el.addEventListener('click', () => {
        S.tier = el.dataset.id;
        Rti();
        calc();
      });
    });
  }

  function Rd() {
    const dls = getDeadlines();
    const g = $('dlGrid');
    if (!g) return;
    g.innerHTML = dls.map((d) => `<div class="dl ${S.dead === d.id ? 'active' : ''}" data-id="${d.id}">${d.n}</div>`).join('');
    g.querySelectorAll('.dl').forEach((el) => {
      el.addEventListener('click', () => {
        S.dead = el.dataset.id;
        Rd();
        calc();
      });
    });
  }

  function Re() {
    const g = $('extrasGrid');
    if (!g) return;
    const list = filteredExtras();
    g.innerHTML = list
      .map((e) => `<div class="ex ${S.extras.includes(e.id) ? 'active' : ''}" data-id="${e.id}"><span>${e.n}</span><span>+₼${e.p}</span></div>`)
      .join('');
    g.querySelectorAll('.ex').forEach((el) => {
      el.addEventListener('click', () => {
        const id = el.dataset.id;
        S.extras = S.extras.includes(id) ? S.extras.filter((x) => x !== id) : [...S.extras, id];
        Re();
        calc();
      });
    });
  }

  function applySuggest() {
    if (!S.type || !SUGGEST[S.type]) return;
    SUGGEST[S.type].forEach((id) => {
      if (!S.mods.includes(id) && MODS.find((m) => m.id === id)) S.mods.push(id);
    });
    Rm();
    calc();
  }

  function scopeSummary() {
    const g = getGroup();
    const ty = getType();
    if (!ty) return '';
    if (g === 'web') {
      const pg = SCOPE_WEB_PAGES.find((p) => p.id === S.page);
      return `${ty.n} · ${pg?.n || ''} səhifə · ${S.langs.join(',').toUpperCase()}`;
    }
    if (g === 'mobile') {
      const ms = SCOPE_MOBILE_SIZE.find((x) => x.id === S.mobSize);
      const mp = getPlatformOptions().find((x) => x.id === S.mobPlatform);
      return `${ty.n} · ${ms?.n}${mp ? ' · ' + mp.n : ''}`;
    }
    if (g === 'software') {
      const sc = SCOPE_SOFT_COMPLEX.find((x) => x.id === S.softComplex);
      return `${ty.n} · ${sc?.n}`;
    }
    if (g === 'infra') return `${ty.n} · ${SCOPE_INFRA.find((x) => x.id === S.infraScale)?.n || ''}`;
    if (g === 'desktop') return `${ty.n} · ${SCOPE_DESK.find((x) => x.id === S.deskScope)?.n || ''}`;
    return ty.n;
  }

  function complexityScore(total, modCount) {
    let s = 10;
    const g = getGroup();
    if (S.type === 'erp') s += 30;
    if (g === 'mobile') s += 25;
    if (g === 'software') s += 20;
    if (g === 'infra') s += 15;
    if (modCount > 5) s += 15;
    if (total > 8000) s += 20;
    if (S.tier === 'prem') s += 10;
    return Math.min(100, s);
  }

  function budgetLabel(total) {
    if (total < 1000) return 'Kiçik layihə';
    if (total < 3500) return 'Orta büdcə';
    if (total < 8000) return 'Korporativ';
    return 'Enterprise';
  }

  function calc() {
    const ty = getType();
    const g = getGroup();
    const tiers = getTiers();
    const dls = getDeadlines();
    const ti = tiers.find((t) => t.id === S.tier) || tiers[1];
    const dl = dls.find((d) => d.id === S.dead) || dls[0];
    const sc = scopeExtra();
    const base = ty ? ty.b : 0;
    const ms = S.mods.reduce((a, id) => a + (MODS.find((x) => x.id === id)?.p || 0), 0);
    const ex = S.extras.reduce((a, id) => a + (EXTRAS_ALL.find((x) => x.id === id)?.p || 0), 0);
    const sub = (base + sc.extra + ms) * (sc.platformMult || 1);
    const total = Math.round(sub * ti.mult * dl.mult + ex);

    const rows = [];
    if (ty) rows.push({ l: ty.n, v: '₼' + ty.b });
    if (sc.extra) rows.push({ l: 'Həcm / parametr', v: '+₼' + sc.extra });
    if (sc.platformMult && sc.platformMult !== 1) rows.push({ l: 'Platforma', v: '×' + sc.platformMult.toFixed(2) });
    if (ms) rows.push({ l: `Modullar (${S.mods.length})`, v: '+₼' + ms });
    if (ex) rows.push({ l: 'Əlavə xidmətlər', v: '+₼' + ex });

    const bd = $('bdList');
    if (bd) bd.innerHTML = rows.length ? rows.map((r) => `<li><span>${r.l}</span><span>${r.v}</span></li>`).join('') : '<li><span>Seçim edin</span></li>';
    if ($('totalD')) $('totalD').textContent = '₼' + total.toLocaleString();
    if ($('rpSub')) $('rpSub').textContent = scopeSummary() || 'Seçim gözlənilir';
    if ($('budgetTier')) $('budgetTier').textContent = ty ? budgetLabel(total) : '—';
    if ($('complexityFill')) $('complexityFill').style.width = complexityScore(total, S.mods.length) + '%';

    animN(total);
    updateSmart();
    window._calcTotal = total;
    syncMobileQuote(total);
    updateMobileShell();
  }

  function animN(target) {
    const e1 = $('rpN');
    const start = prevNum;
    const t0 = performance.now();
    function f(now) {
      const p = Math.min((now - t0) / 400, 1);
      const v = Math.round(start + (target - start) * (1 - Math.pow(1 - p, 3)));
      if (e1) e1.textContent = v.toLocaleString();
      if ($('calcBottomPrice')) $('calcBottomPrice').textContent = v.toLocaleString();
      if ($('calcSheetPrice')) $('calcSheetPrice').textContent = v.toLocaleString();
      if (p < 1) requestAnimationFrame(f);
      else prevNum = target;
    }
    requestAnimationFrame(f);
  }

  function refreshSummary() {
    const ty = getType();
    const m = $('mSum');
    if (m) {
      m.innerHTML = `<p><strong>${ty ? ty.n : '—'}</strong></p><p>${scopeSummary()}</p><p>Modul: ${S.mods.length}</p><p style="margin-top:8px;font-size:1.1rem;color:var(--head)">${$('totalD')?.textContent || ''}</p>`;
    }
  }

  function buildWaMessage(name, phone, ty, total, email, note) {
    let msg = `🚀 *MirTech — Qiymət sorğusu*\n👤 ${name}\n📱 ${phone}`;
    if (email) msg += `\n📧 ${email}`;
    msg += `\n📌 ${ty ? ty.n : '—'}\n📋 ${scopeSummary()}\n💰 ${total}`;
    if (note) msg += `\n📝 ${note}`;
    return msg;
  }

  function buildWaUrl(name, phone, ty, total, email, note) {
    const wa = window.MIRTECH?.whatsapp || '994707232128';
    const msg = buildWaMessage(name, phone, ty, total, email, note);
    return `https://wa.me/${wa}?text=${encodeURIComponent(msg)}`;
  }

  function resetLeadForm() {
    leadSubmitted = false;
    leadWaUrl = '';
    const success = $('leadSuccess');
    if (success) success.hidden = true;
    $('leadFormStack')?.removeAttribute('hidden');
    $('leadFormActions')?.removeAttribute('hidden');
    $('mSum')?.removeAttribute('hidden');
    document.querySelector('#sp4 .panel-hint')?.removeAttribute('hidden');
    if ($('fName')) $('fName').value = '';
    if ($('fPhone')) $('fPhone').value = '';
    if ($('fEmail')) $('fEmail').value = '';
    if ($('fNote')) $('fNote').value = '';
    const btn = $('btnSubmit');
    if (btn) {
      btn.disabled = false;
      btn.innerHTML = '<i class="fa-solid fa-paper-plane"></i> Göndər';
    }
  }

  function showLeadSuccess(name, phone, ty, total, email, note) {
    leadSubmitted = true;
    leadWaUrl = buildWaUrl(name, phone, ty, total, email, note);
    $('leadFormStack')?.setAttribute('hidden', '');
    $('leadFormActions')?.setAttribute('hidden', '');
    $('mSum')?.setAttribute('hidden', '');
    document.querySelector('#sp4 .panel-hint')?.setAttribute('hidden', '');
    const success = $('leadSuccess');
    if (success) success.hidden = false;
    const waBtn = $('leadWaBtn');
    if (waBtn) waBtn.href = leadWaUrl;
    if ($('calcStepTitle')) $('calcStepTitle').textContent = 'Sorğu göndərildi';
    if ($('calcStepSubtitle')) $('calcStepSubtitle').textContent = 'WhatsApp-dan da yaza bilərsiniz';
    updateMobileShell();
    document.querySelector('#sp4')?.scrollIntoView({ behavior: 'smooth', block: 'start' });
  }

  async function submitForm() {
    const name = $('fName')?.value.trim();
    const phone = $('fPhone')?.value.trim();
    if (!name || !phone) {
      alert('Ad və telefon daxil edin.');
      return;
    }
    if (leadSubmitted) {
      if (leadWaUrl) window.open(leadWaUrl, '_blank', 'noopener');
      return;
    }

    const ty = getType();
    const total = $('totalD')?.textContent || '';
    const email = $('fEmail')?.value.trim() || '';
    const note = $('fNote')?.value.trim() || '';
    const btn = $('btnSubmit');
    const bottomCta = $('calcBottomCta');
    const btnHtml = btn?.innerHTML;

    if (btn) {
      btn.disabled = true;
      btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Göndərilir...';
    }
    if (bottomCta) bottomCta.disabled = true;

    let ok = false;
    try {
      const res = await fetch((window.MIRTECH?.base || '') + '/api/lead.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({
          name,
          phone,
          email,
          note,
          project_type: ty ? ty.n : '',
          total,
          details: { ...S, group: getGroup(), summary: scopeSummary() },
        }),
      });
      const data = await res.json().catch(() => ({}));
      ok = res.ok && data.ok;
    } catch (e) {}

    if (btn) {
      btn.disabled = false;
      btn.innerHTML = btnHtml || '<i class="fa-solid fa-paper-plane"></i> Göndər';
    }
    if (bottomCta) bottomCta.disabled = false;

    if (ok) {
      showLeadSuccess(name, phone, ty, total, email, note);
      return;
    }

    alert('Sorğu göndərilmədi. Yenidən cəhd edin və ya WhatsApp ilə birbaşa yazın.');
    leadWaUrl = buildWaUrl(name, phone, ty, total, email, note);
    window.open(leadWaUrl, '_blank', 'noopener');
  }

  function resetAll() {
    resetLeadForm();
    S = {
      type: null,
      typeCat: 'all',
      page: 'p1',
      mobSize: 'm1',
      mobPlatform: 'one',
      softComplex: 's1',
      softUsers: 'u1',
      infraScale: 'i1',
      deskScope: 'd1',
      langs: ['az'],
      mods: [],
      tier: 'pro',
      dead: 'std',
      extras: [],
    };
    activeTypeCat = 'all';
    activeCat = 'all';
    curStep = 0;
    prevNum = 0;
    if ($('btnStep0')) $('btnStep0').disabled = true;
    renderAll();
    calc();
    goStep(0);
    updateStepper();
    closeQuoteSheet();
    if (isMobileShell()) {
      history.replaceState({ calcStep: 0 }, '', location.pathname + '#step-0');
      updateMobileShell();
    }
  }

  function updateStepper() {
    const hasType = !!S.type;
    document.querySelectorAll('.stepper-item').forEach((el) => {
      const n = parseInt(el.dataset.step, 10);
      el.classList.remove('active', 'done');
      if (n < curStep) el.classList.add('done');
      if (n === curStep) el.classList.add('active');
      el.disabled = (n > 0 && !hasType) || n > curStep;
    });
    if (hasType) {
      const lbls = stepperLabels();
      if ($('stepLbl1')) $('stepLbl1').textContent = lbls[0];
      if ($('stepLbl2')) $('stepLbl2').textContent = lbls[1];
      if ($('stepLbl3')) $('stepLbl3').textContent = lbls[2];
    }
  }

  function goStep(n, opts = {}) {
    if (!canGoToStep(n)) return;
    if (n > 0 && !S.type) {
      alert('Əvvəlcə layihə növünü seçin.');
      return;
    }
    const prev = curStep;
    const direction = n > prev ? 'forward' : 'back';
    document.querySelectorAll('.calc-panel').forEach((p) => {
      p.classList.remove('active', 'slide-back');
    });
    const panel = $('sp' + n);
    if (panel) {
      panel.classList.add('active');
      if (isMobileShell() && direction === 'back') panel.classList.add('slide-back');
    }
    curStep = n;
    if (n === 1) {
      updateScopeUI();
      renderScopeGrids();
    }
    if (n === 2) {
      Rmc();
      Rm();
    }
    if (n === 3) {
      Rti();
      Rd();
      Re();
    }
    if (n === 4) refreshSummary();
    updateStepper();
    if (!opts.fromHistory) pushStepHistory(n);
    updateMobileShell();
    closeQuoteSheet();
    scrollToCalcPanel(panel);
  }

  function scrollToCalcPanel(panel) {
    if (!panel) return;
    if (isMobileShell()) {
      const offset = 132;
      const top = panel.getBoundingClientRect().top + window.scrollY - offset;
      window.scrollTo({ top: Math.max(0, top), behavior: 'smooth' });
      return;
    }
    if (window.matchMedia('(max-width:960px)').matches) {
      const offset = 148;
      const top = panel.getBoundingClientRect().top + window.scrollY - offset;
      window.scrollTo({ top: Math.max(0, top), behavior: 'smooth' });
      return;
    }
    panel.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
  }

  function renderAll() {
    renderTypeCats();
    Rt();
    renderScopeGrids();
    Rmc();
    Rm();
    Rti();
    Rd();
    Re();
  }

  document.querySelectorAll('[data-next]').forEach((el) => {
    el.addEventListener('click', () => goStep(parseInt(el.dataset.next, 10)));
  });
  document.querySelectorAll('[data-back]').forEach((el) => {
    el.addEventListener('click', () => goStep(parseInt(el.dataset.back, 10)));
  });
  document.querySelectorAll('.stepper-item').forEach((el) => {
    el.addEventListener('click', () => {
      if (el.disabled) return;
      const n = parseInt(el.dataset.step, 10);
      goStep(n);
    });
  });
  $('btnStep0')?.addEventListener('click', () => S.type && goStep(1));
  $('btnSuggest')?.addEventListener('click', applySuggest);
  $('btnSubmit')?.addEventListener('click', submitForm);
  $('leadNewCalc')?.addEventListener('click', resetAll);

  window.goStep = goStep;
  window.resetAll = resetAll;
  window.submitForm = submitForm;

  if ($('typeGrid')) {
    initMobileShell();
    renderAll();
    updateScopeUI();
    calc();
    updateStepper();
    updateMobileShell();
    const hash = location.hash.match(/^#step-(\d)$/);
    if (hash && isMobileShell()) {
      const n = parseInt(hash[1], 10);
      if (n > 0 && canGoToStep(n)) {
        skipHistory = true;
        goStep(n, { fromHistory: true });
        skipHistory = false;
      }
    }
  }
})();
