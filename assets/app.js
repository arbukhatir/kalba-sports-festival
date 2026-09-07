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

  /* ---- sports showcase: auto-advancing carousel. Steps a card-width every few
     seconds and loops back to the start; any user touch, drag, wheel or arrow
     press holds it for a while so it never fights the visitor. Skipped entirely
     under reduced motion. ---- */
  var scRow = document.getElementById('scRow');
  if (scRow && !reduce) {
    var scHoldUntil = 0;
    var scHold = function () { scHoldUntil = Date.now() + 9000; };
    ['pointerdown', 'wheel', 'touchstart'].forEach(function (ev) {
      scRow.addEventListener(ev, scHold, { passive: true });
    });
    document.querySelectorAll('.sc-arrow').forEach(function (b) {
      b.addEventListener('pointerdown', scHold, { passive: true });
    });
    setInterval(function () {
      if (document.hidden || Date.now() < scHoldUntil) return;
      if (scRow.matches(':hover')) return;
      /* off-screen rows stay still (also covers the row before first scroll into view) */
      var r = scRow.getBoundingClientRect();
      if (r.bottom < 0 || r.top > window.innerHeight) return;
      var atEnd = Math.abs(scRow.scrollLeft) + scRow.clientWidth >= scRow.scrollWidth - 8;
      if (atEnd) scRow.scrollTo({ left: 0, behavior: 'smooth' });
      else window.scScroll(1);
    }, 3600);
  }

  /* ---- scroll reveal ---- */
  if (!reduce && 'IntersectionObserver' in window) {
    document.documentElement.classList.add('reveal-ready');
    var io = new IntersectionObserver(function (es) {
      es.forEach(function (en) { if (en.isIntersecting) { en.target.classList.add('is-in'); io.unobserve(en.target); } });
    }, { rootMargin: '0px 0px -8% 0px', threshold: 0.06 });
    var sel = '.stat, .def-stat, .ev-card, .ev-grid > *, .def-feat, .card, .sec-title';
    document.querySelectorAll(sel).forEach(function (el, n) { el.style.setProperty('--rvi', n % 12); io.observe(el); });
  }

  /* ---- team registration: squad roster rows ----
     The first `min` rows are rendered server-side and stay required; extra rows
     up to `max` are optional, so a team can enter with fewer than the maximum. */
  var roster = document.getElementById('pfRoster');
  var addBtn = document.getElementById('pfAdd');
  if (roster && addBtn) {
    var min = parseInt(roster.dataset.min, 10) || 1;
    var max = parseInt(roster.dataset.max, 10) || min;
    var rows = function () { return roster.querySelectorAll('.pf-player'); };
    /* A player's name, IBAN and ID share one index, and that is the only thing
       pairing them once the form is posted. The counter therefore never goes
       backwards: reusing rows().length after a middle row is removed hands two
       rows the same index, and one player's documents overwrite another's. */
    var seq = rows().length;
    var renumber = function () {
      rows().forEach(function (row, i) {
        var num = row.querySelector('.pf-num');
        var input = row.querySelector('input[type="text"]');
        if (num) num.textContent = i + 1;
        if (input) input.placeholder = roster.dataset.label + ' ' + (i + 1);
        var del = row.querySelector('.pf-del');
        /* the first `min` rows are the required core of the squad */
        if (del) del.style.visibility = rows().length > min ? 'visible' : 'hidden';
      });
      addBtn.disabled = rows().length >= max;
      addBtn.style.opacity = addBtn.disabled ? '.5' : '';
    };
    var docField = function (i, kind, label, req) {
      var id = (kind === 'iban' ? 'pi' : 'pd') + i;
      return '<label class="pf-doc" for="' + id + '"><span>' + label +
        (req ? ' <span class="req">*</span>' : ' <span class="opt">(' + roster.dataset.optional + ')</span>') +
        '</span><input type="file" id="' + id + '" name="f_player_' + kind + '[' + i + ']" accept="' +
        roster.dataset.accept + '"></label>';
    };
    addBtn.addEventListener('click', function () {
      if (rows().length >= max) return;
      var i = seq++;
      var n = rows().length + 1;
      var row = document.createElement('div');
      row.className = 'field pf-player';
      row.innerHTML = '<span class="pf-num" aria-hidden="true">' + n + '</span>' +
        '<label class="sr-only" for="pl' + i + '">' + roster.dataset.label + ' ' + n + '</label>' +
        '<input type="text" id="pl' + i + '" name="f_players[' + i + ']" maxlength="120" placeholder="' +
        roster.dataset.label + ' ' + n + '">' +
        '<button type="button" class="pf-del" aria-label="' + roster.dataset.remove + '">✕</button>' +
        '<div class="pf-docs">' + docField(i, 'iban', roster.dataset.iban, true) +
        docField(i, 'id', roster.dataset.idlbl, false) + '</div>';
      roster.appendChild(row);
      renumber();
      row.querySelector('input[type="text"]').focus();
    });
    /* Naming an extra player commits you to their payout details, which is what
       the server enforces. Asking for it here saves a round trip. */
    roster.addEventListener('input', function (e) {
      var input = e.target;
      if (input.type !== 'text' || !input.name || input.name.indexOf('f_players[') !== 0) return;
      var row = input.closest('.pf-player');
      var iban = row && row.querySelector('input[name^="f_player_iban"]');
      if (iban) iban.required = input.value.trim() !== '';
    });
    roster.addEventListener('click', function (e) {
      var del = e.target.closest('.pf-del');
      if (!del) return;
      if (rows().length <= min) return;
      del.closest('.pf-player').remove();
      renumber();
    });
    renumber();
  }

  /* ---- agenda: filters + list/calendar view ----
     Filtering happens in the page: the whole programme is already rendered, so
     narrowing it is instant and works while offline. With JS off every event
     stays visible, which is the behaviour that matters most. */
  var agFilters = document.getElementById('agFilters');
  if (agFilters) {
    var agSport = document.getElementById('agSport'),
        agDay   = document.getElementById('agDay'),
        agCat   = document.getElementById('agCat'),
        agCount = document.getElementById('agCount'),
        agEmpty = document.getElementById('agEmpty'),
        agList  = document.getElementById('agList'),
        agCal   = document.getElementById('agCal');

    function agApply() {
      var sp = agSport.value, dy = agDay.value, ct = agCat.value, shown = 0;
      agList.querySelectorAll('.sc-item').forEach(function (li) {
        var ok = (!sp || li.dataset.sport === sp) &&
                 (!dy || li.dataset.day === dy) &&
                 (!ct || li.dataset.cat === ct);
        li.hidden = !ok;
        if (ok) shown++;
      });
      /* a day with nothing left in it should not leave a lonely header */
      agList.querySelectorAll('.sc-day').forEach(function (sec) {
        var any = sec.querySelector('.sc-item:not([hidden])');
        sec.hidden = !any;
        if (any) {
          var n = sec.querySelectorAll('.sc-item:not([hidden])').length;
          var c = sec.querySelector('.sc-daycount');
          if (c) c.textContent = n + ' ' + (c.dataset.word || c.textContent.replace(/^\d+\s*/, ''));
        }
      });
      /* the calendar view filters on the same keys */
      agCal.querySelectorAll('.agc-ev').forEach(function (li) {
        li.hidden = !((!sp || li.dataset.sport === sp) && (!ct || li.dataset.cat === ct));
      });
      agCal.querySelectorAll('.agc-day').forEach(function (col) {
        col.hidden = !!(dy && col.dataset.day !== dy);
      });
      agCount.textContent = shown;
      agEmpty.hidden = shown !== 0;
    }
    [agSport, agDay, agCat].forEach(function (sel) { sel.addEventListener('change', agApply); });

    function agReset() { agSport.value = ''; agDay.value = ''; agCat.value = ''; agApply(); }
    document.getElementById('agReset').addEventListener('click', agReset);
    var emptyReset = document.getElementById('agEmptyReset');
    if (emptyReset) emptyReset.addEventListener('click', agReset);

    var bList = document.getElementById('agViewList'), bCal = document.getElementById('agViewCal');
    function agView(cal) {
      agList.hidden = cal; agCal.hidden = !cal;
      bList.classList.toggle('on', !cal); bCal.classList.toggle('on', cal);
      bList.setAttribute('aria-pressed', String(!cal)); bCal.setAttribute('aria-pressed', String(cal));
    }
    bList.addEventListener('click', function () { agView(false); });
    bCal.addEventListener('click', function () { agView(true); });
    agView(false);
  }
})();
