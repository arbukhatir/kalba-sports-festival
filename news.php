<?php
require_once __DIR__ . '/lib/render.php';
$C = content(); $NEWS = $C['NEWS']; $GALLERY = $C['GALLERY'];
$PAGE_TITLE = A('الأخبار والإعلام', 'News & Media');
$PAGE_DESC = A('آخر أخبار وإعلانات مهرجان كلباء الرياضي 2026 — التحديثات الرسمية أولاً بأول.', 'The latest news and announcements from Kalba Sports Festival 2026.');
require __DIR__ . '/partials/head.php';
require __DIR__ . '/partials/header.php';
echo page_head(A('آخر المستجدات', 'LATEST'), A('الأخبار والإعلام', 'News & Media'),
  A('كل جديد المهرجان — القصص الرئيسية والإعلانات الرسمية.', 'Everything new from the festival — top stories and official announcements.'),
  ['bg' => 'champs/ai-cycling.webp']);
$lead = $NEWS[0]; $rest = array_slice($NEWS, 1);
$date = function ($i) { return '2026-11-' . str_pad((string)(13 - $i), 2, '0', STR_PAD_LEFT); };
?>
<section class="container section"><div class="news-ed">
  <a class="news-feat" href="gallery.php">
    <img src="<?= e($GALLERY[0]['src']) ?>" alt="" loading="lazy">
    <div class="nf-body">
      <span class="nf-tag"><?= e(!empty($lead['u']) ? A('عاجل','Breaking') : A('القصة الرئيسية','Top story')) ?></span>
      <h2 class="nf-title"><?= e(tx($lead)) ?></h2>
      <div class="ni-date" style="margin-top:10px"><?= $date(0) ?></div>
    </div>
  </a>
  <div class="news-list">
    <?php foreach ($rest as $i => $n): ?>
      <div class="news-item"><span class="ni-no" aria-hidden="true"><?= sprintf('%02d', $i + 2) ?></span>
        <div><div class="ni-date"><?= !empty($n['u']) ? '<span class="nw-live">' . e(A('عاجل','Urgent')) . '</span> ' : '' ?><?= $date($i + 1) ?></div>
        <div class="ni-title"><?= e(tx($n)) ?></div></div>
      </div>
    <?php endforeach; ?>
  </div>
</div></section>
<?php require __DIR__ . '/partials/footer.php'; ?>
