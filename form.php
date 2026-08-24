<?php
$PAGE_TITLE = 'التسجيل';
$BOOT_VIEW  = 'form';
$BOOT_ARG   = isset($_GET["type"])?$_GET["type"]:null;
require __DIR__ . '/partials/head.php';
require __DIR__ . '/partials/header.php';
require __DIR__ . '/partials/footer.php';
