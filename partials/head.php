<?php
require_once __DIR__ . '/../lib/render.php';
if (!isset($PAGE_TITLE)) $PAGE_TITLE = 'مهرجان كلباء الرياضي 2026';
if (!isset($HERO))       $HERO = false;   // home sets true → nav overlays the hero
$L = lang();
?><!doctype html>
<html lang="<?= $L ?>" dir="<?= is_rtl() ? 'rtl' : 'ltr' ?>">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?= e($PAGE_TITLE) ?><?= (strpos($PAGE_TITLE, 'كلباء') !== false || strpos($PAGE_TITLE, 'Kalba') !== false) ? '' : ' — ' . A('مهرجان كلباء الرياضي 2026', 'Kalba Sports Festival 2026') ?></title>
<meta name="description" content="مهرجان كلباء الرياضي 2026 — 8 أيام و15 رياضة معتمدة على كورنيش كلباء، 6–13 نوفمبر 2026.">
<meta http-equiv="Content-Security-Policy" content="default-src 'self'; base-uri 'self'; object-src 'none'; script-src 'self' 'unsafe-inline'; style-src 'self' 'unsafe-inline' https://fonts.googleapis.com; font-src 'self' https://fonts.gstatic.com; img-src 'self' data:; connect-src 'self'; form-action 'self'">
<meta name="referrer" content="strict-origin-when-cross-origin">
<link rel="icon" href="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 32 32'%3E%3Crect width='32' height='32' rx='7' fill='%23050505'/%3E%3Cpath d='M16 6l2.9 6.3 6.9.7-5.2 4.6 1.5 6.8L16 20.9 9.9 24.4l1.5-6.8L6.2 13l6.9-.7z' fill='%231A715A'/%3E%3C/svg%3E">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Oswald:wght@500;700&family=Poppins:wght@300;400;600;700&family=Russo+One&family=Chakra+Petch:wght@500;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="assets/style.css">
</head>
