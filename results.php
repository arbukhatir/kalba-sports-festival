<?php
require_once __DIR__ . '/lib/render.php';
$C = content(); $CHAMPS = $C['CHAMPS'];
$PAGE_TITLE = A('النتائج الفورية', 'Live Results');
$rows = [];
try { $rows = db_all('SELECT * FROM matches ORDER BY sport, day'); } catch (Throwable $ex) {}
require __DIR__ . '/partials/head.php';
require __DIR__ . '/partials/header.php';
echo page_head(A('النتائج', 'RESULTS'), A('النتائج الفورية', 'Live results'),
  A('النتائج والترتيب لحظة بلحظة خلال أيام المهرجان.', 'Scores and standings, moment by moment, through the festival.'),
  ['bg' => 'champs/ai-basketball-3x3.webp']);
?>
<section class="container section" style="max-width:820px">
  <?php if (!$rows): ?>
    <div class="panel" style="text-align:center"><div class="be">🏆</div>
      <h2 class="sec-h" style="margin-top:0"><?= e(A('تبدأ النتائج مع انطلاق المنافسات', 'Results begin when competition starts')) ?></h2>
      <p class="muted"><?= e(A('من 6 إلى 13 نوفمبر 2026 — تظهر النتائج هنا فور إدخالها من غرفة التحكم.', 'From 6–13 November 2026 — scores appear here as they are entered from the control room.')) ?></p>
      <div class="btn-row" style="justify-content:center"><?= btn(A('تصفح الرياضات', 'Browse the sports'), 'champs.php', 'primary') ?></div>
    </div>
  <?php else: foreach ($CHAMPS as $i => $c):
    $m = array_filter($rows, function ($r) use ($i) { return (int)$r['sport'] === $i; });
    if (!$m) continue; ?>
    <h2 class="sec-title"><?= e(champ_name($c)) ?></h2>
    <?php foreach ($m as $r): ?>
      <div class="lb-row">
        <span class="lb-name"><?= e(lang() === 'ar' ? ($r['side_a_ar'] ?: '—') : ($r['side_a_en'] ?: '—')) ?></span>
        <span class="lb-pts" dir="ltr"><?= $r['score_a'] === null ? '–' : (int)$r['score_a'] ?> : <?= $r['score_b'] === null ? '–' : (int)$r['score_b'] ?></span>
        <span class="lb-name" style="text-align:end"><?= e(lang() === 'ar' ? ($r['side_b_ar'] ?: '') : ($r['side_b_en'] ?: '')) ?></span>
      </div>
    <?php endforeach; ?>
  <?php endforeach; endif; ?>
</section>
<?php require __DIR__ . '/partials/footer.php'; ?>
