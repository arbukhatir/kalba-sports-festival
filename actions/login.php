<?php
require_once __DIR__ . '/../lib/auth.php';
function back($to) { header('Location: ../' . $to); exit; }
if ($_SERVER['REQUEST_METHOD'] !== 'POST') back('gate.php');
$user = trim($_POST['username'] ?? '');
$pass = (string) ($_POST['password'] ?? '');
try {
  if ($user !== '' && try_login($user, $pass)) back('admin.php');
} catch (Throwable $ex) { /* fall through to error */ }
back('gate.php?err=1');
