<?php
require_once __DIR__ . '/lib/render.php';
$PAGE_TITLE = A('استكشف الموقع', 'The Venue');
$PAGE_DESC = A('أرض مهرجان كلباء الرياضي 2026 على كورنيش كلباء — الملاعب والمداخل والمواقف والخدمات.', 'The Kalba Sports Festival 2026 grounds on the Corniche — arenas, entrances, parking and services.');
require __DIR__ . '/partials/head.php';
require __DIR__ . '/partials/header.php';
echo page_head(A('الموقع', 'THE VENUE'), A('أرض المهرجان', 'The festival ground'),
  A('كورنيش كلباء، إمارة الشارقة — الملاعب والفعاليات والخدمات والمداخل والمواقف على خريطة تفاعلية.', 'Kalba Corniche, Sharjah — courts, events, services, entrances and parking on an interactive map.'),
  ['bg' => 'portals/festival-map.webp']);
?>
<section class="container section">
  <div class="def-feat">
    <div class="def-feat-img"><a class="planlink" href="map.html" aria-label="<?= e(A('افتح الخريطة التفاعلية', 'Open the interactive map')) ?>">
      <img src="portals/festival-map.webp" alt="<?= e(A('المخطط الرسمي لأرض المهرجان', 'The official festival ground plan')) ?>" loading="lazy">
      <span class="planlink-cta"><?= icon('map') ?> <?= e(A('استكشف الخريطة التفاعلية', 'Explore the interactive map')) ?></span>
    </a></div>
    <div class="def-feat-txt"><div class="def-over"><?= e(A('الموقع', 'THE VENUE')) ?></div>
      <h2 class="sec-h"><?= e(A('خريطة أرض المهرجان التفاعلية', 'Interactive Festival Ground Map')) ?></h2>
      <p><?= e(A('المخطط الرسمي بنسخة تفاعلية: تكبير وتنقّل وبطاقة معلومات لكل موقع.', 'The official plan, made interactive: zoom, pan, and an info card for every location.')) ?></p>
      <?= btn(A('افتح الخريطة التفاعلية', 'OPEN THE INTERACTIVE MAP'), 'map.html', 'gold def') ?>
    </div>
  </div>
</section>
<?php require __DIR__ . '/partials/footer.php'; ?>
