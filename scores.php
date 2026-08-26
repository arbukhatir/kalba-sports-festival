<?php
/* =============================================================================
   Score entry — the writer the results pipeline was missing.

   Everything under results.php is derived from the `matches` table, and until
   now nothing wrote to it, so the standings could only ever render empty.
   This is the control-room screen: one sport at a time, add a fixture, set a
   score, mark it live or final.

   A scoped account (admin_users.sport) may only touch its own sport.
   ============================================================================= */
require_once __DIR__ . '/lib/render.php';
require_once __DIR__ . '/lib/auth.php';
$u = require_view('results');

$C = content(); $CHAMPS = $C['CHAMPS'];

/* A scoped operator is pinned to one sport; everyone else picks. */
$pinned = !empty($u['sport']) ? $u['sport'] : null;
$allowed = [];
foreach ($CHAMPS as $i => $c) {
  if ($pinned === null || $c['s'] === $pinned) $allowed[$c['s']] = ['i' => $i, 'c' => $c];
}
$slug = $_GET['s'] ?? ($pinned ?: ($CHAMPS[0]['s'] ?? ''));
if (!isset($allowed[$slug])) $slug = array_key_first($allowed) ?: '';
$sport = $slug !== '' ? $allowed[$slug]['c'] : null;

$rows = []; $dbError = false;
if ($slug !== '') {
  try { $rows = db_all('SELECT * FROM matches WHERE sport = ? ORDER BY day, id', [$slug]); }
  catch (Throwable $ex) { $dbError = true; }
}

/* The days this sport actually competes, straight from its fixture grid. */
$days = [];
if ($sport) foreach ($sport['sch'] as $x) $days[$x[0]] = fest_day_label($x[0]);

$PAGE_TITLE = A('إدخال النتائج', 'Score entry');
$PAGE_DESC  = A('شاشة غرفة التحكم لإدخال نتائج المباريات.', 'The control-room screen for entering match results.');
require __DIR__ . '/partials/head.php';
require __DIR__ . '/partials/header.php';
echo page_head(A('غرفة التحكم', 'CONTROL ROOM'), A('إدخال النتائج', 'Score entry'),
  A('أضف مباراة، ثم حدّث نتيجتها وحالتها. الترتيب في صفحة النتائج يُحتسب من هنا مباشرة.',
    'Add a fixture, then update its score and status. The standings on the results page are computed from this.'), []);
