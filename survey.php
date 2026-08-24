<?php
$PAGE_TITLE = 'استبيان';
$BOOT_VIEW  = 'survey';
$BOOT_ARG   = isset($_GET["k"])?$_GET["k"]:null;
require __DIR__ . '/partials/head.php';
require __DIR__ . '/partials/header.php';
require __DIR__ . '/partials/footer.php';
