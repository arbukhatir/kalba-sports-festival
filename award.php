<?php
$PAGE_TITLE = 'واجهة المنظم';
$BOOT_VIEW  = 'award';
$BOOT_ARG   = isset($_GET["code"])?$_GET["code"]:null;
require __DIR__ . '/partials/head.php';
require __DIR__ . '/partials/header.php';
require __DIR__ . '/partials/footer.php';
