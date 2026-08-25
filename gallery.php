<?php
require_once __DIR__ . '/lib/render.php';
$C = content(); $GALLERY = $C['GALLERY'];
$PAGE_TITLE = A('المعرض الإعلامي', 'Media Gallery');
require __DIR__ . '/partials/head.php';
require __DIR__ . '/partials/header.php';
echo page_head(A('الصور والفيديو', 'PHOTOS & VIDEO'), A('المعرض الإعلامي', 'Media Gallery'),
  A('لقطات من المهرجان — اضغط أي صورة لعرضها بالحجم الكامل.', 'Moments from the festival — tap any image to view it full size.'),
  ['bg' => 'champs/ai-volleyball-community.webp']);
?>
<section class="container section">
  <div class="gallery-grid">
    <?php foreach ($GALLERY as $k => $g): ?>
      <a class="gallery-item" href="#gimg<?= $k ?>"><img src="<?= e($g['src']) ?>" alt="<?= e(tx($g['cap'])) ?>" loading="lazy"><span class="gallery-cap"><?= e(tx($g['cap'])) ?></span></a>
    <?php endforeach; ?>
  </div>
  <div class="panel" style="margin-top:16px"><strong>📰 <?= e(A('للإعلام والصحافة', 'Media & press')) ?></strong>
    <?= btn(A('اعتماد إعلامي', 'Media accreditation'), 'register.php?type=media', 'sm ghost') ?></div>
</section>
<?php foreach ($GALLERY as $k => $g): ?>
  <div class="lightbox" id="gimg<?= $k ?>"><a class="lb-close" href="#" aria-label="<?= e(A('إغلاق','Close')) ?>">&times;</a><img src="<?= e($g['src']) ?>" alt="<?= e(tx($g['cap'])) ?>"><div class="lb-cap"><?= e(tx($g['cap'])) ?></div></div>
<?php endforeach; ?>
<style>
/* CSS-only lightbox (no JS): hidden until its #id is the URL :target */
.lightbox { display: none; }
.lightbox:target { display: flex; }
</style>
<?php require __DIR__ . '/partials/footer.php'; ?>
