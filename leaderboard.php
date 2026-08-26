<?php
require_once __DIR__ . '/lib/render.php';
$C = content();
$PAGE_TITLE = A('متصدرو الأنشطة', 'Activity leaderboard');
$PAGE_DESC = A('متصدرو الأنشطة في مهرجان كلباء الرياضي 2026 — نقاط الزوار المجمَّعة من الأنشطة والورش. ترتيب البطولات في صفحة النتائج.', 'Activity leaders at Kalba Sports Festival 2026 — visitor points collected at activities and workshops. Championship standings live on the results page.');
$rows = [];
try { $rows = db_all('SELECT name, points FROM visitors ORDER BY points DESC, id ASC LIMIT 50'); } catch (Throwable $ex) {}
require __DIR__ . '/partials/head.php';
require __DIR__ . '/partials/header.php';
echo page_head(A('نقاط الزوار', 'VISITOR POINTS'), A('متصدرو الأنشطة', 'Activity leaderboard'),
  A('هذه لوحة الزوار: اجمع النقاط عند كل نشاط وورشة بمسح تصريحك. أما ترتيب فرق البطولات فتجده في صفحة النتائج.',
    'This is the visitor board: collect points at each activity and workshop by scanning your pass. Championship team standings are on the results page.'),
  ['bg' => 'champs/ai-boxing.webp']);
?>
<section class="container section" style="max-width:680px">
  <div class="board-switch">
    <span class="bs-on"><?= icon('star') ?> <?= e(A('متصدرو الأنشطة', 'Activity leaders')) ?></span>
    <a class="bs-off" href="<?= e(url('results.php?t=overall')) ?>"><?= icon('trophy') ?> <?= e(A('ترتيب فرق البطولات', 'Championship teams')) ?></a>
  </div>
  <?php if (!$rows): ?>
    <div class="panel" style="text-align:center"><div class="be"><?= icon('star') ?></div>
      <h2 class="sec-h" style="margin-top:0"><?= e(A('كن أول المتصدرين', 'Be the first on the board')) ?></h2>
      <p class="muted"><?= e(A('أنشئ تصريح الزيارة واجمع النقاط عند كل نشاط.', 'Create your visitor pass and collect points at every activity.')) ?></p>
      <div class="btn-row" style="justify-content:center"><?= btn(A('تصريح الزيارة المجاني', 'Free visitor pass'), 'join.php', 'gold') ?></div>
    </div>
  <?php else: foreach ($rows as $k => $r): ?>
    <div class="lb-row <?= $k < 3 ? 't' . ($k + 1) : '' ?>">
      <span class="lb-rank"><?= $k + 1 ?></span>
      <span class="lb-name"><?= e($r['name']) ?></span>
      <span class="lb-pts"><?= (int) $r['points'] ?></span>
    </div>
  <?php endforeach; endif; ?>
</section>
<?php require __DIR__ . '/partials/footer.php'; ?>
