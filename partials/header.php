<?php
/* Server-rendered top navigation (real page links — this is a multipage site). */
$here = basename($_SERVER['PHP_SELF']);
$NAV = [
  ['index.php',       'الرئيسية',  'Home'],
  ['champs.php',      'المنافسات', 'Sports'],
  ['agenda.php',      'الأجندة',   'Agenda'],
  ['leaderboard.php', 'النتائج',   'Results'],
  ['register.php',    'التسجيل',   'Register'],
  ['venue.php',       'الموقع',    'Venue'],
  ['contact.php',     'تواصل',     'Contact'],
];
$other = lang() === 'en' ? 'ar' : 'en';
$otherLabel = lang() === 'en' ? 'عربي' : 'English';
$toggleHref = $here . '?lang=' . $other;
?>
<body<?= !empty($HERO) ? ' class="hero-view"' : '' ?>>
<a class="skip-link" href="#app">تخطَّ إلى المحتوى</a>
<header class="topbar">
  <div class="topbar-in">
    <a class="brand" href="<?= e(url('index.php')) ?>">
      <span class="dot" aria-hidden="true"></span>
      <span id="brandName">مهرجان كلباء الرياضي 2026</span>
    </a>
    <button class="mobile-menu-btn" id="mobileMenuBtn" type="button" aria-label="القائمة" aria-expanded="false" onclick="toggleMobileNav()">
      <span></span><span></span><span></span>
    </button>
    <nav class="main" id="mainNav">
      <?php foreach ($NAV as $n): ?>
        <a href="<?= e(url($n[0])) ?>"<?= $here === $n[0] ? ' class="active"' : '' ?>><?= e(A($n[1], $n[2])) ?></a>
      <?php endforeach; ?>
      <a class="nav-login" href="<?= e(url('gate.php')) ?>"><?= e(A('تسجيل الدخول', 'Log in')) ?></a>
      <a class="lang" href="<?= e($toggleHref) ?>"><?= e($otherLabel) ?></a>
    </nav>
  </div>
</header>
<div class="mobile-nav-overlay" id="mobileNavOverlay" onclick="closeMobileNav()"></div>
<main id="app" tabindex="-1">
