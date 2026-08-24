<?php
if (!isset($PAGE_TITLE)) $PAGE_TITLE = 'مهرجان كلباء الرياضي 2026';
if (!isset($BOOT_VIEW))  $BOOT_VIEW  = 'home';
if (!isset($BOOT_ARG))   $BOOT_ARG   = null;
?><!doctype html>
<html lang="ar" dir="rtl">
<head>
<!-- Kalba Sports Festival 2026 — single-file client-side application. -->
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?= htmlspecialchars($PAGE_TITLE, ENT_QUOTES, "UTF-8") ?></title>
<meta name="description" content="مهرجان كلباء الرياضي 2026 — 8 أيام و15 رياضة معتمدة وفعاليات مجتمعية على كورنيش كلباء، من 6 إلى 13 نوفمبر 2026. التسجيل، الجدول، النتائج ولوحة المتصدرين.">
<!-- Baseline CSP via meta. GitHub Pages serves no HTTP headers, so HSTS,
     X-Frame-Options and frame-ancestors (ignored in meta) are not available
     here; those need a header-serving host. script-src keeps 'unsafe-inline'
     because the app is one file of inline script + inline handlers — until that
     is extracted, this CSP still hardens object/base-uri, pins connect/img/font
     origins, and blocks plugin/base-tag abuse. -->
<meta http-equiv="Content-Security-Policy" content="default-src 'self'; base-uri 'self'; object-src 'none'; script-src 'self' 'unsafe-inline'; style-src 'self' 'unsafe-inline' https://fonts.googleapis.com; font-src 'self' https://fonts.gstatic.com; img-src 'self' data:; connect-src 'self'; form-action 'self'">
<meta name="referrer" content="strict-origin-when-cross-origin">
<!-- inline SVG favicon: the festival's gold star on navy, no extra request -->
<link rel="icon" href="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 32 32'%3E%3Crect width='32' height='32' rx='7' fill='%23050505'/%3E%3Cpath d='M16 6l2.9 6.3 6.9.7-5.2 4.6 1.5 6.8L16 20.9 9.9 24.4l1.5-6.8L6.2 13l6.9-.7z' fill='%231A715A'/%3E%3C/svg%3E">
<!-- Faces of the adopted identity. The reference sets Agency FB, which is not freely
     embeddable; Oswald is its closest open analog and Poppins is the reference's own
     body face. Neither carries Arabic, so Arabic falls through to the self-hosted
     Cairo display face and the naskh body stack. -->
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<!-- Oswald/Poppins carry the base identity; Russo One + Chakra Petch add the
     athletic, competitive-sport voice used for numbers, scoreboards and kickers. -->
<link href="https://fonts.googleapis.com/css2?family=Oswald:wght@500;700&family=Poppins:wght@300;400;600;700&family=Russo+One&family=Chakra+Petch:wght@500;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="assets/style.css">
</head>
