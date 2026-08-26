<?php
require_once __DIR__ . '/lib/render.php';
$C = content(); $CT = $C['CONTACT'];
$PAGE_TITLE = A('تواصل معنا', 'Contact');
$PAGE_DESC = A('تواصل مع فريق مهرجان كلباء الرياضي 2026 — الهاتف والبريد الإلكتروني ونموذج المراسلة.', 'Contact the Kalba Sports Festival 2026 team — phone, email and a message form.');
require __DIR__ . '/partials/head.php';
require __DIR__ . '/partials/header.php';
echo page_head(A('نسعد بتواصلكم', 'GET IN TOUCH'), A('تواصل معنا', 'Contact us'),
  A('لأي استفسار عن المشاركة أو الرعاية أو الإعلام.', 'For any question about participation, sponsorship or media.'),
  ['bg' => 'champs/ai-kayak.webp']);
?>
<section class="container section" style="max-width:640px">
  <div class="panel contact-ways">
    <h2 class="sec-h" style="margin-top:0"><?= e(A('طرق التواصل', 'Ways to reach us')) ?></h2>
    <ul class="cw-list">
      <?php if (!empty($CT['phone'])): ?>
        <li><span class="cw-ic" aria-hidden="true"><?= icon('phone') ?></span>
          <span class="cw-body"><b><?= e(A('الهاتف', 'Phone')) ?></b>
            <a href="tel:<?= e(preg_replace('/[^0-9+]/', '', $CT['phone'])) ?>" dir="ltr"><?= e($CT['phone']) ?></a></span></li>
      <?php endif; ?>
      <?php if (!empty($CT['whatsapp'])): ?>
        <li><span class="cw-ic" aria-hidden="true"><?= icon('chat') ?></span>
          <span class="cw-body"><b><?= e(A('واتساب', 'WhatsApp')) ?></b>
            <a href="https://wa.me/<?= e(preg_replace('/[^0-9]/', '', $CT['whatsapp'])) ?>" target="_blank" rel="noopener" dir="ltr"><?= e($CT['whatsapp']) ?></a></span></li>
      <?php endif; ?>
      <?php if (!empty($CT['email'])): ?>
        <li><span class="cw-ic" aria-hidden="true"><?= icon('mail') ?></span>
          <span class="cw-body"><b><?= e(A('البريد الإلكتروني', 'Email')) ?></b>
            <a href="mailto:<?= e($CT['email']) ?>" dir="ltr"><?= e($CT['email']) ?></a></span></li>
      <?php endif; ?>
      <li><span class="cw-ic" aria-hidden="true"><?= icon('pin') ?></span>
        <span class="cw-body"><b><?= e(A('الموقع', 'Address')) ?></b>
          <a href="https://maps.google.com/?q=25.0757,56.3620" target="_blank" rel="noopener"><?= e(tx($CT['address'])) ?></a></span></li>
      <li><span class="cw-ic" aria-hidden="true"><?= icon('clock') ?></span>
        <span class="cw-body"><b><?= e(A('ساعات العمل', 'Hours')) ?></b><span><?= e(tx($CT['hours'])) ?></span></span></li>
    </ul>
  </div>
  <div class="panel">
    <h2 class="sec-h" style="margin-top:0"><?= e(A('أرسل لنا رسالة', 'Send us a message')) ?></h2>
  <?php if (isset($_GET['ok'])): ?>
    <div class="flash ok"><?= e(A('وصلت رسالتك — تظهر في لوحة التحكم. شكراً لتواصلك.', 'Message received — it appears in the admin panel. Thank you.')) ?></div>
  <?php elseif (isset($_GET['err'])): ?>
    <div class="flash err"><?= e(A('تعذّر الإرسال — تحقق من الحقول وحاول مجدداً.', 'Could not send — check the fields and try again.')) ?></div>
  <?php endif; ?>
  <form method="post" action="<?= e(url('actions/contact.php')) ?>">
      <?= csrf_field() ?>
    <div class="field"><label class="flabel" for="cn"><?= e(A('الاسم', 'Name')) ?> <span class="req">*</span></label><input type="text" id="cn" name="name" maxlength="120" required></div>
    <div class="field"><label class="flabel" for="ce"><?= e(A('البريد الإلكتروني', 'Email')) ?></label><input type="email" id="ce" name="email" dir="ltr" maxlength="160"></div>
    <div class="field"><label class="flabel" for="cb"><?= e(A('رسالتك', 'Your message')) ?> <span class="req">*</span></label><textarea id="cb" name="body" rows="4" maxlength="2000" required></textarea></div>
    <button class="btn primary block" type="submit"><?= e(A('إرسال', 'Send')) ?></button>
  </form>
</div></section>
<?php require __DIR__ . '/partials/footer.php'; ?>
