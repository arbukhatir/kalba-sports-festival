<?php
require_once __DIR__ . '/lib/render.php';
require_once __DIR__ . '/lib/auth.php';
$u = require_view('admin');
$C = content();
$PAGE_TITLE = A('لوحة التحكم', 'Admin');

$stats = ['apps' => 0, 'pending' => 0, 'accepted' => 0, 'visitors' => 0, 'messages' => 0, 'subs' => 0];
$apps = []; $audit = []; $messages = []; $subs = []; $dbError = false;
try {
  $stats['apps']     = (int) (db_one('SELECT COUNT(*) n FROM applications')['n'] ?? 0);
  $stats['pending']  = (int) (db_one("SELECT COUNT(*) n FROM applications WHERE status='pending'")['n'] ?? 0);
  $stats['accepted'] = (int) (db_one("SELECT COUNT(*) n FROM applications WHERE status='accepted'")['n'] ?? 0);
  $stats['visitors'] = (int) (db_one('SELECT COUNT(*) n FROM visitors')['n'] ?? 0);
  $stats['messages'] = (int) (db_one('SELECT COUNT(*) n FROM messages')['n'] ?? 0);
  $stats['subs']     = (int) (db_one('SELECT COUNT(*) n FROM subscribers')['n'] ?? 0);
  $apps  = db_all('SELECT * FROM applications ORDER BY id DESC LIMIT 20');
  $audit = db_all('SELECT * FROM audit_log ORDER BY id DESC LIMIT 10');
  /* these two were counted on the dashboard but never readable: every
     enquiry sent through the contact form was effectively write-only */
  $messages = db_all('SELECT * FROM messages ORDER BY id DESC LIMIT 25');
  $subs     = db_all('SELECT email, created_at FROM subscribers ORDER BY id DESC LIMIT 50');
} catch (Throwable $ex) { $dbError = true; }

require __DIR__ . '/partials/head.php';
require __DIR__ . '/partials/header.php';
echo page_head(A('غرفة التحكم', 'CONTROL ROOM'), A('لوحة التحكم', 'Admin panel'),
  A('مرحباً', 'Welcome') . ' ' . e($u['username']) . ' · ' . e($u['role']),
  ['actions' => btn(A('تسجيل الخروج', 'Log out'), 'actions/logout.php', 'ghost')]);
