(function () {
  const toggle = document.getElementById('navToggle');
  const closeBtn = document.getElementById('navClose');
  const drawer = document.getElementById('mobileDrawer');
  const backdrop = document.getElementById('navBackdrop');
  const icon = toggle?.querySelector('i');

  if (!toggle || !drawer || !backdrop) {
    return;
  }

  let closeTimer = null;

  function setIcon(open) {
    if (icon) {
      icon.className = open ? 'fa-solid fa-xmark' : 'fa-solid fa-bars';
    }
  }

  function openNav() {
    clearTimeout(closeTimer);
    drawer.hidden = false;
    backdrop.hidden = false;
    drawer.setAttribute('aria-hidden', 'false');
    toggle.setAttribute('aria-expanded', 'true');
    toggle.setAttribute('aria-label', 'Menyunu bağla');
    document.body.classList.add('nav-open');
    setIcon(true);
    requestAnimationFrame(() => {
      document.body.classList.add('nav-open-ready');
    });
  }

  function closeNav() {
    document.body.classList.remove('nav-open-ready');
    document.body.classList.remove('nav-open');
    toggle.setAttribute('aria-expanded', 'false');
    toggle.setAttribute('aria-label', 'Menyunu aç');
    drawer.setAttribute('aria-hidden', 'true');
    setIcon(false);
    closeTimer = setTimeout(() => {
      drawer.hidden = true;
      backdrop.hidden = true;
    }, 280);
  }

  function isOpen() {
    return document.body.classList.contains('nav-open');
  }

  toggle.addEventListener('click', () => {
    if (isOpen()) {
      closeNav();
    } else {
      openNav();
    }
  });

  closeBtn?.addEventListener('click', closeNav);
  backdrop.addEventListener('click', closeNav);

  drawer.querySelectorAll('.mobile-drawer-nav a').forEach((a) => {
    a.addEventListener('click', closeNav);
  });

  document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape' && isOpen()) {
      closeNav();
    }
  });

  window.addEventListener('resize', () => {
    if (window.innerWidth > 860 && isOpen()) {
      clearTimeout(closeTimer);
      drawer.hidden = true;
      backdrop.hidden = true;
      document.body.classList.remove('nav-open', 'nav-open-ready');
      toggle.setAttribute('aria-expanded', 'false');
      setIcon(false);
    }
  });
})();
