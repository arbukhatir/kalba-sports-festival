<?php
require_once __DIR__ . '/../lib/render.php';
if (!isset($PAGE_TITLE)) $PAGE_TITLE = 'مهرجان كلباء الرياضي 2026';
if (!isset($HERO))       $HERO = false;   // home sets true → nav overlays the hero
$L = lang();
?><!doctype html>
<html lang="<?= $L ?>" dir="<?= is_rtl() ? 'rtl' : 'ltr' ?>">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
<title><?= e($PAGE_TITLE) ?><?= (strpos($PAGE_TITLE, 'كلباء') !== false || strpos($PAGE_TITLE, 'Kalba') !== false) ? '' : ' — ' . A('مهرجان كلباء الرياضي 2026', 'Kalba Sports Festival 2026') ?></title>
<meta name="description" content="مهرجان كلباء الرياضي 2026 — 8 أيام و15 رياضة معتمدة على كورنيش كلباء، 6–13 نوفمبر 2026.">
<meta http-equiv="Content-Security-Policy" content="default-src 'self'; base-uri 'self'; object-src 'none'; script-src 'self' 'unsafe-inline'; style-src 'self' 'unsafe-inline'; font-src 'self'; img-src 'self' data:; connect-src 'self'; form-action 'self'">
<meta name="referrer" content="strict-origin-when-cross-origin">
<meta name="theme-color" content="#0A2133">
<link rel="icon" type="image/png" href="assets/img/favicon.png">
<link rel="stylesheet" href="assets/style.css">
</head>
