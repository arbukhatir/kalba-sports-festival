</main>
<footer class="footer">
  <img class="footer-mark" src="assets/img/logo-mark-white.png" alt="" aria-hidden="true">
  <div class="fb"><?= e(A('مهرجان كلباء الرياضي 2026', 'Kalba Sports Festival 2026')) ?></div>
  <div class="fs"><?= e(A('كلباء تستقبلكم', 'Kalba welcomes you')) ?></div>
  <div id="footNote"><?= e(A('مدينة كلباء · إمارة الشارقة · 6–13 نوفمبر 2026', 'Kalba · Sharjah · 6–13 November 2026')) ?></div>
  <nav class="foot-links" aria-label="<?= e(A('روابط', 'Links')) ?>">
    <?php
    $FOOT = [
      ['about.php', 'عن المهرجان', 'About'], ['gallery.php', 'المعرض', 'Gallery'],
      ['news.php', 'الأخبار', 'News'], ['schools.php', 'تحدي المدارس', 'Schools'],
      ['surveys.php', 'الاستبيانات', 'Surveys'], ['join.php', 'تصريح الزيارة', 'Visitor pass'],
      ['faq.php', 'الأسئلة الشائعة', 'FAQ'], ['contact.php', 'تواصل معنا', 'Contact'],
      ['terms.php', 'الشروط', 'Terms'], ['privacy.php', 'الخصوصية', 'Privacy'],
      ['map.html', 'الخريطة التفاعلية', 'Interactive map'],
    ];
    foreach ($FOOT as $f) echo '<a href="' . e(url($f[0])) . '">' . e(A($f[1], $f[2])) . '</a>';
    ?>
  </nav>
  <form class="footer-nl" method="post" action="<?= e(url('actions/subscribe.php')) ?>" style="justify-content:center;margin-top:12px">
    <input type="email" name="email" dir="ltr" required placeholder="<?= e(A('بريدك الإلكتروني — النشرة البريدية', 'Your email — newsletter')) ?>" style="max-width:240px">
    <button class="btn gold sm" type="submit"><?= e(A('اشترك', 'Subscribe')) ?></button>
  </form>
</footer>
<?php
/* Mobile bottom app bar — the five destinations a phone visitor actually uses,
   kept in the thumb zone. Register is the elevated primary action at the centre.
   Desktop never sees it (display:none above 768px). */
$bnHere = basename($_SERVER['PHP_SELF']);
$BNAV = [
  ['index.php', 'الرئيسية', 'Home',
   '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M3 10.5 12 3l9 7.5"/><path d="M5 9.5V21h14V9.5"/></svg>'],
  ['champs.php', 'الرياضات', 'Sports',
   '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M8 21h8M12 17v4M7 4h10v4a5 5 0 0 1-10 0z"/><path d="M7 6H4v1a4 4 0 0 0 3 3.9M17 6h3v1a4 4 0 0 1-3 3.9"/></svg>'],
  ['register.php', 'سجّل', 'Register',
   '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" aria-hidden="true"><path d="M12 5v14M5 12h14"/></svg>'],
  ['leaderboard.php', 'النتائج', 'Results',
   '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M4 20V10M12 20V4M20 20v-7"/></svg>'],
  ['agenda.php', 'الأجندة', 'Agenda',
   '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><rect x="3" y="5" width="18" height="16" rx="2"/><path d="M8 3v4M16 3v4M3 10h18"/></svg>'],
];
?>
<nav class="bottombar" aria-label="<?= e(A('التنقل السريع', 'Quick navigation')) ?>">
  <?php foreach ($BNAV as $n): $isCta = $n[0] === 'register.php'; ?>
    <a class="bb-item<?= $isCta ? ' bb-cta' : '' ?><?= $bnHere === $n[0] ? ' active' : '' ?>"
       href="<?= e(url($n[0])) ?>"<?= $bnHere === $n[0] ? ' aria-current="page"' : '' ?>>
      <span class="bb-ic"><?= $n[3] ?></span>
      <span class="bb-lbl"><?= e(A($n[1], $n[2])) ?></span>
    </a>
  <?php endforeach; ?>
</nav>
<script src="assets/app.js"></script>
</body>
</html>