?>
<section class="container section" style="max-width:900px">

  <?php if (isset($_GET['ok'])): ?>
    <div class="flash ok" role="status"><?= e(A('تم الحفظ.', 'Saved.')) ?></div>
  <?php elseif (isset($_GET['err'])): ?>
    <div class="flash err" role="alert"><?= e($_GET['err'] === 'scope'
      ? A('هذا الحساب مخصص لرياضة أخرى.', 'This account is scoped to a different sport.')
      : A('تعذّر الحفظ — راجع الحقول.', 'Could not save — check the fields.')) ?></div>
  <?php endif; ?>

  <?php if ($dbError): ?>
    <div class="panel" style="text-align:center"><div class="be"><?= icon('shield') ?></div>
      <h2 class="sec-h" style="margin-top:0"><?= e(A('قاعدة البيانات غير متصلة', 'The database is not connected')) ?></h2>
      <p class="muted"><?= e(A('أنشئ config.php واستورد sql/schema.sql، ثم أعد تحميل الصفحة.', 'Create config.php and import sql/schema.sql, then reload.')) ?></p>
    </div>
  <?php endif; ?>

  <?php if ($pinned === null): ?>
    <div class="sc-chips" style="margin-bottom:18px">
      <?php foreach ($allowed as $s => $a): ?>
        <a class="sc-chip<?= $s === $slug ? ' on' : '' ?>" href="<?= e(url('scores.php?s=' . rawurlencode($s))) ?>">
          <?= $a['c']['ic'] ?> <?= e(champ_name($a['c'])) ?>
        </a>
      <?php endforeach; ?>
    </div>
  <?php else: ?>
    <p class="hint"><?= e(sprintf(A('حسابك مخصص لرياضة %s.', 'Your account is scoped to %s.'), champ_name($sport))) ?></p>
  <?php endif; ?>

  <?php if ($sport): ?>
    <div class="panel">
      <h2 class="sec-h" style="margin-top:0"><?= e(A('أضف مباراة', 'Add a fixture')) ?> — <?= e(champ_name($sport)) ?></h2>
      <form method="post" action="<?= e(url('actions/score.php')) ?>" class="sc-form">
        <?= csrf_field() ?>
        <input type="hidden" name="do" value="add">
        <input type="hidden" name="sport" value="<?= e($slug) ?>">
        <div class="frow">
          <div class="field"><label class="flabel" for="sa"><?= e(A('الفريق الأول', 'Side A')) ?> <span class="req">*</span></label>
            <input type="text" id="sa" name="side_a" maxlength="120" required></div>
          <div class="field"><label class="flabel" for="sb"><?= e(A('الفريق الثاني', 'Side B')) ?> <span class="req">*</span></label>
            <input type="text" id="sb" name="side_b" maxlength="120" required></div>
          <div class="field" style="max-width:170px"><label class="flabel" for="sd"><?= e(A('اليوم', 'Day')) ?></label>
            <select id="sd" name="day">
              <?php foreach ($days as $d => $label): ?><option value="<?= e($d) ?>"><?= e($label) ?></option><?php endforeach; ?>
            </select></div>
        </div>
        <button class="btn gold" type="submit"><?= e(A('أضف المباراة', 'Add fixture')) ?></button>
      </form>
    </div>

    <h2 class="sec-title"><?= e(A('مباريات هذه البطولة', 'Fixtures in this championship')) ?>
      <span class="sc-daycount"><?= count($rows) ?></span></h2>

    <?php if (!$rows && !$dbError): ?>
      <div class="sc-empty">
        <?= icon('clipboard') ?>
        <p><?= e(A('لا توجد مباريات بعد — أضف أول مباراة من النموذج أعلاه.', 'No fixtures yet — add the first one above.')) ?></p>
      </div>
    <?php endif; ?>

    <?php foreach ($rows as $r): ?>
      <form method="post" action="<?= e(url('actions/score.php')) ?>" class="se-row">
        <?= csrf_field() ?>
        <input type="hidden" name="do" value="save">
        <input type="hidden" name="id" value="<?= (int)$r['id'] ?>">
        <input type="hidden" name="sport" value="<?= e($slug) ?>">
        <span class="se-day"><?= e(fest_day_label($r['day'])) ?></span>
        <span class="se-team"><?= e($r['side_a_ar'] ?: $r['side_a_en']) ?></span>
        <label class="sr-only" for="a<?= (int)$r['id'] ?>"><?= e(A('نتيجة الأول', 'Score A')) ?></label>
        <input class="se-score" type="number" min="0" max="999" id="a<?= (int)$r['id'] ?>" name="score_a"
               value="<?= $r['score_a'] === null ? '' : (int)$r['score_a'] ?>" placeholder="–">
        <span class="se-vs">:</span>
        <label class="sr-only" for="b<?= (int)$r['id'] ?>"><?= e(A('نتيجة الثاني', 'Score B')) ?></label>
        <input class="se-score" type="number" min="0" max="999" id="b<?= (int)$r['id'] ?>" name="score_b"
               value="<?= $r['score_b'] === null ? '' : (int)$r['score_b'] ?>" placeholder="–">
        <span class="se-team"><?= e($r['side_b_ar'] ?: $r['side_b_en']) ?></span>
        <label class="sr-only" for="st<?= (int)$r['id'] ?>"><?= e(A('الحالة', 'Status')) ?></label>
        <select class="se-st" id="st<?= (int)$r['id'] ?>" name="status">
          <?php foreach (['upcoming' => A('قادمة','Upcoming'), 'live' => A('مباشر','Live'), 'finished' => A('انتهت','Final')] as $k => $lbl): ?>
            <option value="<?= $k ?>"<?= $r['status'] === $k ? ' selected' : '' ?>><?= e($lbl) ?></option>
          <?php endforeach; ?>
        </select>
        <button class="btn primary sm" type="submit"><?= e(A('حفظ', 'Save')) ?></button>
        <button class="se-del" type="submit" name="do" value="delete"
                aria-label="<?= e(A('احذف المباراة', 'Delete fixture')) ?>"
                onclick="return confirm('<?= e(A('حذف هذه المباراة؟', 'Delete this fixture?')) ?>')"><?= icon('close') ?></button>
      </form>
    <?php endforeach; ?>

    <p class="hint" style="margin-top:16px">
      <?= e(A('تُحتسب النقاط من المباريات المنتهية فقط: فوز 3، تعادل 1.', 'Only finished fixtures count: win 3, draw 1.')) ?>
      <a href="<?= e(url('results.php?t=tables')) ?>"><?= e(A('اعرض جدول الترتيب', 'View the standings')) ?></a>
    </p>
  <?php endif; ?>
</section>
<?php require __DIR__ . '/partials/footer.php'; ?>
