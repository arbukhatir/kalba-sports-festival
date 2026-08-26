<?php
/* One lookup box serves both audiences: a visitor pass code shows points, a
   participant reference shows where the application stands. Requirement 3 asks
   for "متابعة حالة الطلب (قيد المراجعة / مقبول / مرفوض)". */
require_once __DIR__ . '/lib/render.php';
$C = content(); $CHAMPS = $C['CHAMPS']; $FORMS = $C['FORMS'];
$code = trim($_GET['code'] ?? '');
$v = null; $app = null;
if ($code !== '') {
  try { $v = db_one('SELECT * FROM visitors WHERE code = ?', [$code]); } catch (Throwable $ex) {}
  if (!$v) {
    try { $app = db_one('SELECT * FROM applications WHERE ref = ?', [$code]); } catch (Throwable $ex) {}
  }
}
$PAGE_TITLE = A('بطاقتي وحالة طلبي', 'My pass & application');
$PAGE_DESC = A('تابع تصريح الزيارة أو حالة طلب مشاركتك في مهرجان كلباء الرياضي 2026 برقمك المرجعي.', 'Track your visitor pass or the status of your entry to Kalba Sports Festival 2026 with your reference.');
require __DIR__ . '/partials/head.php';
require __DIR__ . '/partials/header.php';
echo page_head(A('المتابعة', 'TRACK'), A('بطاقتي وحالة طلبي', 'My pass & application'),
  A('أدخل رمز التصريح لعرض نقاطك، أو رقمك المرجعي لمعرفة حالة طلب المشاركة.', 'Enter a pass code to see your points, or an application reference to see where your entry stands.'), []);

