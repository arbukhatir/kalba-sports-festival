<?php
require_once __DIR__ . '/lib/render.php';
require_once __DIR__ . '/lib/auth.php';
require_view('screen');
$PAGE_TITLE = A('شاشة العرض', 'Big Screen');
$top = [];
try { $top = db_all('SELECT name, points FROM visitors ORDER BY points DESC, id ASC LIMIT 10'); } catch (Throwable $ex) {}
require __DIR__ . '/partials/head.php';
?>
<meta http-equiv="refresh" content="30">
<?php
require __DIR__ . '/partials/header.php';
?>
<section class="container section">
  <div class="ss-head"><span class="ss-brand">★ <?= e(A('مهرجان كلباء الرياضي 2026', 'Kalba Sports Festival 2026')) ?></span>
    <span class="ss-live"><span class="live-dot"></span> <?= e(A('مباشر', 'LIVE')) ?></span></div>
  <h2 class="sec-title">🏆 <?= e(A('أعلى المتصدرين', 'Top leaders')) ?></h2>
  <?php if (!$top): ?>
    <p class="muted"><?= e(A('في انتظار أول النقاط…', 'Awaiting the first points…')) ?></p>
  <?php else: foreach ($top as $k => $r): ?>
    <div class="lb-row <?= $k < 3 ? 't' . ($k + 1) : '' ?>"><span class="lb-rank"><?= $k + 1 ?></span><span class="lb-name"><?= e($r['name']) ?></span><span class="lb-pts"><?= (int)$r['points'] ?></span></div>
  <?php endforeach; endif; ?>
  <p class="hint center"><?= e(A('تُحدَّث الشاشة تلقائياً كل 30 ثانية.', 'The screen refreshes automatically every 30 seconds.')) ?></p>
</section>
<?php require __DIR__ . '/partials/footer.php'; ?>
