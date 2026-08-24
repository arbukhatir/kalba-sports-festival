<?php
require_once __DIR__ . '/../lib/db.php';
function back($to) { header('Location: ../' . $to); exit; }
if ($_SERVER['REQUEST_METHOD'] !== 'POST') back('contact.php');
$name = trim($_POST['name'] ?? '');
$email = trim($_POST['email'] ?? '');
$body = trim($_POST['body'] ?? '');
if ($name === '' || $body === '') back('contact.php?err=1');
if ($email !== '' && !filter_var($email, FILTER_VALIDATE_EMAIL)) back('contact.php?err=1');
try {
  db_run('INSERT INTO messages (name, email, body) VALUES (?,?,?)', [$name, $email !== '' ? $email : null, $body]);
  back('contact.php?ok=1');
} catch (Throwable $ex) {
  back('contact.php?err=db');
}
