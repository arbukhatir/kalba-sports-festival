<?php
require_once __DIR__ . '/lib/render.php';
$C = content();
$PAGE_TITLE = A('تصريح الزيارة', 'Visitor Pass');
$PAGE_DESC = A('احصل على تصريح الزيارة المجاني لمهرجان كلباء الرياضي 2026 ببطاقة رقمية ورمز دخول.', 'Get your free visitor pass for Kalba Sports Festival 2026 — a digital card with an entry code.');
require __DIR__ . '/partials/head.php';
require __DIR__ . '/partials/header.php';
echo page_head(A('بطاقة الزائر', 'VISITOR CARD'), A('تصريح الزيارة المجاني', 'Free visitor pass'),
  A('تصريح رقمي مجاني يجمع نقاطك عند كل نشاط.', 'A free digital pass that collects your points at every activity.'),
  ['bg' => 'champs/ai-football.webp']);
$ages = [['<12','أقل من 12','Under 12'],['12-17','12–17','12–17'],['18-45','18–45','18–45'],['45+','45+','45+']];
?>
<section class="container section" style="max-width:600px"><div class="panel">
  <?php if (isset($_GET['ok'])): ?>
    <div class="flash ok" role="status"><?= e(A('تم إنشاء تصريحك!', 'Your pass is ready!')) ?></div>
    <div class="vcard">
      <div class="vqr"><?= qr_svg($_GET['ok'], 190) ?></div>
      <div class="vcode"><?= e(A('امسح الرمز عند البوابة', 'Scan this at the gate')) ?> · <b dir="ltr"><?= e($_GET['ok']) ?></b></div>
    </div>
    <p class="muted"><?= e(A('أظهر هذا الرمز عند الدخول ونقاط الأنشطة.', 'Show this code at entry and activity points.')) ?></p>
    <div class="btn-row" style="justify-content:center"><?= btn(A('الرئيسية','Home'),'index.php','primary') ?></div>
  <?php else: ?>
    <?php if (isset($_GET['err'])): ?><div class="flash err"><?= e(A('تحقق من الحقول والموافقة على الشروط.', 'Check the fields and accept the terms.')) ?></div><?php endif; ?>
    <form method="post" action="<?= e(url('actions/join.php')) ?>">
      <?= csrf_field() ?>
      <div class="field"><label class="flabel" for="jn"><?= e(A('الاسم الكامل','Full name')) ?> <span class="req">*</span></label><input type="text" id="jn" name="name" maxlength="120" required></div>
      <div class="field"><label class="flabel" for="ja"><?= e(A('الفئة العمرية','Age group')) ?> <span class="req">*</span></label>
        <select id="ja" name="age" required><option value=""><?= e(A('اختر','Choose')) ?></option>
          <?php foreach ($ages as $a) echo '<option value="' . e($a[0]) . '">' . e(A($a[1], $a[2])) . '</option>'; ?>
        </select></div>
      <!-- One pass for the whole family, so a parent is not asked to repeat
           the form per child at the gate. -->
      <div class="field">
        <label class="flabel" for="jf"><?= e(A('مرافقون على نفس التصريح', 'People joining on this pass')) ?>
          <span class="opt">(<?= e(A('اختياري', 'optional')) ?>)</span></label>
        <select id="jf" name="family">
          <?php for ($f = 0; $f <= 8; $f++): ?>
            <option value="<?= $f ?>"><?= e($f === 0 ? A('لا أحد — تصريح فردي', 'Just me — single pass')
                : sprintf(A('%d مرافقين', '%d more'), $f)) ?></option>
          <?php endfor; ?>
        </select>
        <div class="hint"><?= e(A('تصريح عائلي واحد يُمسح مرة واحدة عند الدخول للجميع.', 'One family pass, scanned once at the gate for everyone.')) ?></div>
      </div>
      <label class="check" style="margin-bottom:12px"><input type="checkbox" name="consent" value="1" required> <span><?= e(A('أوافق على الشروط وسياسة الخصوصية', 'I agree to the Terms and Privacy Policy')) ?></span></label>
      <button class="btn gold block" type="submit"><?= e(A('أنشئ تصريحي', 'Create my pass')) ?></button>
    </form>
  <?php endif; ?>
</div></section>
<?php require __DIR__ . '/partials/footer.php'; ?>
