<?php
/* Language + escaping helpers. Arabic is primary (RTL); English via ?lang=en,
   remembered in a cookie. No mbstring dependency (htmlspecialchars is byte-safe
   for UTF-8 escaping). */

function lang() {
  static $lang = null;
  if ($lang === null) {
    if (isset($_GET['lang']) && in_array($_GET['lang'], ['ar', 'en'], true)) {
      $lang = $_GET['lang'];
      setcookie('lang', $lang, time() + 31536000, '/');
    } elseif (isset($_COOKIE['lang']) && in_array($_COOKIE['lang'], ['ar', 'en'], true)) {
      $lang = $_COOKIE['lang'];
    } else {
      $lang = 'ar';
    }
  }
  return $lang;
}

function is_rtl() { return lang() === 'ar'; }

/* Escape for HTML output. */
function e($s) { return htmlspecialchars((string) $s, ENT_QUOTES, 'UTF-8'); }

/* Inline bilingual pick: A('عربي', 'English'). */
function A($ar, $en) { return lang() === 'ar' ? $ar : $en; }

/* Pick from a {ar,en} array (the shape used throughout data/content.php). */
function tx($o) {
  if (is_array($o)) return lang() === 'ar' ? ($o['ar'] ?? '') : ($o['en'] ?? ($o['ar'] ?? ''));
  return (string) $o;
}

/* Build a URL to another page preserving the current language. */
function url($path) {
  if (lang() === 'en') return $path . (strpos($path, '?') === false ? '?' : '&') . 'lang=en';
  return $path;
}

/* The whole content dataset, loaded once. */
function content() {
  static $c = null;
  if ($c === null) $c = require __DIR__ . '/../data/content.php';
  return $c;
}
