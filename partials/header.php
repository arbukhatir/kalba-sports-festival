<body>


<!-- 20 nav links sit ahead of the content; keyboard users need a way past them -->
<a class="skip-link" href="#app">تخطَّ إلى المحتوى</a>
<header class="topbar">
  <div class="topbar-in">
    <span class="brand" onclick="go('home')">
      <img class="brand-logo" id="brandLogo" alt="">
      <span id="brandName"></span>
    </span>

    <!-- Mobile menu button -->
    <button
      class="mobile-menu-btn"
      id="mobileMenuBtn"
      type="button"
      aria-label="فتح القائمة"
      aria-expanded="false"
      onclick="toggleMobileNav()"
    >
      <span></span>
      <span></span>
      <span></span>
    </button>
    <nav class="main" id="mainNav"></nav>
  </div>
</header>

<!-- Dark layer behind the mobile menu -->
<div
  class="mobile-nav-overlay"
  id="mobileNavOverlay"
  onclick="closeMobileNav()"
></div>

<main id="app" tabindex="-1">
