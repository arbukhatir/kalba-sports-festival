<?php
$PAGE_TITLE = 'رياضة معتمدة';
$BOOT_VIEW  = 'champ';
$BOOT_ARG   = isset($_GET["i"])?intval($_GET["i"]):0;
require __DIR__ . '/partials/head.php';
require __DIR__ . '/partials/header.php';
require __DIR__ . '/partials/footer.php';
