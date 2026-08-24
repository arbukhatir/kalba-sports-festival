<?php
/* Session-based operator auth against the admin_users table. */
require_once __DIR__ . '/db.php';

function auth_start() {
  if (session_status() === PHP_SESSION_NONE) {
    session_name('kalbaops');
    session_start();
  }
}

function current_user() {
  auth_start();
  return $_SESSION['ops'] ?? null;
}

/* Roles → which admin tabs/tools they may use (mirrors the old access table). */
function role_can($role, $view) {
  $map = [
    'admin'     => ['admin' => 1, 'award' => 1, 'screen' => 1, 'results' => 1],
    'organizer' => ['award' => 1, 'screen' => 1],
    'results'   => ['admin' => 1, 'results' => 1, 'screen' => 1],
  ];
  return !empty($map[$role][$view]);
}

/* Guard a page: redirect to the gate if not logged in / not allowed. */
function require_view($view) {
  $u = current_user();
  if (!$u) { header('Location: ' . url('gate.php')); exit; }
  if (!role_can($u['role'], $view)) { header('Location: ' . url('index.php')); exit; }
  return $u;
}

function try_login($username, $password) {
  $row = db_one('SELECT * FROM admin_users WHERE username = ?', [$username]);
  if (!$row || !password_verify($password, $row['pass_hash'])) return false;
  auth_start();
  $_SESSION['ops'] = ['username' => $row['username'], 'role' => $row['role'], 'sport' => $row['sport']];
  db_run('INSERT INTO audit_log (event, actor, detail) VALUES (\'login.ok\', ?, ?)', [$row['username'], $row['role']]);
  return true;
}

function logout() {
  auth_start();
  $_SESSION = [];
  if (ini_get('session.use_cookies')) setcookie(session_name(), '', time() - 3600, '/');
  session_destroy();
}
