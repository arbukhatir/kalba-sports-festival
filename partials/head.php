<?php
require_once __DIR__ . '/../lib/render.php';
if (!isset($PAGE_TITLE)) $PAGE_TITLE = 'مهرجان كلباء الرياضي 2026';
if (!isset($HERO))       $HERO = false;   // home sets true → nav overlays the hero
/* Every page sets its own $PAGE_DESC; this is the fallback for any that does not. */
if (!isset($PAGE_DESC)) $PAGE_DESC = A(
  'مهرجان كلباء الرياضي 2026 — 8 أيام و13 رياضة معتمدة على كورنيش كلباء، 6–13 نوفمبر 2026.',
  'Kalba Sports Festival 2026 — 8 days and 13 official sports on the Kalba Corniche, 6–13 November 2026.');
$L = lang();
?><!doctype html>
<html lang="<?= $L ?>" dir="<?= is_rtl() ? 'rtl' : 'ltr' ?>">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
<title><?= e($PAGE_TITLE) ?><?= (strpos($PAGE_TITLE, 'كلباء') !== false || strpos($PAGE_TITLE, 'Kalba') !== false) ? '' : ' — ' . A('مهرجان كلباء الرياضي 2026', 'Kalba Sports Festival 2026') ?></title>
<meta name="description" content="<?= e($PAGE_DESC) ?>">
<meta property="og:title" content="<?= e($PAGE_TITLE) ?>">
<meta property="og:description" content="<?= e($PAGE_DESC) ?>">
<meta property="og:type" content="website">
<meta property="og:locale" content="<?= $L === 'ar' ? 'ar_AE' : 'en_AE' ?>">
<meta http-equiv="Content-Security-Policy" content="default-src 'self'; base-uri 'self'; object-src 'none'; script-src 'self' 'unsafe-inline'; style-src 'self' 'unsafe-inline'; font-src 'self'; img-src 'self' data:; connect-src 'self'; form-action 'self'">
<meta name="referrer" content="strict-origin-when-cross-origin">
<meta name="theme-color" content="#0A2133">
<link rel="icon" type="image/png" href="assets/img/favicon.png">
<link rel="stylesheet" href="assets/style.css">
</head>
