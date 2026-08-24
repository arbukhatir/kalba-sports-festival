<?php
$PAGE_TITLE = 'تسجيل مشارك';
$BOOT_VIEW  = 'pform';
$BOOT_ARG   = isset($_GET["i"])?intval($_GET["i"]):0;
require __DIR__ . '/partials/head.php';
require __DIR__ . '/partials/header.php';
require __DIR__ . '/partials/footer.php';