/* what the three application states mean, in the visitor's language */
$STATES = [
  'pending'  => [A('قيد المراجعة', 'Under review'),  'pending',
                 A('وصل طلبك وتتم مراجعته من اللجنة المنظمة. لا حاجة لإرساله مرة أخرى.', 'Your entry has arrived and the organising committee is reviewing it. No need to send it again.')],
  'accepted' => [A('مقبول', 'Accepted'),             'accepted',
                 A('تم قبول مشاركتك. أحضر رقمك المرجعي وهويتك إلى نقطة الاعتماد قبل موعدك بساعة.', 'Your entry is accepted. Bring this reference and your ID to the accreditation desk an hour before your slot.')],
  'rejected' => [A('غير مكتمل', 'Not accepted'),     'rejected',
                 A('لم تكتمل شروط المشاركة في هذا الطلب. تواصل معنا لمعرفة التفاصيل أو أرسل طلباً جديداً.', 'This entry did not meet the conditions. Contact us for the details, or submit a new one.')],
];
?>
<section class="container section" style="max-width:560px">
  <?php if ($v): ?>
    <div class="vcard">
      <div class="vh"><?= icon('star') ?> <?= e($v['name']) ?></div>
      <div class="vqr"><?= qr_svg($v['code'], 190) ?></div>
      <div class="vcode"><?= e(A('امسح الرمز عند البوابة', 'Scan this at the gate')) ?> · <b dir="ltr"><?= e($v['code']) ?></b></div>
      <div class="vstats">
        <div class="vstat"><div class="n"><?= (int)$v['points'] ?></div><div class="l"><?= e(A('نقطة', 'points')) ?></div></div>
      </div>
      <?php if (!empty($v['age_group'])): ?><div class="vage"><?= e($v['age_group']) ?></div><?php endif; ?>
    </div>
    <div class="btn-row" style="justify-content:center">
      <?= btn(A('لوحة المتصدرين', 'Leaderboard'), 'leaderboard.php', 'ghost') ?>
      <?= btn(A('الأجندة', 'Programme'), 'agenda.php', 'primary') ?>
    </div>

  <?php elseif ($app):
    $st = $STATES[$app['status']] ?? $STATES['pending'];
    /* the entry type is either a sport slug or a portal form key */
    $label = $app['type'];
    foreach ($CHAMPS as $c) if ($c['s'] === $app['type']) $label = champ_name($c);
    if (isset($FORMS[$app['type']])) $label = tx($FORMS[$app['type']]['t']);
    $pl = [];
    if (!empty($app['payload'])) { $pl = json_decode($app['payload'], true) ?: []; }
    ?>
    <div class="panel app-status">
      <div class="as-head">
        <span class="as-ref"><?= e(A('رقمك المرجعي', 'Your reference')) ?> <b dir="ltr"><?= e($app['ref']) ?></b></span>
        <span class="badge <?= e($st[1]) ?>"><?= e($st[0]) ?></span>
      </div>
      <h2 class="sec-h"><?= e($label) ?></h2>
      <p class="muted"><?= e($st[2]) ?></p>

      <!-- the three states as a rail, so the applicant sees where they are -->
      <ol class="as-rail" aria-label="<?= e(A('مراحل الطلب', 'Application stages')) ?>">
        <?php
        $order = ['pending', $app['status'] === 'rejected' ? 'rejected' : 'accepted'];
        $reached = true;
        foreach (['received' => A('وصل الطلب', 'Received'),
                  'review'   => A('قيد المراجعة', 'Under review'),
                  'final'    => ($app['status'] === 'rejected' ? A('غير مكتمل', 'Not accepted') : A('مقبول', 'Accepted'))] as $k => $t):
          $done = ($k === 'received') || ($k === 'review') || ($app['status'] !== 'pending');
          $cur  = ($k === 'review' && $app['status'] === 'pending') || ($k === 'final' && $app['status'] !== 'pending');
        ?>
          <li class="<?= $done ? 'done' : '' ?><?= $cur ? ' cur' : '' ?>">
            <span class="as-dot"><?= $done ? icon('check') : '' ?></span>
            <span class="as-t"><?= e($t) ?></span>
          </li>
        <?php endforeach; ?>
      </ol>

      <?php if (!empty($pl['team_name'])): ?>
        <div class="vroster">
          <b><?= e(A('الفريق', 'Team')) ?>: <?= e($pl['team_name']) ?></b>
          <?php if (!empty($pl['players']) && is_array($pl['players'])): ?>
            <ol><?php foreach ($pl['players'] as $pn) echo '<li>' . e($pn) . '</li>'; ?></ol>
          <?php endif; ?>
        </div>
      <?php endif; ?>

      <?php if ($app['status'] === 'accepted'): ?>
        <div class="acc-qr">
          <div class="vqr"><?= qr_svg($app['ref'], 190) ?></div>
          <p class="hint"><?= e(A('اعرض هذا الرمز عند نقطة الاعتماد الميداني — يُمسح مرة واحدة لتأكيد مشاركتك.', 'Show this code at the field accreditation desk — one scan confirms your entry.')) ?></p>
        </div>
      <?php endif; ?>
      <p class="hint"><?= e(A('احتفظ بهذا الرقم — هو ما نطلبه عند الاعتماد الميداني وفي أي استفسار.', 'Keep this reference — it is what we ask for at field accreditation and in any enquiry.')) ?></p>
      <div class="btn-row"><?= btn(A('تواصل معنا', 'Contact us'), 'contact.php', 'ghost sm') ?></div>
    </div>

  <?php else: ?>
    <div class="panel">
      <?php if ($code !== ''): ?>
        <div class="flash err" role="alert"><?= e(A('لم نجد تصريحاً أو طلباً بهذا الرمز. تأكد من الرمز كما وصلك تماماً.', 'No pass or application matches that code. Check it exactly as you received it.')) ?></div>
      <?php endif; ?>
      <form method="get" action="my.php">
        <div class="field">
          <label class="flabel" for="mc"><?= e(A('رمز التصريح أو الرقم المرجعي', 'Pass code or application reference')) ?></label>
          <input type="text" id="mc" name="code" dir="ltr" required
                 placeholder="<?= e(A('مثال: KLB-2026-XXXX', 'e.g. KLB-2026-XXXX')) ?>" value="<?= e($code) ?>">
        </div>
        <button class="btn primary block" type="submit"><?= e(A('عرض الحالة', 'Show status')) ?></button>
      </form>
      <p class="hint"><?= e(A('لا تملك تصريحاً؟', 'No pass yet?')) ?>
        <a href="<?= e(url('join.php')) ?>"><?= e(A('أنشئ واحداً مجاناً', 'Create one free')) ?></a> ·
        <a href="<?= e(url('register.php')) ?>"><?= e(A('سجّل مشاركتك', 'Register to compete')) ?></a></p>
    </div>
  <?php endif; ?>
</section>
<?php require __DIR__ . '/partials/footer.php'; ?>
