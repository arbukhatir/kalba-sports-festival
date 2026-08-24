/* Progressive enhancement for the server-rendered site. No framework, no router —
   PHP renders each page; this only adds motion and the mobile menu. */
(function () {
  'use strict';
  var reduce = window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches;

  /* ---- mobile navigation ---- */
  window.toggleMobileNav = function () {
    var open = document.body.classList.toggle('mobile-nav-open');
    var b = document.getElementById('mobileMenuBtn');
    if (b) b.setAttribute('aria-expanded', open ? 'true' : 'false');
  };
  window.closeMobileNav = function () {
    document.body.classList.remove('mobile-nav-open');
    var b = document.getElementById('mobileMenuBtn');
    if (b) b.setAttribute('aria-expanded', 'false');
  };

  /* ---- nav elevation over the hero ---- */
  var tb = document.querySelector('.topbar');
  function elevate() { if (tb) tb.classList.toggle('scrolled', window.scrollY > 40); }
  elevate();
  window.addEventListener('scroll', elevate, { passive: true });

  /* ---- countdown to 6 Nov 2026 16:00 +04 ---- */
  var cd = document.getElementById('cd');
  if (cd) {
    var target = Date.UTC(2026, 10, 6, 12, 0, 0); // 16:00 +04
    var cells = { d: cd.querySelector('[data-cd="d"]'), h: cd.querySelector('[data-cd="h"]'),
                  m: cd.querySelector('[data-cd="m"]'), s: cd.querySelector('[data-cd="s"]') };
    var pad = function (n) { return (n < 10 ? '0' : '') + n; };
    var tick = function () {
      var t = target - Date.now(); if (t < 0) t = 0;
      if (cells.d) cells.d.textContent = Math.floor(t / 86400000);
      if (cells.h) cells.h.textContent = pad(Math.floor(t / 3600000) % 24);
      if (cells.m) cells.m.textContent = pad(Math.floor(t / 60000) % 60);
      if (cells.s) cells.s.textContent = pad(Math.floor(t / 1000) % 60);
    };
    tick(); setInterval(tick, 1000);
  }

  /* ---- hero background carousel ---- */
  var hero = document.querySelector('.hx-slides');
  if (hero && !reduce) {
    var slides = hero.querySelectorAll('.hx-slide'), i = 0;
    if (slides.length > 1) setInterval(function () {
      slides[i].classList.remove('on'); i = (i + 1) % slides.length; slides[i].classList.add('on');
    }, 5200);
  }

  /* ---- showcase horizontal scroll arrows ---- */
  window.scScroll = function (dir) {
    var row = document.getElementById('scRow'); if (!row) return;
    var rtl = document.documentElement.dir === 'rtl';
    row.scrollBy({ left: dir * (rtl ? -1 : 1) * Math.min(row.clientWidth * 0.8, 620),
      behavior: reduce ? 'auto' : 'smooth' });
  };

  /* ---- scroll reveal ---- */
  if (!reduce && 'IntersectionObserver' in window) {
    document.documentElement.classList.add('reveal-ready');
    var io = new IntersectionObserver(function (es) {
      es.forEach(function (en) { if (en.isIntersecting) { en.target.classList.add('is-in'); io.unobserve(en.target); } });
    }, { rootMargin: '0px 0px -8% 0px', threshold: 0.06 });
    var sel = '.stat, .def-stat, .ev-card, .ev-grid > *, .def-feat, .card, .sec-title';
    document.querySelectorAll(sel).forEach(function (el, n) { el.style.setProperty('--rvi', n % 12); io.observe(el); });
  }
})();
