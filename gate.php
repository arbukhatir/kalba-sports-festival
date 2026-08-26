<?php
require_once __DIR__ . '/lib/render.php';
require_once __DIR__ . '/lib/auth.php';
$u = current_user();
$PAGE_TITLE = A('تسجيل الدخول', 'Log in');
$PAGE_DESC = A('تسجيل دخول المشغّلين والمنظمين في مهرجان كلباء الرياضي 2026.', 'Operator and organiser log in for Kalba Sports Festival 2026.');
require __DIR__ . '/partials/head.php';
require __DIR__ . '/partials/header.php';
echo page_head(A('للمصرح لهم', 'STAFF'), A('تسجيل دخول المشغّلين', 'Operator log in'),
  A('للمصرح لهم فقط — تظهر أدواتك حسب دورك بعد الدخول.', 'Authorized staff only — your tools appear based on your role.'), []);
?>
<section class="container section" style="max-width:420px"><div class="panel">
  <?php if ($u): ?>
    <p><?= e(A('أنت مسجّل الدخول باسم', 'Logged in as')) ?> <b dir="ltr"><?= e($u['username']) ?></b> (<?= e($u['role']) ?>)</p>
    <div class="btn-row">
      <?php if (role_can($u['role'], 'admin')) echo btn(A('لوحة التحكم', 'Admin panel'), 'admin.php', 'primary'); ?>
      <?= btn(A('تسجيل الخروج', 'Log out'), 'actions/logout.php', 'ghost') ?>
    </div>
  <?php else: ?>
    <?php if (isset($_GET['err'])): ?><div class="flash err"><?= e(A('اسم المستخدم أو كلمة المرور غير صحيحة.', 'Wrong username or password.')) ?></div><?php endif; ?>
    <form method="post" action="<?= e(url('actions/login.php')) ?>">
      <div class="field"><label class="flabel" for="gu"><?= e(A('اسم المستخدم', 'Username')) ?></label><input type="text" id="gu" name="username" dir="ltr" autocomplete="username" required></div>
      <div class="field"><label class="flabel" for="gp"><?= e(A('كلمة المرور', 'Password')) ?></label><input type="password" id="gp" name="password" dir="ltr" autocomplete="current-password" required></div>
      <button class="btn primary block" type="submit"><?= e(A('تسجيل الدخول', 'Log in')) ?></button>
    </form>
  <?php endif; ?>
</div></section>
<?php require __DIR__ . '/partials/footer.php'; ?>
