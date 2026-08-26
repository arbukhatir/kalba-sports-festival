<?php
require_once __DIR__ . '/../lib/db.php';
require_once __DIR__ . '/../lib/security.php';
function back($to) { header('Location: ../' . $to); exit; }
guard_post('join.php', 'join', 5, 600);
$name = clean_text($_POST['name'] ?? '', 120);
$age  = clean_text($_POST['age'] ?? '', 24);
/* a family pass covers the holder plus up to eight companions */
$family = max(0, min(8, (int)($_POST['family'] ?? 0)));
$consent = !empty($_POST['consent']);
if ($name === '' || $age === '' || !$consent) back('join.php?err=1');
try {
  $code = 'K' . strtoupper(substr(bin2hex(random_bytes(4)), 0, 6));
  $label = $family > 0 ? $age . ' +' . $family : $age;
  db_run('INSERT INTO visitors (code, name, age_group, points) VALUES (?,?,?,0)', [$code, $name, $label]);
  back('join.php?ok=' . rawurlencode($code));
} catch (Throwable $ex) {
  back('join.php?err=db');
}
