<?php
require_once __DIR__ . '/../lib/db.php';
require_once __DIR__ . '/../lib/security.php';
function back($to) { header('Location: ../' . $to); exit; }
guard_post('contact.php', 'contact', 5, 600);
$name  = clean_text($_POST['name'] ?? '', 120);
$email = clean_email($_POST['email'] ?? '');
$body  = clean_text($_POST['body'] ?? '', 2000);
if ($name === '' || $body === '') back('contact.php?err=1');
if (($_POST['email'] ?? '') !== '' && $email === '') back('contact.php?err=1');
try {
  db_run('INSERT INTO messages (name, email, body) VALUES (?,?,?)', [$name, $email !== '' ? $email : null, $body]);
  back('contact.php?ok=1');
} catch (Throwable $ex) {
  back('contact.php?err=db');
}
