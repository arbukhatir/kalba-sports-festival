<?php
require_once __DIR__ . '/../lib/auth.php';
require_once __DIR__ . '/../lib/security.php';
function back($to) { header('Location: ../' . $to); exit; }
guard_post('gate.php', 'login', 5, 900);
$user = trim($_POST['username'] ?? '');
$pass = (string) ($_POST['password'] ?? '');
try {
  if ($user !== '' && try_login($user, $pass)) back('admin.php');
} catch (Throwable $ex) { /* fall through to error */ }
back('gate.php?err=1');
