<?php
$PAGE_TITLE = 'التسجيل';
$BOOT_VIEW  = 'form'; /* R.form maps ?type into the unified register form; with no type it is identical to the plain register view */
$BOOT_ARG   = isset($_GET["type"])?$_GET["type"]:null;
require __DIR__ . '/partials/head.php';
require __DIR__ . '/partials/header.php';
require __DIR__ . '/partials/footer.php';
