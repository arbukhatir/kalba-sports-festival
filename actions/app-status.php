<?php
require_once __DIR__ . '/../lib/auth.php';
require_once __DIR__ . '/../lib/security.php';
$u = current_user();
function back($to) { header('Location: ../' . $to); exit; }
if (!$u || !role_can($u['role'], 'admin')) back('gate.php');
if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !csrf_valid()) back('admin.php');
$id = (int) ($_POST['id'] ?? 0);
$status = $_POST['status'] ?? '';
if (!in_array($status, ['pending', 'accepted', 'rejected'], true) || $id <= 0) back('admin.php');
try {
  db_run('UPDATE applications SET status = ? WHERE id = ?', [$status, $id]);
  db_run('INSERT INTO audit_log (event, actor, detail) VALUES (\'app.status\', ?, ?)', [$u['username'], '#' . $id . ' → ' . $status]);
} catch (Throwable $ex) {}
back('admin.php');
