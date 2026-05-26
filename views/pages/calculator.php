<?php require VIEWS_PATH . '/partials/calc-i18n-script.php'; ?>
<main class="page-main calc-page">
  <div class="wrap page-hero page-hero-compact calc-hero">
    <p class="eyebrow"><?= htmlspecialchars(t('calc.eyebrow')) ?></p>
    <h1><?= htmlspecialchars(t('calc.title')) ?></h1>
    <p class="page-lead page-lead-full"><?= htmlspecialchars(t('calc.lead')) ?></p>
    <p class="page-lead page-lead-short"><?= htmlspecialchars(t('calc.lead_short')) ?></p>
  </div>

  <div class="calc-app-bar" id="calcAppBar" aria-label="<?= htmlspecialchars(t('calc.ui.app_nav')) ?>">
    <div class="calc-app-bar-row">
      <button type="button" class="calc-app-back" id="calcAppBack" aria-label="<?= htmlspecialchars(t('calc.ui.back')) ?>"><i class="fa-solid fa-arrow-left"></i></button>
      <div class="calc-app-bar-main">
        <h2 class="calc-app-title" id="calcStepTitle"><?= htmlspecialchars(t('calc.step.0')) ?></h2>
        <p class="calc-app-subtitle" id="calcStepSubtitle"><?= htmlspecialchars(t('calc.step.0.sub')) ?></p>
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
          <strong id="smartTitle"><?= htmlspecialchars(t('calc.smart.default.title')) ?></strong>
          <p id="smartText"><?= htmlspecialchars(t('calc.ui.smart_hint')) ?></p>
        </div>
      </div>

      <div class="stepper" id="stepper" role="tablist" aria-label="<?= htmlspecialchars(t('calc.ui.stepper.aria')) ?>">
        <button type="button" class="stepper-item active" data-step="0"><span class="stepper-num">1</span><span class="stepper-label"><?= htmlspecialchars(t('calc.ui.stepper.type')) ?></span></button>
        <button type="button" class="stepper-item" data-step="1" disabled><span class="stepper-num">2</span><span class="stepper-label" id="stepLbl1"><?= htmlspecialchars(t('calc.ui.stepper.scope')) ?></span></button>
        <button type="button" class="stepper-item" data-step="2" disabled><span class="stepper-num">3</span><span class="stepper-label" id="stepLbl2"><?= htmlspecialchars(t('calc.ui.stepper.module')) ?></span></button>
        <button type="button" class="stepper-item" data-step="3" disabled><span class="stepper-num">4</span><span class="stepper-label" id="stepLbl3"><?= htmlspecialchars(t('calc.ui.stepper.design')) ?></span></button>
        <button type="button" class="stepper-item" data-step="4" disabled><span class="stepper-num">5</span><span class="stepper-label"><?= htmlspecialchars(t('calc.ui.stepper.quote')) ?></span></button>
      </div>

      <div class="calc-panel active" id="sp0">
        <h2><?= htmlspecialchars(t('calc.ui.panel0.title')) ?></h2>
        <p class="panel-hint"><?= htmlspecialchars(t('calc.ui.panel0.hint')) ?></p>
        <div class="type-cat-tabs" id="typeCatTabs"></div>
        <div class="type-grid" id="typeGrid"></div>
        <div class="panel-actions">
          <button type="button" class="btn btn-primary" id="btnStep0" disabled><?= htmlspecialchars(t('calc.cta.continue')) ?></button>
        </div>
      </div>

      <div class="calc-panel" id="sp1">
        <h2 id="scopeTitle"><?= htmlspecialchars(t('calc.step.1')) ?></h2>
        <p class="panel-hint" id="scopeHint"></p>

        <div class="scope-panel" id="scopeWeb">
          <h3 class="sub-label"><?= htmlspecialchars(t('calc.ui.scope.pages')) ?></h3>
          <div class="pgr-grid" id="pgrGrid"></div>
          <h3 class="sub-label"><?= htmlspecialchars(t('calc.ui.scope.langs')) ?></h3>
          <div class="lang-row" id="langRow"></div>
        </div>

        <div class="scope-panel" id="scopeMobile" hidden>
          <h3 class="sub-label"><?= htmlspecialchars(t('calc.ui.scope.screens')) ?></h3>
          <div class="pgr-grid pgr-grid-mob" id="mobScopeGrid"></div>
          <div id="mobPlatformWrap">
            <h3 class="sub-label"><?= htmlspecialchars(t('calc.ui.scope.platform')) ?></h3>
            <div class="pgr-grid pgr-grid-mob" id="mobPlatformGrid"></div>
          </div>
        </div>

        <div class="scope-panel" id="scopeSoftware" hidden>
          <h3 class="sub-label"><?= htmlspecialchars(t('calc.ui.scope.complexity')) ?></h3>
          <div class="pgr-grid" id="softScopeGrid"></div>
          <h3 class="sub-label"><?= htmlspecialchars(t('calc.ui.scope.users')) ?></h3>
          <div class="pgr-grid" id="softUsersGrid"></div>
        </div>

        <div class="scope-panel" id="scopeInfra" hidden>
          <h3 class="sub-label"><?= htmlspecialchars(t('calc.ui.scope.infra')) ?></h3>
          <div class="pgr-grid" id="infraScopeGrid"></div>
        </div>

        <div class="scope-panel" id="scopeDesktop" hidden>
          <h3 class="sub-label"><?= htmlspecialchars(t('calc.ui.scope.desk')) ?></h3>
          <div class="pgr-grid" id="deskScopeGrid"></div>
        </div>

        <div class="panel-actions">
          <button type="button" class="btn btn-ghost" data-back="0"><?= htmlspecialchars(t('calc.ui.back')) ?></button>
          <button type="button" class="btn btn-primary" data-next="2"><?= htmlspecialchars(t('calc.cta.modules')) ?></button>
        </div>
      </div>

      <div class="calc-panel" id="sp2">
        <h2 id="modPanelTitle"><?= htmlspecialchars(t('calc.ui.panel2.title')) ?></h2>
        <p class="panel-hint" id="modPanelHint"><?= htmlspecialchars(t('calc.ui.panel2.hint')) ?></p>
        <button type="button" class="btn btn-ghost btn-sm" id="btnSuggest" style="margin-bottom:12px"><i class="fa-solid fa-wand-magic-sparkles"></i> <?= htmlspecialchars(t('calc.ui.suggest')) ?></button>
        <div class="mf-scroll"><div class="mf-row" id="mfRow"></div></div>
        <div class="mod-list" id="modList"></div>
        <div class="panel-actions">
          <button type="button" class="btn btn-ghost" data-back="1"><?= htmlspecialchars(t('calc.ui.back')) ?></button>
          <button type="button" class="btn btn-primary" data-next="3"><?= htmlspecialchars(t('calc.cta.design')) ?></button>
        </div>
      </div>

      <div class="calc-panel" id="sp3">
        <h2><?= htmlspecialchars(t('calc.ui.panel3.title')) ?></h2>
        <p class="panel-hint" id="tierHint"><?= htmlspecialchars(t('calc.ui.panel3.tier_hint')) ?></p>
        <div class="tier-grid" id="tierGrid"></div>
        <h3 class="sub-label"><?= htmlspecialchars(t('calc.ui.panel3.deadline')) ?></h3>
        <div class="dl-grid" id="dlGrid"></div>
        <h3 class="sub-label"><?= htmlspecialchars(t('calc.ui.panel3.extras')) ?></h3>
        <div class="extras-grid" id="extrasGrid"></div>
        <div class="panel-actions">
          <button type="button" class="btn btn-ghost" data-back="2"><?= htmlspecialchars(t('calc.ui.back')) ?></button>
          <button type="button" class="btn btn-primary" data-next="4"><?= htmlspecialchars(t('calc.cta.quote')) ?></button>
        </div>
      </div>

      <div class="calc-panel" id="sp4">
        <h2><?= htmlspecialchars(t('calc.ui.panel4.title')) ?></h2>
        <p class="panel-hint"><?= htmlspecialchars(t('calc.ui.panel4.hint')) ?></p>
        <div id="mSum" class="quote-summary"></div>
        <div class="form-stack" id="leadFormStack">
          <label><?= htmlspecialchars(t('calc.ui.form.name')) ?> <input type="text" id="fName" autocomplete="name"></label>
          <label><?= htmlspecialchars(t('calc.ui.form.phone')) ?> <input type="tel" id="fPhone" autocomplete="tel"></label>
          <label><?= htmlspecialchars(t('calc.ui.form.email')) ?> <input type="email" id="fEmail" autocomplete="email"></label>
          <label><?= htmlspecialchars(t('calc.ui.form.note')) ?> <textarea id="fNote" rows="3"></textarea></label>
        </div>
        <div class="lead-success" id="leadSuccess" hidden>
          <div class="lead-success-icon" aria-hidden="true"><i class="fa-solid fa-circle-check"></i></div>
          <h3 class="lead-success-title"><?= htmlspecialchars(t('calc.success.title')) ?></h3>
          <p class="lead-success-text"><?= htmlspecialchars(t('calc.success.text')) ?></p>
          <p class="lead-success-wa"><?= htmlspecialchars(t('calc.success.wa')) ?></p>
          <a href="#" class="btn btn-primary btn-block lead-wa-btn" id="leadWaBtn" target="_blank" rel="noopener">
            <i class="fa-brands fa-whatsapp"></i> <?= htmlspecialchars(t('calc.success.wa_btn')) ?>
          </a>
          <button type="button" class="btn btn-ghost btn-block" id="leadNewCalc"><?= htmlspecialchars(t('calc.success.new')) ?></button>
        </div>
        <div class="panel-actions" id="leadFormActions">
          <button type="button" class="btn btn-ghost" data-back="3"><?= htmlspecialchars(t('calc.ui.back')) ?></button>
          <button type="button" class="btn btn-primary" id="btnSubmit"><i class="fa-solid fa-paper-plane"></i> <?= htmlspecialchars(t('calc.submit')) ?></button>
        </div>
      </div>
    </div>

    <aside class="calc-aside">
      <div class="quote-card sticky">
        <div class="quote-tier" id="budgetTier">—</div>
        <div class="quote-price"><span>₼</span><strong id="rpN">0</strong></div>
        <p class="quote-sub" id="rpSub"><?= htmlspecialchars(t('calc.ui.quote.waiting')) ?></p>
        <div class="quote-complexity">
          <span><?= htmlspecialchars(t('calc.ui.quote.complexity')) ?></span>
          <div class="complexity-bar"><div id="complexityFill"></div></div>
        </div>
        <ul class="quote-lines" id="bdList"></ul>
        <div class="quote-total"><span><?= htmlspecialchars(t('calc.ui.quote.total')) ?></span><strong id="totalD">₼0</strong></div>
        <p class="quote-note"><i class="fa-solid fa-shield-halved"></i> <?= htmlspecialchars(t('calc.ui.quote.note')) ?></p>
        <button type="button" class="btn btn-primary btn-block" onclick="goStep(4)"><?= htmlspecialchars(t('calc.ui.quote.get')) ?></button>
        <button type="button" class="btn btn-ghost btn-block" onclick="resetAll()"><?= htmlspecialchars(t('calc.ui.quote.reset')) ?></button>
      </div>
    </aside>
  </div>

  <div class="calc-bottom-bar" id="calcBottomBar">
    <button type="button" class="calc-bottom-price" id="calcBottomPriceBtn" aria-label="<?= htmlspecialchars(t('calc.ui.sheet.price_aria')) ?>">
      <span class="calc-bottom-tier" id="calcBottomTier">—</span>
      <strong class="calc-bottom-amount"><span>₼</span><span id="calcBottomPrice">0</span></strong>
    </button>
    <button type="button" class="btn btn-primary calc-bottom-cta" id="calcBottomCta"><?= htmlspecialchars(t('calc.cta.continue')) ?></button>
  </div>

  <div class="calc-sheet-backdrop" id="calcSheetBackdrop" hidden></div>
  <div class="calc-quote-sheet" id="calcQuoteSheet" aria-hidden="true" role="dialog" aria-label="<?= htmlspecialchars(t('calc.ui.sheet.price_aria')) ?>">
    <div class="calc-sheet-panel">
      <div class="calc-sheet-handle" aria-hidden="true"></div>
      <div class="calc-sheet-head">
        <h3><?= htmlspecialchars(t('calc.ui.sheet.title')) ?></h3>
        <button type="button" class="calc-sheet-close" id="calcSheetClose" aria-label="<?= htmlspecialchars(t('calc.ui.sheet.close')) ?>"><i class="fa-solid fa-xmark"></i></button>
      </div>
      <div class="quote-tier" id="calcSheetTier">—</div>
      <div class="quote-price calc-sheet-price"><span>₼</span><strong id="calcSheetPrice">0</strong></div>
      <p class="quote-sub" id="calcSheetSub"><?= htmlspecialchars(t('calc.ui.quote.waiting')) ?></p>
      <ul class="quote-lines" id="calcSheetLines"></ul>
      <div class="quote-complexity">
        <span><?= htmlspecialchars(t('calc.ui.quote.complexity')) ?></span>
        <div class="complexity-bar"><div id="calcSheetComplexity"></div></div>
      </div>
      <div class="quote-total"><span><?= htmlspecialchars(t('calc.ui.quote.total')) ?></span><strong id="calcSheetTotal">₼0</strong></div>
      <p class="quote-note"><i class="fa-solid fa-shield-halved"></i> <?= htmlspecialchars(t('calc.ui.quote.note')) ?></p>
      <button type="button" class="btn btn-primary btn-block" id="calcSheetOffer"><?= htmlspecialchars(t('calc.ui.quote.get')) ?></button>
      <button type="button" class="btn btn-ghost btn-block" id="calcSheetReset"><?= htmlspecialchars(t('calc.ui.quote.reset')) ?></button>
    </div>
  </div>
</main>