?>
<section class="container section">
  <?php if ($dbError): ?>
    <div class="flash warn"><?= e(A('قاعدة البيانات غير مهيأة بعد — استورد sql/schema.sql وشغّل tools/seed.php ثم اضبط config.php.', 'Database not set up yet — import sql/schema.sql, run tools/seed.php, and set config.php.')) ?></div>
  <?php endif; ?>
  <div class="stat-grid">
    <?php foreach ([['apps','الطلبات','Applications'],['pending','قيد المراجعة','Pending'],['accepted','مقبولة','Accepted'],['visitors','الزوار','Visitors'],['messages','الرسائل','Messages'],['subs','المشتركون','Subscribers']] as $s): ?>
      <div class="stat<?= $s[0] === 'pending' ? ' lead' : '' ?>"><div class="n"><?= (int) $stats[$s[0]] ?></div><div class="l"><?= e(A($s[1], $s[2])) ?></div></div>
    <?php endforeach; ?>
  </div>

      <div class="btn-row" style="margin-bottom:14px">
        <?= btn(A('إدخال النتائج', 'Score entry'), 'scores.php', 'gold') ?>
        <?= btn(A('منح النقاط', 'Award points'), 'award.php', 'ghost') ?>
        <?= btn(A('شاشة العرض', 'Big screen'), 'screen.php', 'ghost') ?>
      </div>
      <div class="adm-export">
        <span class="hint"><?= e(A('تصدير قوائم المسجلين للجنة المنظمة:', 'Export the registration lists for the committee:')) ?></span>
        <a class="btn ghost sm" href="<?= e(url('actions/export.php')) ?>"><?= icon('clipboard') ?> <?= e(A('كل الطلبات (CSV)', 'All registrations (CSV)')) ?></a>
        <?php foreach ($C['CHAMPS'] as $ec): ?>
          <a class="btn ghost sm" href="<?= e(url('actions/export.php?type=' . rawurlencode($ec['s']))) ?>"><?= e(champ_name($ec)) ?></a>
        <?php endforeach; ?>
      </div>
  <div class="panel"><h2 class="sec-h" style="margin-top:0"><?= e(A('أحدث الطلبات', 'Latest applications')) ?></h2>
    <?php if (!$apps): ?><p class="muted"><?= e(A('لا طلبات بعد.', 'No applications yet.')) ?></p><?php else: ?>
    <div style="overflow-x:auto"><table class="t">
      <tr><th>#</th><th><?= e(A('النوع','Type')) ?></th><th><?= e(A('الاسم','Name')) ?></th><th><?= e(A('الحالة','Status')) ?></th><th></th></tr>
      <?php foreach ($apps as $a): ?>
        <tr>
          <td dir="ltr"><?= e($a['ref']) ?></td><td><?= e($a['type']) ?></td><td><?= e($a['name']) ?></td>
          <td><span class="badge <?= e($a['status']) ?>"><?= e($a['status']) ?></span></td>
          <td class="btn-row" style="margin:0">
            <?php foreach ([['accepted','قبول','Accept','ok'],['pending','تعليق','Hold','warn'],['rejected','رفض','Reject','danger']] as $b): ?>
              <form method="post" action="<?= e(url('actions/app-status.php')) ?>" style="display:inline">
      <?= csrf_field() ?>
                <input type="hidden" name="id" value="<?= (int) $a['id'] ?>"><input type="hidden" name="status" value="<?= $b[0] ?>">
                <button class="btn sm <?= $b[3] ?>" type="submit"><?= e(A($b[1], $b[2])) ?></button>
              </form>
            <?php endforeach; ?>
          </td>
        </tr>
      <?php endforeach; ?>
    </table></div>
    <?php endif; ?>
  </div>

  <div class="panel">
    <h2 class="sec-h" style="margin-top:0"><?= icon('mail') ?> <?= e(A('رسائل التواصل', 'Contact messages')) ?>
      <span class="se-count"><?= count($messages) ?></span></h2>
    <?php if (!$messages): ?>
      <p class="muted"><?= e(A('لا رسائل بعد.', 'No messages yet.')) ?></p>
    <?php else: ?>
      <div class="tbl-wrap"><table class="t">
        <thead><tr>
          <th scope="col"><?= e(A('المرسل', 'From')) ?></th>
          <th scope="col"><?= e(A('الرسالة', 'Message')) ?></th>
          <th scope="col"><?= e(A('التاريخ', 'Received')) ?></th>
        </tr></thead>
        <tbody>
          <?php foreach ($messages as $m): ?>
            <tr>
              <td>
                <b><?= e($m['name']) ?></b>
                <?php if (!empty($m['email'])): ?><br><a href="mailto:<?= e($m['email']) ?>" dir="ltr"><?= e($m['email']) ?></a><?php endif; ?>
              </td>
              <td><?= nl2br(e($m['body'])) ?></td>
              <td dir="ltr"><?= e($m['created_at'] ?? '') ?></td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table></div>
    <?php endif; ?>
  </div>

  <div class="panel">
    <h2 class="sec-h" style="margin-top:0"><?= icon('users') ?> <?= e(A('مشتركو النشرة', 'Newsletter subscribers')) ?>
      <span class="se-count"><?= count($subs) ?></span></h2>
    <?php if (!$subs): ?>
      <p class="muted"><?= e(A('لا مشتركين بعد.', 'No subscribers yet.')) ?></p>
    <?php else: ?>
      <div class="sub-list">
        <?php foreach ($subs as $sb): ?>
          <a class="sub-chip" href="mailto:<?= e($sb['email']) ?>" dir="ltr"><?= e($sb['email']) ?></a>
        <?php endforeach; ?>
      </div>
      <div class="btn-row">
        <?= btn(A('تصدير المشتركين (CSV)', 'Export subscribers (CSV)'), 'actions/export.php?set=subscribers', 'ghost sm') ?>
        <?= btn(A('تصدير الرسائل (CSV)', 'Export messages (CSV)'), 'actions/export.php?set=messages', 'ghost sm') ?>
      </div>
    <?php endif; ?>
  </div>

  <?php if ($audit): ?>
  <div class="panel"><h2 class="sec-h" style="margin-top:0"><?= icon('shield') ?> <?= e(A('سجل التدقيق', 'Audit log')) ?></h2>
    <?php foreach ($audit as $x): ?>
      <div class="sched-row" style="padding:7px 0;border-top:1px dashed var(--line)"><strong><?= e($x['event']) ?></strong>
        <?php if ($x['detail']): ?><span class="muted"><?= e($x['detail']) ?></span><?php endif; ?>
        <small class="muted" dir="ltr"><?= e(($x['actor'] ? $x['actor'] . ' · ' : '') . $x['created_at']) ?></small></div>
    <?php endforeach; ?>
  </div>
  <?php endif; ?>
</section>
<?php require __DIR__ . '/partials/footer.php'; ?>
