<?php
require_once __DIR__ . '/lib/render.php';
$C = content(); $FORMS = $C['FORMS'];
$type = isset($_GET['type']) && isset($FORMS[$_GET['type']]) ? $_GET['type'] : '';
$PAGE_TITLE = A('التسجيل', 'Register');
$PAGE_DESC = A('سجّل في مهرجان كلباء الرياضي 2026 — تسجيل المشاركين والمطاعم والعارضين والرعاة والمتطوعين.', 'Register for Kalba Sports Festival 2026 — competitors, restaurants, exhibitors, sponsors and volunteers.');
require __DIR__ . '/partials/head.php';
require __DIR__ . '/partials/header.php';
echo page_head(A('انضم إلينا', 'JOIN US'), A('التسجيل والانضمام', 'Registration'),
  A('اختر نوع التسجيل ثم عبّئ النموذج — يصلك رقم مرجعي فور الإرسال.', 'Pick a registration type and fill the form — you get a reference number on submit.'),
  ['bg' => 'champs/ai-obstacles.webp']);
?>
<section class="container section" style="max-width:720px">
  <?php if (isset($_GET['err'])): ?>
    <div class="flash err" role="alert"><?= e($_GET['err'] === 'db'
      ? A('تعذّر حفظ طلبك حالياً. حاول مرة أخرى بعد قليل أو تواصل معنا.', 'We could not save your application right now. Please try again shortly or contact us.')
      : A('تعذّر إرسال الطلب — تأكد من تعبئة الحقول المطلوبة بشكل صحيح.', 'Could not submit — please check that the required fields are filled in correctly.')) ?></div>
  <?php endif; ?>
  <?php if (isset($_GET['ok'])): ?>
    <div class="panel success-panel" style="text-align:center"><div class="be">✅</div>
      <h2><?= e(A('تم استلام طلبك', 'Application received')) ?></h2>
      <p><?= e(A('رقمك المرجعي', 'Your reference')) ?>: <b dir="ltr"><?= e($_GET['ok']) ?></b></p>
      <p class="muted"><?= e(A('يظهر طلبك في لوحة التحكم وتتم مراجعته من اللجنة.', 'Your application appears in the admin panel for committee review.')) ?></p>
      <div class="btn-row" style="justify-content:center"><?= btn(A('الرئيسية', 'Home'), 'index.php', 'primary') . ' ' . btn(A('تسجيل آخر', 'Register again'), 'register.php', 'ghost') ?></div>
    </div>
  <?php elseif ($type === ''): ?>
    <div class="panel" style="margin-bottom:16px"><strong>🏆 <?= e(A('مشارك في بطولة؟', 'Competing in a sport?')) ?></strong>
      <?= btn(A('سجّل من صفحة الرياضة', 'Register from the sport page'), 'champs.php', 'sm gold') ?></div>
    <p class="sec-intro"><?= e(A('اختر نوع التسجيل:', 'Choose a registration type:')) ?></p>
    <div class="grid g2">
      <?php foreach ($FORMS as $k => $f): ?>
        <a class="card link" href="<?= e(url('register.php?type=' . $k)) ?>"><div class="ic" aria-hidden="true"><?= $f['ic'] ?></div>
          <div class="tt"><?= e(tx($f['t'])) ?></div><div class="dd muted" style="font-size:.86rem"><?= e(tx($f['d'])) ?></div></a>
      <?php endforeach; ?>
    </div>
  <?php else: $f = $FORMS[$type]; $emailReq = $type === 'sports'; ?>
    <div class="panel">
      <div class="reg-picked"><span class="ic"><?= $f['ic'] ?></span><div><b><?= e(tx($f['t'])) ?></b><span><?= e(tx($f['d'])) ?></span></div></div>
      <form method="post" action="<?= e(url('actions/register.php')) ?>" enctype="multipart/form-data">
        <input type="hidden" name="type" value="<?= e($type) ?>">
        <h2 class="sec-h reg-sub"><?= e(A('بيانات مقدّم الطلب', 'Applicant details')) ?></h2>
        <div class="field"><label class="flabel" for="_name"><?= e(A('الاسم الكامل', 'Full name')) ?> <span class="req">*</span></label><input type="text" id="_name" name="_name" maxlength="150" required></div>
        <div class="field"><label class="flabel" for="_phone"><?= e(A('رقم الهاتف', 'Phone')) ?> <span class="req">*</span></label><input type="tel" id="_phone" name="_phone" dir="ltr" maxlength="30" required></div>
        <div class="field"><label class="flabel" for="_email"><?= e(A('البريد الإلكتروني', 'Email')) ?> <?= $emailReq ? '<span class="req">*</span>' : '<span class="opt">(' . e(A('اختياري','optional')) . ')</span>' ?></label><input type="email" id="_email" name="_email" dir="ltr" maxlength="150"<?= $emailReq ? ' required' : '' ?>></div>
        <h2 class="sec-h reg-sub"><?= e(A('تفاصيل الطلب', 'Application details')) ?></h2>
        <?php foreach ($f['fields'] as $fld) echo form_field($fld); ?>
        <button class="btn primary block" type="submit" style="margin-top:16px"><?= e(A('إرسال الطلب', 'Submit application')) ?></button>
      </form>
    </div>
  <?php endif; ?>
</section>
<?php require __DIR__ . '/partials/footer.php'; ?>
