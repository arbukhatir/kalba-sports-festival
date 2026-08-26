<?php
require_once __DIR__ . '/lib/render.php';
$C = content(); $CHAMPS = $C['CHAMPS']; $CATS = $C['CHAMP_CATS'];
$PAGE_TITLE = A('الرياضات الـ13 المعتمدة', 'The 13 Official Sports');
$PAGE_DESC = A('تعرّف على الرياضات الـ13 المعتمدة في مهرجان كلباء الرياضي 2026 — مواعيد المنافسات والفئات والتسجيل.', 'Explore the 13 official sports of Kalba Sports Festival 2026 — fixtures, categories and how to register.');
require __DIR__ . '/partials/head.php';
require __DIR__ . '/partials/header.php';

echo page_head(
  A('المنافسات', 'COMPETITIONS'),
  A('الرياضات الـ13 المعتمدة', 'The 13 Official Sports'),
  A('منافسات رسمية معتمدة على كورنيش كلباء — اضغط أي بطولة للتفاصيل والتسجيل.', 'Official competitions on the Kalba Corniche — open any sport for details and registration.'),
  ['bg' => champ_img($CHAMPS[0])]
);
?>
<section class="container section">
  <?php foreach ($CATS as $cat):
    $items = [];
    foreach ($CHAMPS as $i => $c) if ($c['c'] === $cat['k']) $items[$i] = $c;
    if (!$items) continue; ?>
    <h2 class="sec-title"><?= e(tx($cat)) ?></h2>
    <div class="ev-grid">
      <?php foreach ($items as $i => $c) echo sport_card($c, $i); ?>
    </div>
  <?php endforeach; ?>
</section>
<?php require __DIR__ . '/partials/footer.php'; ?>
