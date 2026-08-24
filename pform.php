<?php
require_once __DIR__ . '/lib/render.php';
$C = content(); $CHAMPS = $C['CHAMPS'];
$i = isset($_GET['i']) ? (int) $_GET['i'] : 0;
if ($i < 0 || $i >= count($CHAMPS)) $i = 0;
$c = $CHAMPS[$i];
$PAGE_TITLE = A('تسجيل مشارك', 'Participant registration');
require __DIR__ . '/partials/head.php';
require __DIR__ . '/partials/header.php';
echo page_head(A('تسجيل مشارك', 'PARTICIPANT'), champ_name($c),
  A('سجّل مشاركتك في هذه الرياضة — يصلك رقم مرجعي فور الإرسال.', 'Register for this sport — you get a reference number on submit.'),
  ['bg' => champ_img($c), 'back' => ['champ.php?i=' . $i, champ_name($c)]]);
?>
<section class="container section" style="max-width:620px"><div class="panel">
  <?php if (isset($_GET['ok'])): ?>
    <div class="flash ok"><?= e(A('تم التسجيل! رقمك المرجعي', 'Registered! Your reference')) ?>: <b dir="ltr"><?= e($_GET['ok']) ?></b></div>
    <div class="btn-row"><?= btn(A('الرياضات', 'Sports'), 'champs.php', 'primary') ?></div>
  <?php else: ?>
    <?php if (isset($_GET['err'])): ?><div class="flash err"><?= e(A('تحقق من الحقول وحاول مجدداً.', 'Check the fields and try again.')) ?></div><?php endif; ?>
    <form method="post" action="<?= e(url('actions/register.php')) ?>" enctype="multipart/form-data">
      <input type="hidden" name="type" value="<?= e($c['s']) ?>">
      <div class="field"><label class="flabel" for="_name"><?= e(A('الاسم الكامل', 'Full name')) ?> <span class="req">*</span></label><input type="text" id="_name" name="_name" maxlength="150" required></div>
      <div class="frow">
        <div class="field"><label class="flabel" for="_phone"><?= e(A('الهاتف', 'Phone')) ?> <span class="req">*</span></label><input type="tel" id="_phone" name="_phone" dir="ltr" required></div>
        <div class="field"><label class="flabel" for="_email"><?= e(A('البريد الإلكتروني', 'Email')) ?> <span class="req">*</span></label><input type="email" id="_email" name="_email" dir="ltr" required></div>
      </div>
      <div class="field"><label class="flabel" for="_cat"><?= e(A('الفئة', 'Category')) ?> <span class="req">*</span></label>
        <select id="_cat" name="f_category" required><option value=""><?= e(A('اختر','Choose')) ?></option>
          <option><?= e(A('ناشئون','Juniors')) ?></option><option><?= e(A('كبار','Seniors')) ?></option><option><?= e(A('سيدات','Women')) ?></option></select></div>
      <div class="field"><label class="flabel" for="_iban"><?= e(A('شهادة الآيبان IBAN من البنك (لصرف الجوائز)', 'IBAN certificate from the bank (for prize payouts)')) ?> <span class="req">*</span></label><input type="file" id="_iban" name="f_iban" accept=".pdf,.jpg,.jpeg,.png" required><div class="hint">PDF / JPG / PNG — 8 MB</div></div>
      <div class="field"><label class="flabel" for="_id"><?= e(A('صورة الهوية', 'ID copy')) ?> <span class="opt">(<?= e(A('اختياري','optional')) ?>)</span></label><input type="file" id="_id" name="f_id" accept=".pdf,.jpg,.jpeg,.png"></div>
      <button class="btn gold block" type="submit"><?= e(A('سجّل الآن', 'Register now')) ?></button>
    </form>
  <?php endif; ?>
</div></section>
<?php require __DIR__ . '/partials/footer.php'; ?>
