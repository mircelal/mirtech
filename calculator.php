<?php
declare(strict_types=1);
require_once __DIR__ . '/config.php';

$settings = readJson('settings.json');
$pageTitle = 'Qiymət hesabla';
$pageDescription = 'Veb, mobil, ERP, idarə paneli, proqram və server — təxmini qiymət kalkulyatoru.';
$activeNav = 'calculator';
$bodyClass = 'calc-app-mode';
$extraScripts = [asset('assets/js/calculator.js')];

require __DIR__ . '/includes/header.php';
?>

<main class="page-main calc-page">
  <div class="wrap page-hero page-hero-compact calc-hero">
    <p class="eyebrow">Ağıllı kalkulyator</p>
    <h1>Layihə qiymətinizi hesablayın</h1>
    <p class="page-lead page-lead-full">Veb sayt, mobil tətbiq, idarə paneli, ERP, desktop proqram, server & self-host — hər növ layihə üçün təxmini büdcə.</p>
    <p class="page-lead page-lead-short">Veb, mobil, ERP və server — təxmini büdcə.</p>
  </div>

  <div class="calc-app-bar" id="calcAppBar" aria-label="Kalkulyator naviqasiyası">
    <div class="calc-app-bar-row">
      <button type="button" class="calc-app-back" id="calcAppBack" aria-label="Geri"><i class="fa-solid fa-arrow-left"></i></button>
      <div class="calc-app-bar-main">
        <h2 class="calc-app-title" id="calcStepTitle">Layihə növü</h2>
        <p class="calc-app-subtitle" id="calcStepSubtitle">Layihə növünü seçin</p>
      </div>
    </div>
    <div class="calc-app-progress" id="calcProgress" aria-hidden="true">
      <span class="calc-progress-seg active" data-i="0"></span>
      <span class="calc-progress-seg" data-i="1"></span>
      <span class="calc-progress-seg" data-i="2"></span>
      <span class="calc-progress-seg" data-i="3"></span>
      <span class="calc-progress-seg" data-i="4"></span>
    </div>
  </div>

  <div class="wrap calc-layout">
    <div class="calc-main">
      <div class="smart-banner" id="smartBanner">
        <i class="fa-solid fa-lightbulb"></i>
        <div>
          <strong id="smartTitle">Başlayaq</strong>
          <p id="smartText">Layihə növünü seçin — tövsiyələr və mürəkkəblik avtomatik yenilənəcək.</p>
        </div>
      </div>

      <div class="stepper" id="stepper" role="tablist" aria-label="Kalkulyator addımları">
        <button type="button" class="stepper-item active" data-step="0"><span class="stepper-num">1</span><span class="stepper-label">Növ</span></button>
        <button type="button" class="stepper-item" data-step="1" disabled><span class="stepper-num">2</span><span class="stepper-label" id="stepLbl1">Həcm</span></button>
        <button type="button" class="stepper-item" data-step="2" disabled><span class="stepper-num">3</span><span class="stepper-label" id="stepLbl2">Modul</span></button>
        <button type="button" class="stepper-item" data-step="3" disabled><span class="stepper-num">4</span><span class="stepper-label" id="stepLbl3">Dizayn</span></button>
        <button type="button" class="stepper-item" data-step="4" disabled><span class="stepper-num">5</span><span class="stepper-label">Təklif</span></button>
      </div>

      <div class="calc-panel active" id="sp0">
        <h2>Layihə növü</h2>
        <p class="panel-hint">Veb, mobil, proqram, server — MirTech-in etdiyi bütün işlər.</p>
        <div class="type-cat-tabs" id="typeCatTabs"></div>
        <div class="type-grid" id="typeGrid"></div>
        <div class="panel-actions">
          <button type="button" class="btn btn-primary" id="btnStep0" disabled>Davam et</button>
        </div>
      </div>

      <div class="calc-panel" id="sp1">
        <h2 id="scopeTitle">Layihə həcmi</h2>
        <p class="panel-hint" id="scopeHint"></p>

        <div class="scope-panel" id="scopeWeb">
          <h3 class="sub-label">Səhifə sayı (veb)</h3>
          <div class="pgr-grid" id="pgrGrid"></div>
          <h3 class="sub-label">Sayt dilləri</h3>
          <div class="lang-row" id="langRow"></div>
        </div>

        <div class="scope-panel" id="scopeMobile" hidden>
          <h3 class="sub-label">Ekran / funksiya sayı</h3>
          <div class="pgr-grid pgr-grid-mob" id="mobScopeGrid"></div>
          <div id="mobPlatformWrap">
            <h3 class="sub-label">Platforma</h3>
            <div class="pgr-grid pgr-grid-mob" id="mobPlatformGrid"></div>
          </div>
        </div>

        <div class="scope-panel" id="scopeSoftware" hidden>
          <h3 class="sub-label">Sistem mürəkkəbliyi</h3>
          <div class="pgr-grid" id="softScopeGrid"></div>
          <h3 class="sub-label">İstifadəçi / modul həcmi</h3>
          <div class="pgr-grid" id="softUsersGrid"></div>
        </div>

        <div class="scope-panel" id="scopeInfra" hidden>
          <h3 class="sub-label">İnfrastruktur miqyası</h3>
          <div class="pgr-grid" id="infraScopeGrid"></div>
        </div>

        <div class="scope-panel" id="scopeDesktop" hidden>
          <h3 class="sub-label">Proqram tipi</h3>
          <div class="pgr-grid" id="deskScopeGrid"></div>
        </div>

        <div class="panel-actions">
          <button type="button" class="btn btn-ghost" data-back="0">Geri</button>
          <button type="button" class="btn btn-primary" data-next="2">Modullar</button>
        </div>
      </div>

      <div class="calc-panel" id="sp2">
        <h2 id="modPanelTitle">Modullar & funksiyalar</h2>
        <p class="panel-hint" id="modPanelHint">Layihə növünə uyğun modullar göstərilir.</p>
        <button type="button" class="btn btn-ghost btn-sm" id="btnSuggest" style="margin-bottom:12px"><i class="fa-solid fa-wand-magic-sparkles"></i> Ağıllı tövsiyə tətbiq et</button>
        <div class="mf-scroll"><div class="mf-row" id="mfRow"></div></div>
        <div class="mod-list" id="modList"></div>
        <div class="panel-actions">
          <button type="button" class="btn btn-ghost" data-back="1">Geri</button>
          <button type="button" class="btn btn-primary" data-next="3">Dizayn</button>
        </div>
      </div>

      <div class="calc-panel" id="sp3">
        <h2>Dizayn / UI və müddət</h2>
        <p class="panel-hint" id="tierHint">İnterfeys keyfiyyəti və hazırlıq müddəti.</p>
        <div class="tier-grid" id="tierGrid"></div>
        <h3 class="sub-label">Hazırlıq müddəti</h3>
        <div class="dl-grid" id="dlGrid"></div>
        <h3 class="sub-label">Əlavə xidmətlər</h3>
        <div class="extras-grid" id="extrasGrid"></div>
        <div class="panel-actions">
          <button type="button" class="btn btn-ghost" data-back="2">Geri</button>
          <button type="button" class="btn btn-primary" data-next="4">Təklif al</button>
        </div>
      </div>

      <div class="calc-panel" id="sp4">
        <h2>Pulsuz təklif</h2>
        <p class="panel-hint">Məlumatlarınızı daxil edin — 24 saat ərzində əlaqə saxlayırıq.</p>
        <div id="mSum" class="quote-summary"></div>
        <div class="form-stack" id="leadFormStack">
          <label>Ad Soyad <input type="text" id="fName" autocomplete="name"></label>
          <label>Telefon <input type="tel" id="fPhone" autocomplete="tel"></label>
          <label>Email <input type="email" id="fEmail" autocomplete="email"></label>
          <label>Qeyd <textarea id="fNote" rows="3"></textarea></label>
        </div>
        <div class="lead-success" id="leadSuccess" hidden>
          <div class="lead-success-icon" aria-hidden="true"><i class="fa-solid fa-circle-check"></i></div>
          <h3 class="lead-success-title">Sorğu göndərildi!</h3>
          <p class="lead-success-text">Məlumatlarınız qeydə alındı. 24 saat ərzində sizinlə əlaqə saxlayacağıq.</p>
          <p class="lead-success-wa">Tez cavab almaq istəyirsiniz? WhatsApp-dan yazın — birbaşa cavab veririk.</p>
          <a href="#" class="btn btn-primary btn-block lead-wa-btn" id="leadWaBtn" target="_blank" rel="noopener">
            <i class="fa-brands fa-whatsapp"></i> WhatsApp-dan yaz — tez cavab al
          </a>
          <button type="button" class="btn btn-ghost btn-block" id="leadNewCalc">Yeni hesablama</button>
        </div>
        <div class="panel-actions" id="leadFormActions">
          <button type="button" class="btn btn-ghost" data-back="3">Geri</button>
          <button type="button" class="btn btn-primary" id="btnSubmit"><i class="fa-solid fa-paper-plane"></i> Göndər</button>
        </div>
      </div>
    </div>

    <aside class="calc-aside">
      <div class="quote-card sticky">
        <div class="quote-tier" id="budgetTier">—</div>
        <div class="quote-price"><span>₼</span><strong id="rpN">0</strong></div>
        <p class="quote-sub" id="rpSub">Seçim gözlənilir</p>
        <div class="quote-complexity">
          <span>Mürəkkəblik</span>
          <div class="complexity-bar"><div id="complexityFill"></div></div>
        </div>
        <ul class="quote-lines" id="bdList"></ul>
        <div class="quote-total"><span>Cəmi (təxmini)</span><strong id="totalD">₼0</strong></div>
        <p class="quote-note"><i class="fa-solid fa-shield-halved"></i> Konsultasiya pulsuzdur. Yekun qiymət müqavilədə dəqiqləşir.</p>
        <button type="button" class="btn btn-primary btn-block" onclick="goStep(4)">Təklif al</button>
        <button type="button" class="btn btn-ghost btn-block" onclick="resetAll()">Sıfırla</button>
      </div>
    </aside>
  </div>

  <div class="calc-bottom-bar" id="calcBottomBar">
    <button type="button" class="calc-bottom-price" id="calcBottomPriceBtn" aria-label="Qiymət detalları">
      <span class="calc-bottom-tier" id="calcBottomTier">—</span>
      <strong class="calc-bottom-amount"><span>₼</span><span id="calcBottomPrice">0</span></strong>
    </button>
    <button type="button" class="btn btn-primary calc-bottom-cta" id="calcBottomCta">Davam et</button>
  </div>

  <div class="calc-sheet-backdrop" id="calcSheetBackdrop" hidden></div>
  <div class="calc-quote-sheet" id="calcQuoteSheet" aria-hidden="true" role="dialog" aria-label="Qiymət detalları">
    <div class="calc-sheet-panel">
      <div class="calc-sheet-handle" aria-hidden="true"></div>
      <div class="calc-sheet-head">
        <h3>Təxmini qiymət</h3>
        <button type="button" class="calc-sheet-close" id="calcSheetClose" aria-label="Bağla"><i class="fa-solid fa-xmark"></i></button>
      </div>
      <div class="quote-tier" id="calcSheetTier">—</div>
      <div class="quote-price calc-sheet-price"><span>₼</span><strong id="calcSheetPrice">0</strong></div>
      <p class="quote-sub" id="calcSheetSub">Seçim gözlənilir</p>
      <ul class="quote-lines" id="calcSheetLines"></ul>
      <div class="quote-complexity">
        <span>Mürəkkəblik</span>
        <div class="complexity-bar"><div id="calcSheetComplexity"></div></div>
      </div>
      <div class="quote-total"><span>Cəmi (təxmini)</span><strong id="calcSheetTotal">₼0</strong></div>
      <p class="quote-note"><i class="fa-solid fa-shield-halved"></i> Konsultasiya pulsuzdur. Yekun qiymət müqavilədə dəqiqləşir.</p>
      <button type="button" class="btn btn-primary btn-block" id="calcSheetOffer">Təklif al</button>
      <button type="button" class="btn btn-ghost btn-block" id="calcSheetReset">Sıfırla</button>
    </div>
  </div>
</main>

<?php require __DIR__ . '/includes/footer.php';
