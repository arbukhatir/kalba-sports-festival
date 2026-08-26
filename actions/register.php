<?php
/* Handle a registration submission → applications table. */
require_once __DIR__ . '/../lib/db.php';
require_once __DIR__ . '/../lib/render.php';
require_once __DIR__ . '/../lib/security.php';

function back($to) { header('Location: ../' . $to); exit; }

guard_post('register.php', 'register', 8, 1800);

/* Bound on the server: the form's maxlength is only a hint to the browser. */
$type  = clean_text($_POST['type'] ?? '', 40);
$name  = clean_text($_POST['_name'] ?? '', 150);
$phone = clean_phone($_POST['_phone'] ?? '');
$email = clean_email($_POST['_email'] ?? '');
if ($type !== '' && !preg_match('/^[a-z0-9_-]{1,40}$/i', $type)) $type = '';

/* A sport entry came from pform.php?i=N and must go back there; only the
   portal forms belong on register.php, whose type picker does not know a
   sport slug and would silently discard the whole submission. */
$sportIdx = isset($_POST['_sport']) && $_POST['_sport'] !== '' ? (int) $_POST['_sport'] : null;
$isSport  = $sportIdx !== null && isset(content()['CHAMPS'][$sportIdx]);
$typeParam = $isSport
  ? 'pform.php?i=' . $sportIdx
  : 'register.php' . ($type !== '' ? '?type=' . rawurlencode($type) : '');
$sep = strpos($typeParam, '?') === false ? '?' : '&';
if ($name === '' || $phone === '') back($typeParam . $sep . 'err=1');
if (($_POST['_email'] ?? '') !== '' && $email === '') back($typeParam . $sep . 'err=1');

/* Team entries must carry a squad of at least the sport's minimum size. The
   count is validated here as well as in the browser, since the roster rows
   past the minimum are optional and can be left blank. */
if (isset($_POST['f_team_name'])) {
  $players = clean_list($_POST['f_players'] ?? [], 40, 120);
  /* The minimum comes from the sport definition. Reading it from the posted
     hidden field would let anyone enter a one-player football team. */
  $min = 1;
  foreach (content()['CHAMPS'] as $sport) {
    if ($sport['s'] === $type && !empty($sport['team']['min'])) { $min = (int) $sport['team']['min']; break; }
  }
  if (trim($_POST['f_team_name']) === '' || count($players) < $min) {
    back($typeParam . $sep . 'err=roster');
  }
  $_POST['f_players'] = $players;
}

/* collect the type-specific fields + any uploaded files */
$payload = [];
$payload = clean_payload($_POST);
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

/* The reference is generated before the insert. Writing a fixed 'TMP' into a
   NOT NULL UNIQUE column and rewriting it afterwards meant two submissions
   arriving together collided on the placeholder and the second one was lost. */
$prefix = strtoupper(substr(preg_replace('/[^A-Za-z]/', '', $type) ?: 'REG', 0, 4));
$ref = $prefix . '-' . strtoupper(bin2hex(random_bytes(3)));

try {
  db_insert(
    "INSERT INTO applications (ref, type, name, email, phone, payload, status) VALUES (?,?,?,?,?,?,'pending')",
    [$ref, $type, $name, $email !== '' ? $email : null, $phone, json_encode($payload, JSON_UNESCAPED_UNICODE)]
  );
  db_run("INSERT INTO audit_log (event, actor, detail) VALUES ('application.new', ?, ?)", [$name, $type . ' ' . $ref]);
  back($typeParam . $sep . 'ok=' . rawurlencode($ref));
} catch (Throwable $ex) {
  back($typeParam . $sep . 'err=db');
}
