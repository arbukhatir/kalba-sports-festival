<?php
require_once __DIR__ . '/../lib/auth.php';
require_once __DIR__ . '/../lib/security.php';
$u = current_user();
function back($to) { header('Location: ../' . $to); exit; }
if (!$u || !role_can($u['role'], 'award')) back('gate.php');
guard_post('award.php', 'award', 120, 600);
$code = trim($_POST['code'] ?? '');
$aid = (int) ($_POST['activity'] ?? 0);
if ($code === '' || $aid <= 0) back('award.php?err=1');
try {
  $v = db_one('SELECT id FROM visitors WHERE code = ?', [$code]);
  $a = db_one('SELECT points, name_en FROM activities WHERE id = ?', [$aid]);
  if (!$v || !$a) back('award.php?err=1');
  db_run('UPDATE visitors SET points = points + ? WHERE id = ?', [(int)$a['points'], $v['id']]);
  db_run('INSERT INTO audit_log (event, actor, detail) VALUES (\'points.award\', ?, ?)', [$u['username'], $code . ' +' . (int)$a['points']]);
  back('award.php?ok=1');
} catch (Throwable $ex) { back('award.php?err=1'); }
