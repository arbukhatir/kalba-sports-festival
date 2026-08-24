<?php
require_once __DIR__ . '/lib/render.php';
$PAGE_TITLE = A('الشروط والأحكام', 'Terms');
require __DIR__ . '/partials/head.php';
require __DIR__ . '/partials/header.php';
echo page_head(A('السياسات', 'POLICIES'), A('الشروط والأحكام', 'Terms & Conditions'), '', []);
$items = [
  [A('المشاركة', 'Participation'), A('التسجيل مجاني ويُلزم المشارك بلوائح الاتحادات المعتمدة وقرارات الحكام واللجنة المنظمة.', 'Registration is free; participants agree to federation rules and the decisions of referees and the organizing committee.')],
  [A('الأمان', 'Security'), A('اتصال مشفّر SSL وسجلات تدقيق للعمليات الحساسة وصلاحيات محددة للإدارة.', 'SSL encryption, audit logs for sensitive operations, and role-based admin access.')],
  [A('صحة البيانات', 'Accuracy of data'), A('يتعهد المستخدم بصحة بياناته ومستنداته، ويحق للجنة رفض أي طلب غير مطابق.', 'Users guarantee their data and documents; the committee may reject any non-conforming application.')],
];
?>
<section class="container section" style="max-width:760px">
  <?php foreach ($items as $it): ?>
    <div class="panel"><h2 class="sec-h" style="margin-top:0"><?= e($it[0]) ?></h2><p class="muted"><?= e($it[1]) ?></p></div>
  <?php endforeach; ?>
</section>
<?php require __DIR__ . '/partials/footer.php'; ?>
