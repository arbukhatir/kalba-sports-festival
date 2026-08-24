<?php
require_once __DIR__ . '/../lib/db.php';
function back($to) { header('Location: ../' . $to); exit; }
if ($_SERVER['REQUEST_METHOD'] !== 'POST') back('join.php');
$name = trim($_POST['name'] ?? '');
$age = trim($_POST['age'] ?? '');
$consent = !empty($_POST['consent']);
if ($name === '' || $age === '' || !$consent) back('join.php?err=1');
try {
  $code = 'K' . strtoupper(substr(bin2hex(random_bytes(4)), 0, 6));
  db_run('INSERT INTO visitors (code, name, age_group, points) VALUES (?,?,?,0)', [$code, $name, $age]);
  back('join.php?ok=' . rawurlencode($code));
} catch (Throwable $ex) {
  back('join.php?err=db');
}
