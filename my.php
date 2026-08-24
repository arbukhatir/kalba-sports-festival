<?php
require_once __DIR__ . '/lib/render.php';
$code = trim($_GET['code'] ?? '');
$v = null;
if ($code !== '') { try { $v = db_one('SELECT * FROM visitors WHERE code = ?', [$code]); } catch (Throwable $ex) {} }
$PAGE_TITLE = A('بطاقتي', 'My Pass');
require __DIR__ . '/partials/head.php';
require __DIR__ . '/partials/header.php';
echo page_head(A('بطاقة الزائر', 'VISITOR PASS'), A('بطاقتي', 'My pass'),
  A('أدخل رمز تصريحك لعرض نقاطك.', 'Enter your pass code to see your points.'), []);
?>
<section class="container section" style="max-width:520px"><div class="panel">
  <?php if ($v): ?>
    <div class="vcard"><div class="vh">★ <?= e($v['name']) ?></div>
      <div class="vstats"><div class="vstat"><div class="n"><?= (int)$v['points'] ?></div><div class="l"><?= e(A('نقطة', 'points')) ?></div></div>
        <div class="vstat"><div class="n" dir="ltr"><?= e($v['code']) ?></div><div class="l"><?= e(A('رمز البطاقة', 'Pass code')) ?></div></div></div></div>
  <?php else: ?>
    <?php if ($code !== ''): ?><div class="flash err"><?= e(A('لم نجد بطاقة بهذا الرمز.', 'No pass found for that code.')) ?></div><?php endif; ?>
    <form method="get" action="my.php">
      <div class="field"><label class="flabel" for="mc"><?= e(A('رمز البطاقة', 'Pass code')) ?></label><input type="text" id="mc" name="code" dir="ltr" required></div>
      <button class="btn primary block" type="submit"><?= e(A('عرض بطاقتي', 'Show my pass')) ?></button>
    </form>
    <p class="hint"><?= e(A('لا تملك بطاقة؟', 'No pass yet?')) ?> <a href="<?= e(url('join.php')) ?>"><?= e(A('أنشئ واحدة مجاناً', 'Create one free')) ?></a></p>
  <?php endif; ?>
</div></section>
<?php require __DIR__ . '/partials/footer.php'; ?>
