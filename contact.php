<?php
require_once __DIR__ . '/lib/render.php';
$C = content();
$PAGE_TITLE = A('تواصل معنا', 'Contact');
require __DIR__ . '/partials/head.php';
require __DIR__ . '/partials/header.php';
echo page_head(A('نسعد بتواصلكم', 'GET IN TOUCH'), A('تواصل معنا', 'Contact us'),
  A('لأي استفسار عن المشاركة أو الرعاية أو الإعلام.', 'For any question about participation, sponsorship or media.'),
  ['bg' => $C['GALLERY'][4]['src']]);
?>
<section class="container section" style="max-width:640px"><div class="panel">
  <?php if (isset($_GET['ok'])): ?>
    <div class="flash ok"><?= e(A('وصلت رسالتك — تظهر في لوحة التحكم. شكراً لتواصلك.', 'Message received — it appears in the admin panel. Thank you.')) ?></div>
  <?php elseif (isset($_GET['err'])): ?>
    <div class="flash err"><?= e(A('تعذّر الإرسال — تحقق من الحقول وحاول مجدداً.', 'Could not send — check the fields and try again.')) ?></div>
  <?php endif; ?>
  <form method="post" action="<?= e(url('actions/contact.php')) ?>">
    <div class="field"><label class="flabel" for="cn"><?= e(A('الاسم', 'Name')) ?> <span class="req">*</span></label><input type="text" id="cn" name="name" maxlength="120" required></div>
    <div class="field"><label class="flabel" for="ce"><?= e(A('البريد الإلكتروني', 'Email')) ?></label><input type="email" id="ce" name="email" dir="ltr" maxlength="160"></div>
    <div class="field"><label class="flabel" for="cb"><?= e(A('رسالتك', 'Your message')) ?> <span class="req">*</span></label><textarea id="cb" name="body" rows="4" maxlength="2000" required></textarea></div>
    <button class="btn primary block" type="submit"><?= e(A('إرسال', 'Send')) ?></button>
  </form>
</div></section>
<?php require __DIR__ . '/partials/footer.php'; ?>
