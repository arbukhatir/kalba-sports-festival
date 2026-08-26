<?php
/* =============================================================================
   Input validation, CSRF and rate limiting.

   Every public endpoint here writes to the database on an unauthenticated POST,
   so each one needs three things: proof the request came from our own form,
   a ceiling on how often it can be sent, and a bound on what it may contain.
   ============================================================================= */

require_once __DIR__ . '/i18n.php';

/* ---------------------------------------------------------------- sessions -
   A session is started for visitors too (CSRF needs somewhere to keep the
   token), so the cookie is locked down before it is ever issued. */
function sec_session() {
    if (session_status() !== PHP_SESSION_NONE) return;
    $https = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off')
          || (($_SERVER['HTTP_X_FORWARDED_PROTO'] ?? '') === 'https');
    session_set_cookie_params([
        'lifetime' => 0,
        'path'     => '/',
        'httponly' => true,          /* no script can read it */
        'secure'   => $https,        /* https only, once there is https */
        'samesite' => 'Lax',         /* blocks cross-site form posts */
    ]);
    session_name('kalbasid');
    session_start();
}

/* -------------------------------------------------------------------- CSRF -
   One token per session, compared in constant time. */
function csrf_token() {
    sec_session();
    if (empty($_SESSION['csrf'])) $_SESSION['csrf'] = bin2hex(random_bytes(32));
    return $_SESSION['csrf'];
}

function csrf_field() {
    return '<input type="hidden" name="_csrf" value="' . e(csrf_token()) . '">';
}

function csrf_valid() {
    sec_session();
    $sent = $_POST['_csrf'] ?? '';
    $held = $_SESSION['csrf'] ?? '';
    return is_string($sent) && $held !== '' && hash_equals($held, $sent);
}

/* ------------------------------------------------------------ rate limiting -
   A fixed window per caller and action, kept in files so it works before the
   database is configured and survives a restart. Keys are hashed, so a client
   address never lands on disk in the clear. */
function sec_store() {
    $dir = __DIR__ . '/../storage/ratelimit';
    if (!is_dir($dir)) @mkdir($dir, 0770, true);
    return $dir;
}

function sec_client() {
    /* Only trust a forwarded address when the app is told to; otherwise a
       header is enough to sidestep every limit below. */
    $cfg = function_exists('config') ? config() : [];
    if (!empty($cfg['trust_proxy']) && !empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        $parts = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
        return trim($parts[0]);
    }
    return $_SERVER['REMOTE_ADDR'] ?? 'cli';
}

/**
 * @return bool true when the request may proceed.
 */
function rate_ok($action, $max = 10, $window = 300) {
    $key  = hash('sha256', $action . '|' . sec_client());
    $file = sec_store() . '/' . $key . '.json';
    $now  = time();
    $hits = [];
    if (is_file($file)) {
        $raw = @file_get_contents($file);
        $hits = $raw ? (json_decode($raw, true) ?: []) : [];
    }
    /* drop everything that fell out of the window */
    $hits = array_values(array_filter($hits, function ($t) use ($now, $window) {
        return is_int($t) && $t > $now - $window;
    }));
    if (count($hits) >= $max) return false;
    $hits[] = $now;
    @file_put_contents($file, json_encode($hits), LOCK_EX);
    /* opportunistic sweep so the folder cannot grow without bound */
    if (random_int(1, 50) === 1) sec_sweep($window);
    return true;
}

function sec_sweep($window) {
    $dir = sec_store();
    foreach (glob($dir . '/*.json') ?: [] as $f) {
        if (@filemtime($f) < time() - max(3600, $window * 4)) @unlink($f);
    }
}

/* ------------------------------------------------------------- input bounds -
   Client-side maxlength is a hint, not a limit; these are the real ones. */
function clean_text($v, $max = 200) {
    if (!is_scalar($v)) return '';
    $v = (string) $v;
    /* strip control characters, keeping tab and newline */
    $v = preg_replace('/[\x00-\x08\x0B\x0C\x0E-\x1F\x7F]/u', '', $v);
    $v = trim($v);
    if (function_exists('mb_substr')) {
        if (mb_strlen($v, 'UTF-8') > $max) $v = mb_substr($v, 0, $max, 'UTF-8');
    } elseif (strlen($v) > $max * 4) {
        $v = substr($v, 0, $max * 4);
    }
    return $v;
}

function clean_email($v) {
    $v = clean_text($v, 190);
    return filter_var($v, FILTER_VALIDATE_EMAIL) ? $v : '';
}

function clean_phone($v) {
    $v = clean_text($v, 30);
    /* digits, spaces and the punctuation a real number carries */
    return preg_replace('/[^0-9+\-() ]/', '', $v);
}

/** Bound a submitted array: how many items, and how long each may be. */
function clean_list($v, $maxItems = 30, $maxLen = 120) {
    if (!is_array($v)) return [];
    $out = [];
    foreach ($v as $item) {
        if (count($out) >= $maxItems) break;
        if (is_array($item)) continue;
        $s = clean_text($item, $maxLen);
        if ($s !== '') $out[] = $s;
    }
    return $out;
}

/**
 * Collect the `f_` prefixed extra fields a form submits, with every value
 * bounded. Anything deeper than one array level is dropped.
 */
function clean_payload(array $post, $maxFields = 60, $maxLen = 500) {
    $out = [];
    foreach ($post as $k => $v) {
        if (strpos($k, 'f_') !== 0) continue;
        if (count($out) >= $maxFields) break;
        $key = clean_text(substr($k, 2), 40);
        if ($key === '') continue;
        $out[$key] = is_array($v) ? clean_list($v, 40, $maxLen) : clean_text($v, $maxLen);
    }
    return $out;
}

/* ------------------------------------------------------------------ guards -
   Used at the top of every public POST endpoint. $back is where a rejected
   request is sent, and it is always a path on this site. */
function guard_post($back, $action, $max = 10, $window = 300) {
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') { sec_redirect($back); }
    if (!csrf_valid())                          { sec_redirect($back . (strpos($back, '?') === false ? '?' : '&') . 'err=csrf'); }
    if (!rate_ok($action, $max, $window))       { sec_redirect($back . (strpos($back, '?') === false ? '?' : '&') . 'err=rate'); }
}

/** Redirect only to a path inside this site — never to a supplied URL. */
function sec_redirect($path) {
    $path = ltrim((string) $path, '/');
    if (preg_match('#^[a-z0-9_\-/]+\.php(\?[^\s]*)?$#i', $path) !== 1) $path = 'index.php';
    header('Location: ../' . $path);
    exit;
}
