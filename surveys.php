<?php
require_once __DIR__ . '/lib/render.php';
$C = content();
$PAGE_TITLE = A('الاستبيانات', 'Surveys');
require __DIR__ . '/partials/head.php';
require __DIR__ . '/partials/header.php';
echo page_head(A('رأيك يهمنا', 'YOUR VOICE'), A('الاستبيانات', 'Surveys'),
  A('شاركنا رأيك — قبل المهرجان وأثناءه وبعده.', 'Share your view — before, during and after the festival.'),
  ['bg' => 'champs/ai-taekwondo.webp']);
$surveys = [
  ['ideas', '💡', 'استبيان الأفكار', 'Ideas Survey', 'تفضيلات الجمهور حول الأنشطة.', 'Public activity preferences.'],
  ['needs', '📋', 'حصر الاحتياجات', 'Needs Assessment', 'فهم توقعات الزوار وخدماتهم.', 'Understanding visitor expectations.'],
  ['satisfaction', '⭐', 'قياس الرضا', 'Satisfaction', 'الرضا العام ومؤشر التوصية.', 'Overall satisfaction and NPS.'],
];
?>
<section class="container section"><div class="grid g3">
  <?php foreach ($surveys as $s): ?>
    <a class="card link" href="<?= e(url('survey.php?k=' . $s[0])) ?>"><div class="ic" aria-hidden="true"><?= $s[1] ?></div>
      <div class="tt"><?= e(A($s[2], $s[3])) ?></div><div class="dd muted" style="font-size:.86rem"><?= e(A($s[4], $s[5])) ?></div></a>
  <?php endforeach; ?>
</div></section>
<?php require __DIR__ . '/partials/footer.php'; ?>
