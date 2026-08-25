<?php
require_once __DIR__ . '/lib/render.php';
$C = content();
$PAGE_TITLE = A('تحدي مدارس كلباء', 'Kalba Schools Challenge');
require __DIR__ . '/partials/head.php';
require __DIR__ . '/partials/header.php';
echo page_head(A('للمدارس والعائلات', 'SCHOOLS & FAMILIES'), A('تحدي مدارس كلباء', 'Kalba Schools Challenge'),
  A('خمسة أيام من التحديات المعرفية والرياضية والإبداعية لطلبة المدارس وأسرهم.', 'Five days of knowledge, sports and creative challenges for students and their families.'),
  ['bg' => 'champs/ai-schools-esports.webp', 'actions' => btn(A('سجّل مدرستك', 'Register your school'), 'register.php', 'gold def')]);
?>
<section class="container section"><div class="grid g3">
  <?php
  $b = [
    ['🧠', A('تحديات معرفية', 'Knowledge'), A('مسابقات ثقافية وعلمية بنقاط فورية.', 'Cultural and science quizzes with instant points.')],
    ['🏃', A('تحديات رياضية', 'Sports'), A('سباقات وألعاب جماعية على الشاطئ.', 'Races and team games on the beach.')],
    ['🎨', A('تحديات إبداعية', 'Creative'), A('ورش فنية ومشاريع جماعية.', 'Art workshops and group projects.')],
    ['🏆', A('كأس المدارس', 'Schools cup'), A('لوحات متصدرين يومية وكأس للمدرسة الأعلى نقاطاً.', 'Daily leaderboards and a cup for the top school.')],
    ['⭐', A('مكافآت السرعة', 'Speed bonuses'), A('نقاط إضافية لأسرع المشاركين.', 'Extra points for the fastest participants.')],
    ['👪', A('مشاركة عائلية', 'Family'), A('فعاليات تجمع الطلبة وأسرهم.', 'Events that bring students and families together.')],
  ];
  foreach ($b as $x) echo '<div class="card" style="text-align:center"><div class="ic">' . $x[0] . '</div><div class="tt">' . e($x[1]) . '</div><p class="muted" style="font-size:.88rem">' . e($x[2]) . '</p></div>';
  ?>
</div></section>
<?php require __DIR__ . '/partials/footer.php'; ?>
