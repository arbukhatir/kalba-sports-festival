<?php
/* Custom not-found page. Router-agnostic: linked from .htaccess (Apache) and
   usable directly as /404.php on any host. */
require_once __DIR__ . '/lib/render.php';
http_response_code(404);
$PAGE_TITLE = A('الصفحة غير موجودة', 'Page not found');
$PAGE_DESC  = A('الصفحة المطلوبة غير موجودة في موقع مهرجان كلباء الرياضي 2026 — تصفّح الرياضات أو الأجندة أو عد للرئيسية.',
                'The page you asked for does not exist on the Kalba Sports Festival 2026 site — browse the sports, the programme, or head home.');
require __DIR__ . '/partials/head.php';
require __DIR__ . '/partials/header.php';
echo page_head('404', A('الصفحة غير موجودة', 'Page not found'),
  A('ربما تغيّر الرابط أو حُذفت الصفحة. جرّب أحد المسارات التالية.',
    'The link may have changed or the page was removed. Try one of these instead.'));
?>
<section class="container section" style="max-width:760px">
  <div class="grid g2">
    <?php foreach ([
      ['index.php',       icon('home'), 'الصفحة الرئيسية', 'Home',        'كل ما يجري في المهرجان', 'Everything happening at the festival'],
      ['champs.php',      icon('trophy'), 'الرياضات',        'Sports',      '١٣ رياضة معتمدة',        '13 official sports'],
      ['agenda.php',      icon('calendar'), 'الأجندة',         'Programme',   'جدول الأيام الثمانية',   'The eight-day schedule'],
      ['register.php',    icon('edit'), 'التسجيل',         'Register',    'شارك أو انضم كمورّد',    'Compete or join as a vendor'],
      ['venue.php',       icon('pin'), 'الموقع',          'Venue',       'أرض المهرجان والخريطة',  'The grounds and the map'],
      ['contact.php',     icon('mail'), 'تواصل معنا',      'Contact',     'نسعد بأسئلتكم',          'We are happy to help'],
    ] as $l): ?>
      <a class="card link" href="<?= e(url($l[0])) ?>">
        <div class="ic" aria-hidden="true"><?= $l[1] ?></div>
        <div class="tt"><?= e(A($l[2], $l[3])) ?></div>
        <div class="dd muted"><?= e(A($l[4], $l[5])) ?></div>
      </a>
    <?php endforeach; ?>
  </div>
</section>
<?php require __DIR__ . '/partials/footer.php'; ?>
