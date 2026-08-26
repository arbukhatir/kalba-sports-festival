<?php
require_once __DIR__ . '/lib/render.php';
$C = content();
$PAGE_TITLE = A('لوحة المتصدرين', 'Leaderboard');
$PAGE_DESC = A('لوحة المتصدرين في مهرجان كلباء الرياضي 2026 — ترتيب الفرق والمشاركين ونقاطهم.', 'The Kalba Sports Festival 2026 leaderboard — team and participant standings and points.');
$rows = [];
try { $rows = db_all('SELECT name, points FROM visitors ORDER BY points DESC, id ASC LIMIT 50'); } catch (Throwable $ex) {}
require __DIR__ . '/partials/head.php';
require __DIR__ . '/partials/header.php';
echo page_head(A('المتصدرون', 'LEADERBOARD'), A('لوحة المتصدرين', 'Leaderboard'),
  A('اجمع النقاط عند كل نشاط وتصدّر لوحة المهرجان.', 'Collect points at every activity and top the festival board.'),
  ['bg' => 'champs/ai-boxing.webp']);
?>
<section class="container section" style="max-width:680px">
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
