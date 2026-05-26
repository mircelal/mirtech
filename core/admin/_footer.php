  </div>
</main>
<script>
(function () {
  var body = document.body;
  var toggle = document.getElementById('admMenuToggle');
  var closeBtn = document.getElementById('admSidebarClose');
  var backdrop = document.getElementById('admBackdrop');
  var sidebar = document.getElementById('admSidebar');
  if (!toggle || !backdrop || !sidebar) return;

  function setOpen(open) {
    body.classList.toggle('adm-nav-open', open);
    toggle.setAttribute('aria-expanded', open ? 'true' : 'false');
    toggle.setAttribute('aria-label', open ? 'Menyunu bağla' : 'Menyunu aç');
    backdrop.hidden = !open;
    backdrop.setAttribute('aria-hidden', open ? 'false' : 'true');
    if (open) {
      document.documentElement.style.overflow = 'hidden';
    } else {
      document.documentElement.style.overflow = '';
    }
  }

  toggle.addEventListener('click', function () {
    setOpen(!body.classList.contains('adm-nav-open'));
  });
  if (closeBtn) {
    closeBtn.addEventListener('click', function () { setOpen(false); });
  }
  backdrop.addEventListener('click', function () { setOpen(false); });
  sidebar.querySelectorAll('.adm-nav-item').forEach(function (link) {
    link.addEventListener('click', function () { setOpen(false); });
  });
  window.addEventListener('keydown', function (e) {
    if (e.key === 'Escape') setOpen(false);
  });
  window.addEventListener('resize', function () {
    if (window.innerWidth > 860) setOpen(false);
  });
})();
</script>
<script>
(function () {
  document.querySelectorAll('[data-lang-tab]').forEach(function (btn) {
    btn.addEventListener('click', function () {
      var code = btn.getAttribute('data-lang-tab');
      var scope = btn.getAttribute('data-lang-scope') || 'content';
      document.querySelectorAll('[data-lang-tab][data-lang-scope="' + scope + '"]').forEach(function (b) {
        b.classList.toggle('is-active', b === btn);
      });
      var panels = document.querySelectorAll('[data-lang-panel][data-lang-scope="' + scope + '"]');
      if (!panels.length) {
        panels = document.querySelectorAll('[data-lang-panel]:not([data-lang-scope])');
      }
      panels.forEach(function (p) {
        p.classList.toggle('is-active', p.getAttribute('data-lang-panel') === code);
      });
    });
  });

  document.querySelectorAll('[data-form-tab]').forEach(function (btn) {
    btn.addEventListener('click', function () {
      var id = btn.getAttribute('data-form-tab');
      document.querySelectorAll('[data-form-tab]').forEach(function (b) {
        b.classList.toggle('is-active', b === btn);
      });
      document.querySelectorAll('[data-form-panel]').forEach(function (p) {
        var match = p.getAttribute('data-form-panel') === id;
        p.classList.toggle('is-active', match);
        p.hidden = !match;
      });
    });
  });
})();
</script>
</body>
</html>
