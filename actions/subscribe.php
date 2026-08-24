<?php
require_once __DIR__ . '/../lib/db.php';
function back($to) { header('Location: ../' . $to); exit; }
if ($_SERVER['REQUEST_METHOD'] !== 'POST') back('index.php');
$email = trim($_POST['email'] ?? '');
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) back('index.php?sub=err');
try {
  db_run('INSERT IGNORE INTO subscribers (email) VALUES (?)', [$email]);
  back('index.php?sub=ok');
} catch (Throwable $ex) {
  back('index.php?sub=err');
}
