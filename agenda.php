<?php
require_once __DIR__ . '/lib/render.php';
$C = content(); $CHAMPS = $C['CHAMPS'];
$PAGE_TITLE = A('الأجندة اليومية', 'Programme');
require __DIR__ . '/partials/head.php';
require __DIR__ . '/partials/header.php';

// Build the schedule from every sport's fixture grid, grouped by day.
$byDay = [];
foreach ($CHAMPS as $i => $c) {
  foreach ($c['sch'] as $x) {
    $byDay[$x[0]][] = ['t' => $x[1], 'title' => champ_name($c) . ' — ' . round_name($x[2]), 'ic' => $c['ic']];
  }
}
uksort($byDay, function ($a, $b) {
  return ((int)explode('/', $a)[0]) <=> ((int)explode('/', $b)[0]);
});
foreach ($byDay as $d => &$evs) {
  usort($evs, function ($a, $b) { return strcmp($a['t'], $b['t']); });
}
unset($evs);

echo page_head(A('البرنامج', 'PROGRAMME'), A('الأجندة اليومية', 'Daily programme'),
  A('كل فعاليات المهرجان على مدى 8 أيام — الملاعب والأدوار والتوقيت.', 'Every festival event across 8 days — courts, rounds and times.'),
  ['bg' => $C['GALLERY'][2]['src']]);
?>
<section class="container section" style="max-width:820px">
  <h2 class="sec-title"><?= e(A('الجدول الزمني', 'Schedule')) ?></h2>
  <?php foreach ($byDay as $d => $evs): ?>
    <section class="sc-day">
      <h2 class="sc-dayhead">
        <span class="sc-dayname"><?= e(fest_day_label($d)) ?></span>
        <span class="sc-daycount"><?= e(count($evs) . ' ' . A('فعالية', 'events')) ?></span>
      </h2>
      <ul class="sc-list">
        <?php foreach ($evs as $ev): ?>
          <li class="sc-item"><div class="sc-toggle" style="cursor:default">
            <span class="sc-node" style="color:var(--spark-deep)"><?= $ev['ic'] ?></span>
            <span><span class="sc-time" dir="ltr" style="color:var(--spark)"><?= e($ev['t']) ?></span>
            <span class="sc-title"><?= e($ev['title']) ?></span></span>
            <span></span>
          </div></li>
        <?php endforeach; ?>
      </ul>
    </section>
  <?php endforeach; ?>
</section>
<?php require __DIR__ . '/partials/footer.php'; ?>
