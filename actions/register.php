<?php
/* Handle a registration submission → applications table. */
require_once __DIR__ . '/../lib/db.php';

function back($to) { header('Location: ../' . $to); exit; }

if ($_SERVER['REQUEST_METHOD'] !== 'POST') back('register.php');

$type  = isset($_POST['type']) ? trim($_POST['type']) : '';
$name  = isset($_POST['_name']) ? trim($_POST['_name']) : '';
$phone = isset($_POST['_phone']) ? trim($_POST['_phone']) : '';
$email = isset($_POST['_email']) ? trim($_POST['_email']) : '';

$typeParam = 'register.php' . ($type !== '' ? '?type=' . rawurlencode($type) : '');
if ($name === '' || $phone === '') back($typeParam . (strpos($typeParam, '?') === false ? '?' : '&') . 'err=1');
if ($email !== '' && !filter_var($email, FILTER_VALIDATE_EMAIL)) back($typeParam . '&err=1');

/* Team entries must carry a squad of at least the sport's minimum size. The
   count is validated here as well as in the browser, since the roster rows
   past the minimum are optional and can be left blank. */
if (isset($_POST['f_team_name'])) {
  $players = isset($_POST['f_players']) && is_array($_POST['f_players'])
    ? array_values(array_filter(array_map('trim', $_POST['f_players']), 'strlen'))
    : [];
  $min = max(1, (int) ($_POST['f_team_min'] ?? 1));
  if (trim($_POST['f_team_name']) === '' || count($players) < $min) {
    $ref = $_SERVER['HTTP_REFERER'] ?? '';
    $path = basename(parse_url($ref, PHP_URL_PATH) ?: '') ?: 'register.php';
    parse_str(parse_url($ref, PHP_URL_QUERY) ?: '', $qs);
    unset($qs['ok'], $qs['err']); $qs['err'] = 'roster';
    back($path . '?' . http_build_query($qs));
  }
  $_POST['f_players'] = $players;
}

/* collect the type-specific fields + any uploaded files */
$payload = [];
foreach ($_POST as $k => $v) {
  if (strpos($k, 'f_') === 0) $payload[substr($k, 2)] = is_array($v) ? array_values($v) : $v;
}
if (!empty($_FILES)) {
  $dir = __DIR__ . '/../uploads';
  if (!is_dir($dir)) @mkdir($dir, 0775, true);
  foreach ($_FILES as $k => $file) {
    if (($file['error'] ?? UPLOAD_ERR_NO_FILE) !== UPLOAD_ERR_OK) continue;
    $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
    if (!in_array($ext, ['pdf', 'jpg', 'jpeg', 'png'], true)) continue;
    if ($file['size'] > 8 * 1024 * 1024) continue;
    $safe = uniqid('up_', true) . '.' . $ext;
    if (move_uploaded_file($file['tmp_name'], $dir . '/' . $safe)) {
      $payload[substr($k, 2)] = 'uploads/' . $safe;
    }
  }
}

try {
  $id = db_insert(
    'INSERT INTO applications (ref, type, name, email, phone, payload, status) VALUES (?,?,?,?,?,?,\'pending\')',
    ['TMP', $type, $name, $email !== '' ? $email : null, $phone, json_encode($payload, JSON_UNESCAPED_UNICODE)]
  );
  $ref = strtoupper(substr(preg_replace('/[^A-Za-z]/', '', $type) ?: 'REG', 0, 4)) . '-' . str_pad((string)$id, 5, '0', STR_PAD_LEFT);
  db_run('UPDATE applications SET ref = ? WHERE id = ?', [$ref, $id]);
  db_run('INSERT INTO audit_log (event, actor, detail) VALUES (\'application.new\', ?, ?)', [$name, $type . ' #' . $id]);
  back($typeParam . '&ok=' . rawurlencode($ref));
} catch (Throwable $ex) {
  back($typeParam . (strpos($typeParam, '?') === false ? '?' : '&') . 'err=db');
}
