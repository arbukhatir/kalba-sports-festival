<?php
require_once __DIR__ . '/lib/render.php';
$C = content();
$PAGE_TITLE = A('عن المهرجان', 'About');
require __DIR__ . '/partials/head.php';
require __DIR__ . '/partials/header.php';
echo page_head(A('من نحن', 'ABOUT'), A('حين تتحول مدينة إلى ملعب', 'When a city becomes a playground'),
  A('مهرجان كلباء الرياضي 2026 — ثمانية أيام من المنافسات والفعاليات المجتمعية على كورنيش كلباء بإمارة الشارقة.', 'Kalba Sports Festival 2026 — eight days of competition and community events on the Kalba Corniche, Emirate of Sharjah.'),
  ['bg' => 'champs/ai-airsoft.webp']);
?>
<section class="container section">
  <div class="grid g2">
    <?php
    $blocks = [
      ['🏟️', A('١٣ رياضة معتمدة', '13 official sports'), A('من كرة القدم والطائرة المجتمعية إلى الجيوجيستو والكاياك، منافسات رسمية بأربع فئات.', 'From football and community volleyball to jiu-jitsu and kayak — official competitions across four categories.')],
      ['🎓', A('تحدي المدارس', 'Schools challenge'), A('خمسة أيام من التحديات المعرفية والرياضية والإبداعية لطلبة المدارس وأسرهم.', 'Five days of knowledge, sports and creative challenges for students and their families.')],
      ['👨‍👩‍👧‍👦', A('فعاليات مجتمعية', 'Community events'), A('ورش صحية وألعاب عائلية وفعاليات ترفيهية للجميع طوال أيام المهرجان.', 'Health workshops, family games and entertainment for everyone throughout the festival.')],
      ['🛡️', A('تنظيم وأمان', 'Safety & organization'), A('إشراف مجلس الشارقة الرياضي مع الشرطة والدفاع المدني والفرق الطبية.', 'Run by the Sharjah Sports Council with police, civil defence and medical teams on site.')],
    ];
    foreach ($blocks as $b) echo '<div class="panel"><h2 class="sec-h" style="margin-top:0">' . $b[0] . ' ' . e($b[1]) . '</h2><p class="muted">' . e($b[2]) . '</p></div>';
    ?>
  </div>
  <div class="btn-row" style="justify-content:center;margin-top:22px">
    <?= btn(A('استكشف الرياضات', 'Explore the sports'), 'champs.php', 'primary') ?>
    <?= btn(A('تصريح الزيارة المجاني', 'Free visitor pass'), 'join.php', 'ghost') ?>
  </div>
</section>
<?php require __DIR__ . '/partials/footer.php'; ?>
