<?php
require_once __DIR__ . '/lib/render.php';
$defs = [
  'ideas' => [icon('bulb'), 'استبيان الأفكار', 'Ideas Survey'],
  'needs' => [icon('clipboard'), 'حصر الاحتياجات', 'Needs Assessment'],
  'satisfaction' => [icon('star'), 'قياس الرضا', 'Satisfaction'],
];
$k = isset($_GET['k']) && isset($defs[$_GET['k']]) ? $_GET['k'] : '';
if ($k === '') { header('Location: ' . url('surveys.php')); exit; }
$d = $defs[$k];
$PAGE_TITLE = A($d[1], $d[2]);
require __DIR__ . '/partials/head.php';
require __DIR__ . '/partials/header.php';
echo page_head(A('استبيان', 'SURVEY'), A($d[1], $d[2]), '', ['back' => ['surveys.php', A('كل الاستبيانات', 'All surveys')]]);
?>
<section class="container section" style="max-width:640px"><div class="panel">
  <?php if (isset($_GET['ok'])): ?>
    <div class="flash ok"><?= e(A('شكراً لمشاركتك! تم تسجيل ردك.', 'Thank you! Your response was recorded.')) ?></div>
    <div class="btn-row" style="justify-content:center"><?= btn(A('الرئيسية','Home'),'index.php','primary') ?></div>
  <?php else: ?>
    <form method="post" action="<?= e(url('actions/survey.php')) ?>">
      <input type="hidden" name="survey" value="<?= e($k) ?>">
      <div class="field"><label class="flabel" for="s1"><?= e(A('الفئة العمرية', 'Age group')) ?> <span class="req">*</span></label>
        <select id="s1" name="f_age" required><option value=""><?= e(A('اختر','Choose')) ?></option>
          <?php foreach (['<12','12–17','18–45','45+'] as $a) echo '<option>' . e($a) . '</option>'; ?></select></div>
      <div class="field"><label class="flabel" for="s2"><?= e(A('رأيك بالمهرجان (1–5)', 'Rate the festival (1–5)')) ?> <span class="req">*</span></label>
        <select id="s2" name="f_rating" required><option value=""><?= e(A('اختر','Choose')) ?></option>
          <?php for ($i = 1; $i <= 5; $i++) echo '<option>' . $i . '</option>'; ?></select></div>
      <div class="field"><label class="flabel" for="s3"><?= e(A('ملاحظاتك ومقترحاتك', 'Your comments')) ?></label><textarea id="s3" name="f_comment" rows="3" maxlength="1000"></textarea></div>
      <button class="btn primary block" type="submit"><?= e(A('إرسال', 'Submit')) ?></button>
    </form>
  <?php endif; ?>
</div></section>
<?php require __DIR__ . '/partials/footer.php'; ?>
