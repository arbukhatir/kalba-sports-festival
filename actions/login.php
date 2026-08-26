<?php
require_once __DIR__ . '/../lib/auth.php';
require_once __DIR__ . '/../lib/security.php';
function back($to) { header('Location: ../' . $to); exit; }
guard_post('gate.php', 'login', 5, 900);
$user = trim($_POST['username'] ?? '');
$pass = (string) ($_POST['password'] ?? '');
try {
  if ($user !== '' && try_login($user, $pass)) {
    /* land on something this role can open: sending everyone to admin.php
       bounced organizers straight back out to the homepage */
    $u = current_user();
    if (role_can($u['role'], 'admin'))        back('admin.php');
    elseif (role_can($u['role'], 'results'))  back('scores.php');
    elseif (role_can($u['role'], 'award'))    back('award.php');
    back('index.php');
  }
} catch (Throwable $ex) { /* fall through to error */ }
back('gate.php?err=1');
