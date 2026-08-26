<?php
require_once __DIR__ . '/../lib/db.php';
require_once __DIR__ . '/../lib/security.php';
/* Return to the page the visitor submitted from (the newsletter form lives in
   the footer of every page), falling back to the homepage. */
function back($flag) {
  $ref = $_SERVER['HTTP_REFERER'] ?? '';
  $to = 'index.php';
  if ($ref !== '') {
    $path = basename(parse_url($ref, PHP_URL_PATH) ?: '');
    if (preg_match('/^[a-z0-9_-]+\.php$/i', $path)) $to = $path;
    $q = parse_url($ref, PHP_URL_QUERY);
    parse_str($q ?: '', $qs); unset($qs['sub']);
    $qs['sub'] = $flag;
    $to .= '?' . http_build_query($qs);
  } else {
    $to .= '?sub=' . $flag;
  }
  header('Location: ../' . $to . '#nlEmail'); exit;
}
guard_post('index.php', 'subscribe', 5, 3600);
$email = clean_email($_POST['email'] ?? '');
if ($email === '') back('err');
try {
  db_run('INSERT IGNORE INTO subscribers (email) VALUES (?)', [$email]);
  back('ok');
} catch (Throwable $ex) {
  back('err');
}
