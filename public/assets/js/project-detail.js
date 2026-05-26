(function () {
  document.querySelectorAll('[data-animate-bar]').forEach((card) => {
    const bar = card.querySelector('.chart-bar span');
    if (bar) {
      const w = bar.style.getPropertyValue('--w');
      bar.style.width = '0';
      const obs = new IntersectionObserver(
        (entries) => {
          entries.forEach((e) => {
            if (e.isIntersecting) {
              card.classList.add('is-visible');
              bar.style.width = w;
              obs.unobserve(card);
            }
          });
        },
        { threshold: 0.3 }
      );
      obs.observe(card);
    }
  });

  const ring = document.querySelector('.progress-ring');
  if (ring) {
    const p = ring.dataset.progress || '0';
    ring.style.setProperty('--p', p);
  }
})();
