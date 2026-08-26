<?php
require_once __DIR__ . '/lib/render.php';
require_once __DIR__ . '/lib/auth.php';
$u = require_view('award');
$PAGE_TITLE = A('واجهة المنظم', 'Organizer');
$acts = [];
try { $acts = db_all('SELECT * FROM activities ORDER BY id'); } catch (Throwable $ex) {}
require __DIR__ . '/partials/head.php';
require __DIR__ . '/partials/header.php';
echo page_head(A('واجهة المنظم', 'ORGANIZER'), A('منح النقاط', 'Award points'),
  A('امسح رمز الزائر وامنح نقاط النشاط.', 'Scan the visitor code and award activity points.'),
  ['actions' => btn(A('تسجيل الخروج', 'Log out'), 'actions/logout.php', 'ghost')]);
?>
<section class="container section" style="max-width:520px"><div class="panel">
  <?php if (isset($_GET['ok'])): ?><div class="flash ok"><?= e(A('مُنحت النقاط بنجاح.', 'Points awarded.')) ?></div>
  <?php elseif (isset($_GET['err'])): ?><div class="flash err"><?= e(A('رمز زائر غير صحيح أو خطأ.', 'Invalid visitor code or error.')) ?></div><?php endif; ?>
  <form method="post" action="<?= e(url('actions/award.php')) ?>">
      <?= csrf_field() ?>
    <div class="field"><label class="flabel" for="vc"><?= e(A('رمز الزائر', 'Visitor code')) ?> <span class="req">*</span></label><input type="text" id="vc" name="code" dir="ltr" required></div>
    <div class="field"><label class="flabel" for="ac"><?= e(A('النشاط', 'Activity')) ?> <span class="req">*</span></label>
      <select id="ac" name="activity" required><option value=""><?= e(A('اختر','Choose')) ?></option>
        <?php foreach ($acts as $a) echo '<option value="' . (int)$a['id'] . '">' . e(lang() === 'ar' ? $a['name_ar'] : $a['name_en']) . ' (+' . (int)$a['points'] . ')</option>'; ?>
      </select></div>
    <button class="btn gold block" type="submit"><?= e(A('منح النقاط', 'Award points')) ?></button>
  </form>
</div></section>
<?php require __DIR__ . '/partials/footer.php'; ?>
