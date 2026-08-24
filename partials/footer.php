</main>
<footer class="footer">
  <div class="fb">★ مهرجان كلباء الرياضي 2026</div>
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
<script src="assets/app.js"></script>
</body>
</html>
