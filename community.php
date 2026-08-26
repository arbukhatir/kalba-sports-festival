<?php
require_once __DIR__ . '/lib/render.php';
$C = content();
$PAGE_TITLE = A('المجتمع والورش', 'Community');
$PAGE_DESC = A('فعاليات وورش المجتمع في مهرجان كلباء الرياضي 2026 — أنشطة لكل أفراد العائلة.', 'Community events and workshops at Kalba Sports Festival 2026 — activities for the whole family.');
require __DIR__ . '/partials/head.php';
require __DIR__ . '/partials/header.php';
echo page_head(A('للعائلة كلها', 'FOR EVERYONE'), A('المجتمع والورش', 'Community & Workshops'),
  A('ورش صحية وفعاليات عائلية مجانية طوال أيام المهرجان — المقاعد محدودة.', 'Free health workshops and family events throughout the festival — seats are limited.'),
  ['bg' => 'champs/ai-schools-esports.webp', 'actions' => btn(A('تصريح الزيارة المجاني', 'Free visitor pass'), 'join.php', 'gold def')]);
?>
<section class="container section"><div class="grid g3">
  <?php
  $b = [
    ['🩺', A('ورش صحية', 'Health workshops'), A('توعية ولياقة وإسعافات أولية بإشراف مختصين.', 'Wellness, fitness and first-aid sessions led by specialists.')],
    ['🎨', A('ورش أطفال', 'Kids workshops'), A('أنشطة إبداعية يومية للأطفال.', 'Daily creative activities for children.')],
    ['🎮', A('الألعاب الإلكترونية', 'E-games'), A('بطولات وتحديات مفتوحة للجميع.', 'Open tournaments and challenges for all.')],
    ['🎡', A('ألعاب مصاحبة', 'Side games'), A('ألعاب عائلية على مدار اليوم.', 'Family side games all day.')],
    ['🍽️', A('قسم المطاعم', 'Food court'), A('مأكولات ومقاهٍ بجلسات خارجية.', 'Restaurants and cafés with outdoor seating.')],
    ['⭐', A('نظام النقاط', 'Points system'), A('امسح رمز QR بعد كل نشاط لتجمع النقاط.', 'Scan your QR after each activity to collect points.')],
  ];
  foreach ($b as $x) echo '<div class="card" style="text-align:center"><div class="ic">' . $x[0] . '</div><div class="tt">' . e($x[1]) . '</div><p class="muted" style="font-size:.88rem">' . e($x[2]) . '</p></div>';
  ?>
</div></section>
<?php require __DIR__ . '/partials/footer.php'; ?>
