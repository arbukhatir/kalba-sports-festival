<?php
require_once __DIR__ . '/lib/render.php';
$C = content(); $CHAMPS = $C['CHAMPS'];
$i = isset($_GET['i']) ? (int) $_GET['i'] : 0;
if ($i < 0 || $i >= count($CHAMPS)) $i = 0;
$c = $CHAMPS[$i];
$PAGE_TITLE = champ_name($c);
$PAGE_DESC = A(champ_name($c) . ' في مهرجان كلباء الرياضي 2026 — مواعيد المنافسة والأدوار والتسجيل.', champ_name($c) . ' at Kalba Sports Festival 2026 — fixtures, rounds and registration.');
require __DIR__ . '/partials/head.php';
require __DIR__ . '/partials/header.php';

$actions =
  btn(A('سجّل الآن', 'REGISTER NOW'), 'pform.php?i=' . $i, 'gold def') . ' ' .
  btn(A('عرض على الخريطة', 'VIEW ON MAP'), 'map.html', 'def defghost');

echo page_head(
  A('رياضة معتمدة', 'OFFICIAL SPORT'),
  champ_name($c),
  A('منافسة رسمية معتمدة ضمن مهرجان كلباء الرياضي 2026.', 'An official accredited competition at Kalba Sports Festival 2026.'),
  ['bg' => champ_img($c), 'back' => ['champs.php', A('كل الرياضات', 'All sports')], 'actions' => $actions]
);
?>
<section class="container section" style="padding-bottom:0"><div class="panel">
  <h2 class="sec-h" style="margin-top:0">🗓️ <?= e(A('جدول المنافسات', 'Fixture schedule')) ?></h2>
  <p class="sec-intro"><?= e(days_label(count($c['sch'])) . ' · ' . champ_dates($c) . ' · ' . A('كورنيش كلباء', 'Kalba Corniche')) ?></p>
  <div class="tbl-wrap"><table class="fx-table">
    <thead><tr>
      <th scope="col"><?= e(A('اليوم', 'Day')) ?></th>
      <th scope="col"><?= e(A('التوقيت', 'Time')) ?></th>
      <th scope="col"><?= e(A('الدور', 'Round')) ?></th>
    </tr></thead>
    <tbody>
      <?php foreach ($c['sch'] as $x): ?>
        <tr><td><?= e(fest_day_label($x[0])) ?></td><td dir="ltr"><?= e($x[1]) ?></td><td><strong><?= e(round_name($x[2])) ?></strong></td></tr>
      <?php endforeach; ?>
    </tbody>
  </table></div>
</div></section>

<section class="container section"><div class="grid g2">
  <?php
  $blocks = [
    ['🎯', A('الفئات وشروط المشاركة', 'Categories & conditions'), A('أشبال / ناشئون / كبار / سيدات — التفاصيل تُدار من لوحة التحكم.', 'Cubs / juniors / seniors / women — details managed from the admin panel.')],
    ['📋', A('اللوائح والقواعد', 'Rules & regulations'), A('تُطبّق لوائح الاتحاد المعتمدة ويلتزم المشاركون بقرارات الحكام.', 'Official federation regulations apply.')],
    ['🏅', A('الجوائز والتكريم', 'Prizes'), A('كأس وميداليات للمراكز الثلاثة الأولى وشهادات للجميع.', 'Cup & medals for the top three, certificates for all.')],
  ];
  foreach ($blocks as $b) echo '<div class="panel"><h2 class="sec-h" style="margin-top:0">' . $b[0] . ' ' . e($b[1]) . '</h2><p class="muted">' . e($b[2]) . '</p></div>';
  ?>
</div></section>
<?php require __DIR__ . '/partials/footer.php'; ?>
