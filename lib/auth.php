<?php
/* Session-based operator auth against the admin_users table. */
require_once __DIR__ . '/db.php';

function auth_start() {
  /* one hardened session for the whole site: httponly, samesite, secure on https */
  require_once __DIR__ . '/security.php';
  sec_session();
}

function current_user() {
  auth_start();
  return $_SESSION['ops'] ?? null;
}

/* Roles → which admin tabs/tools they may use (mirrors the old access table). */
function role_can($role, $view) {
  $map = [
    /* 'admin' is the applications panel and the registration export, which
       carry every applicant's name, phone and email. A scores account needs
       neither, so it no longer gets them. */
    'admin'     => ['admin' => 1, 'award' => 1, 'screen' => 1, 'results' => 1],
    'organizer' => ['award' => 1, 'screen' => 1],
    'results'   => ['results' => 1, 'screen' => 1],
  ];
  return !empty($map[$role][$view]);
}

/* A guard can run from a page at the web root or from an endpoint inside
   actions/. A bare relative redirect resolves against the caller's folder, so
   a refusal inside actions/ used to land on actions/index.php, which does not
   exist. This puts the redirect back at the root either way. */
function auth_back($page) {
  $inActions = basename(dirname($_SERVER['SCRIPT_NAME'] ?? '')) === 'actions';
  header('Location: ' . ($inActions ? '../' : '') . url($page));
  exit;
}

/* Guard a page: redirect to the gate if not logged in / not allowed. */
function require_view($view) {
  $u = current_user();
  if (!$u) auth_back('gate.php');
  if (!role_can($u['role'], $view)) auth_back('index.php');
  return $u;
}

function try_login($username, $password) {
  $row = db_one('SELECT * FROM admin_users WHERE username = ?', [$username]);
  if (!$row || !password_verify($password, $row['pass_hash'])) return false;
  auth_start();
  /* a new id on privilege change, so a session fixed before login is useless */
  session_regenerate_id(true);
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
