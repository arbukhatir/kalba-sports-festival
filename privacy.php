<?php
require_once __DIR__ . '/lib/render.php';
$PAGE_TITLE = A('سياسة الخصوصية', 'Privacy');
$PAGE_DESC = A('سياسة الخصوصية لمهرجان كلباء الرياضي 2026 — كيف نجمع بياناتك ونستخدمها ونحميها.', 'The Kalba Sports Festival 2026 privacy policy — how we collect, use and protect your data.');
require __DIR__ . '/partials/head.php';
require __DIR__ . '/partials/header.php';
echo page_head(A('السياسات', 'POLICIES'), A('سياسة الخصوصية', 'Privacy Policy'), '', []);
$items = [
  [A('البيانات التي نجمعها', 'Data we collect'), A('نجمع فقط ما يلزم للتسجيل والمشاركة: الاسم ووسيلة التواصل وتفاصيل الطلب.', 'We collect only what registration and participation require: name, contact, and application details.')],
  [A('كيف نستخدمها', 'How we use it'), A('تُستخدم لإدارة المشاركة والتواصل معك بشأن طلبك، ولا تُشارك مع أطراف خارجية لأغراض تسويقية.', 'Used to manage participation and contact you about your application; never shared with third parties for marketing.')],
  [A('حقوقك', 'Your rights'), A('يمكنك طلب تصحيح بياناتك أو حذفها بالتواصل مع اللجنة المنظمة.', 'You may request correction or deletion of your data by contacting the organizing committee.')],
];
?>
<section class="container section" style="max-width:760px">
  <?php foreach ($items as $it): ?>
    <div class="panel"><h2 class="sec-h" style="margin-top:0"><?= e($it[0]) ?></h2><p class="muted"><?= e($it[1]) ?></p></div>
  <?php endforeach; ?>
</section>
<?php require __DIR__ . '/partials/footer.php'; ?>
