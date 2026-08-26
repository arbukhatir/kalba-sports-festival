<?php
require_once __DIR__ . '/lib/render.php';
$C = content(); $CHAMPS = $C['CHAMPS'];
$i = isset($_GET['i']) ? (int) $_GET['i'] : 0;
if ($i < 0 || $i >= count($CHAMPS)) $i = 0;
$c = $CHAMPS[$i];
$isTeam = ($c['c'] === 'team' && !empty($c['team']));
$tmin = $isTeam ? (int) $c['team']['min'] : 0;
$tmax = $isTeam ? (int) $c['team']['max'] : 0;
$PAGE_TITLE = $isTeam ? A('تسجيل فريق', 'Team registration') : A('تسجيل مشارك', 'Participant registration');
$PAGE_DESC = A('سجّل مشاركتك في ' . champ_name($c) . ' ضمن مهرجان كلباء الرياضي 2026.', 'Register to compete in ' . champ_name($c) . ' at Kalba Sports Festival 2026.');
require __DIR__ . '/partials/head.php';
require __DIR__ . '/partials/header.php';
echo page_head($isTeam ? A('تسجيل فريق', 'TEAM ENTRY') : A('تسجيل مشارك', 'PARTICIPANT'), champ_name($c),
  $isTeam
    ? A('سجّل فريقك في هذه الرياضة — بيانات كابتن الفريق وقائمة اللاعبين، ويصلك رقم مرجعي فور الإرسال.',
        'Register your team for this sport — captain details and the squad list. You get a reference number on submit.')
    : A('سجّل مشاركتك في هذه الرياضة — يصلك رقم مرجعي فور الإرسال.', 'Register for this sport — you get a reference number on submit.'),
  ['bg' => champ_img($c), 'back' => ['champ.php?i=' . $i, champ_name($c)]]);
?>
<section class="container section" style="max-width:660px"><div class="panel">
  <?php if (isset($_GET['ok'])): ?>
    <div class="flash ok" role="status"><?= e($isTeam ? A('تم تسجيل فريقك! رقمكم المرجعي', 'Your team is registered! Your reference') : A('تم التسجيل! رقمك المرجعي', 'Registered! Your reference')) ?>: <b dir="ltr"><?= e($_GET['ok']) ?></b></div>
    <div class="btn-row"><?= btn(A('الرياضات', 'Sports'), 'champs.php', 'primary') ?></div>
  <?php else: ?>
    <?php if (isset($_GET['err'])): ?><div class="flash err" role="alert"><?= e($_GET['err'] === 'roster'
      ? A('أضف أسماء اللاعبين المطلوبة قبل الإرسال.', 'Please add the required player names before submitting.')
      : A('تحقق من الحقول وحاول مجدداً.', 'Check the fields and try again.')) ?></div><?php endif; ?>
    <form method="post" action="<?= e(url('actions/register.php')) ?>" enctype="multipart/form-data">
      <input type="hidden" name="type" value="<?= e($c['s']) ?>">
      <?php if ($isTeam): ?>
        <input type="hidden" name="f_team_min" value="<?= $tmin ?>">
        <div class="field"><label class="flabel" for="_team"><?= e(A('اسم الفريق', 'Team name')) ?> <span class="req">*</span></label>
          <input type="text" id="_team" name="f_team_name" maxlength="120" required></div>
        <div class="field"><label class="flabel" for="_club"><?= e(A('النادي أو الجهة', 'Club or organisation')) ?> <span class="opt">(<?= e(A('اختياري','optional')) ?>)</span></label>
          <input type="text" id="_club" name="f_club" maxlength="120"></div>
        <h2 class="sec-h reg-sub"><?= e(A('كابتن الفريق', 'Team captain')) ?></h2>
      <?php endif; ?>
      <div class="field"><label class="flabel" for="_name"><?= e($isTeam ? A('اسم الكابتن', 'Captain name') : A('الاسم الكامل', 'Full name')) ?> <span class="req">*</span></label><input type="text" id="_name" name="_name" maxlength="150" required></div>
      <div class="frow">
        <div class="field"><label class="flabel" for="_phone"><?= e(A('الهاتف', 'Phone')) ?> <span class="req">*</span></label><input type="tel" id="_phone" name="_phone" dir="ltr" required></div>
        <div class="field"><label class="flabel" for="_email"><?= e(A('البريد الإلكتروني', 'Email')) ?> <span class="req">*</span></label><input type="email" id="_email" name="_email" dir="ltr" required></div>
      </div>
      <div class="field"><label class="flabel" for="_cat"><?= e(A('الفئة', 'Category')) ?> <span class="req">*</span></label>
        <select id="_cat" name="f_category" required><option value=""><?= e(A('اختر','Choose')) ?></option>
          <option><?= e(A('ناشئون','Juniors')) ?></option><option><?= e(A('كبار','Seniors')) ?></option><option><?= e(A('سيدات','Women')) ?></option></select></div>
      <?php if ($isTeam): ?>
        <h2 class="sec-h reg-sub"><?= e(A('قائمة اللاعبين', 'Squad list')) ?></h2>
        <p class="hint" style="margin:-4px 0 10px"><?= e(sprintf(A('من %d إلى %d لاعبين — الكابتن ضمن القائمة.', 'Between %d and %d players — the captain counts as one of them.'), $tmin, $tmax)) ?></p>
        <div class="pf-roster" id="pfRoster" data-min="<?= $tmin ?>" data-max="<?= $tmax ?>"
             data-label="<?= e(A('اسم اللاعب', 'Player name')) ?>"
             data-remove="<?= e(A('احذف اللاعب', 'Remove player')) ?>">
          <?php for ($r = 0; $r < $tmin; $r++): ?>
            <div class="field pf-player">
              <span class="pf-num" aria-hidden="true"><?= $r + 1 ?></span>
              <label class="sr-only" for="pl<?= $r ?>"><?= e(A('اسم اللاعب', 'Player name')) ?> <?= $r + 1 ?></label>
              <input type="text" id="pl<?= $r ?>" name="f_players[]" maxlength="120" required
                     placeholder="<?= e(A('اسم اللاعب', 'Player name')) ?> <?= $r + 1 ?>">
              <button type="button" class="pf-del" aria-label="<?= e(A('احذف اللاعب', 'Remove player')) ?>">✕</button>
            </div>
          <?php endfor; ?>
        </div>
        <button type="button" class="btn ghost sm" id="pfAdd" style="margin-bottom:14px">＋ <?= e(A('أضف لاعباً', 'Add player')) ?></button>
      <?php endif; ?>
      <div class="field"><label class="flabel" for="_iban"><?= e(A('شهادة الآيبان IBAN من البنك (لصرف الجوائز)', 'IBAN certificate from the bank (for prize payouts)')) ?> <span class="req">*</span></label><input type="file" id="_iban" name="f_iban" accept=".pdf,.jpg,.jpeg,.png" required><div class="hint">PDF / JPG / PNG — 8 MB</div></div>
      <div class="field"><label class="flabel" for="_id"><?= e(A('صورة الهوية', 'ID copy')) ?> <span class="opt">(<?= e(A('اختياري','optional')) ?>)</span></label><input type="file" id="_id" name="f_id" accept=".pdf,.jpg,.jpeg,.png"></div>
      <button class="btn gold block" type="submit"><?= e($isTeam ? A('سجّل الفريق', 'Register the team') : A('سجّل الآن', 'Register now')) ?></button>
    </form>
  <?php endif; ?>
</div></section>
<?php require __DIR__ . '/partials/footer.php'; ?>
