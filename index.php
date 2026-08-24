<?php
require_once __DIR__ . '/lib/render.php';
$C = content(); $CHAMPS = $C['CHAMPS'];
$PAGE_TITLE = A('مهرجان كلباء الرياضي 2026', 'Kalba Sports Festival 2026');
$HERO = true;
require __DIR__ . '/partials/head.php';
require __DIR__ . '/partials/header.php';
?>
<section class="def-hero">
  <div class="hero-media" aria-hidden="true">
    <div class="hx-slides">
      <?php foreach ($CHAMPS as $k => $c): ?>
        <div class="hx-slide<?= $k === 0 ? ' on' : '' ?>" style="background-image:url(<?= e(champ_img($c)) ?>)"></div>
      <?php endforeach; ?>
    </div>
    <div class="hero-overlay"></div>
  </div>
  <div class="def-hero-in">
    <div class="def-kicker"><?= e(A('مهرجان كلباء الرياضي — 6–13 نوفمبر 2026', 'KALBA SPORTS FESTIVAL — NOV 6–13, 2026')) ?></div>
    <h1><?= A('<b>٨ أيام.</b> مدينة واحدة. <b>حماس لا يتوقف!</b>', '<b>8 DAYS.</b> ONE CITY. <b>GAME ON!</b>') ?></h1>
    <p class="def-sub"><?= e(A('١٥ رياضة معتمدة وفعاليات مجتمعية على كورنيش كلباء.', '15 official sports and community events on the Kalba Corniche.')) ?></p>
    <div class="btn-row" style="justify-content:center">
      <?= btn(A('تصريح الزيارة المجاني', 'GET FREE VISITOR PASS'), 'join.php', 'gold def') ?>
      <?= btn(A('سجّل مشاركتك', 'REGISTER TO COMPETE'), 'register.php', 'def defghost') ?>
    </div>
    <div class="def-count" id="cd">
      <?php foreach ([['d','يوم','days'],['h','ساعة','hours'],['m','دقيقة','min'],['s','ثانية','sec']] as $u): ?>
        <div class="cd-cell"><span class="cd-num" data-cd="<?= $u[0] ?>">--</span><span class="cd-lbl"><?= e(A($u[1], $u[2])) ?></span></div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<div class="mq" aria-hidden="true"><div class="mq-track"><?php for ($x = 0; $x < 12; $x++) echo '<span>' . e(A('مهرجان كلباء الرياضي 2026', 'KALBA SPORTS FESTIVAL 2026')) . '</span>'; ?></div></div>

<section class="edition"><div class="edition-in">
  <div class="edition-date"><span class="yr">2026</span><span class="dd" dir="ltr">06–13</span><span class="mo"><?= e(A('نوفمبر', 'November')) ?></span></div>
  <div class="edition-rule" aria-hidden="true"></div>
  <div class="edition-meta">
    <?php foreach ([[ 'النسخة','Edition','النسخة الأولى','First edition'],['الموقع','Location','كورنيش كلباء، الشارقة','Kalba Corniche, Sharjah'],['الحالة','Status','التسجيل مفتوح الآن','Registration open now']] as $m): ?>
      <div class="row"><span class="k"><?= e(A($m[0], $m[1])) ?></span><span class="v"><?= e(A($m[2], $m[3])) ?></span></div>
    <?php endforeach; ?>
  </div>
</div></section>

<section class="showcase-wrap">
  <?= section_title(A('الرياضات', 'The Sports'), A('١٥ رياضة معتمدة', '15 official sports')) ?>
  <div class="showcase" id="scRow">
    <?php foreach ($CHAMPS as $k => $c): ?>
      <a class="sc-item" href="<?= e(url('champ.php?i=' . $k)) ?>" aria-label="<?= e(champ_name($c)) ?>">
        <img src="<?= e(champ_img($c)) ?>" alt="" loading="lazy">
        <div class="sc-body">
          <span class="sc-num"><?= sprintf('%02d', $k + 1) ?></span>
          <div class="sc-ey"><?= e(champ_cat_name($c['c'])) ?></div>
          <h3 class="sc-ti"><?= e(champ_name($c)) ?></h3>
          <span class="sc-go"><?= e(A('استكشف', 'Explore')) ?> <span class="ar" aria-hidden="true">→</span></span>
        </div>
      </a>
    <?php endforeach; ?>
  </div>
  <div class="sc-rail"><span><?= e(A('اسحب لاستكشاف كل الرياضات', 'Drag to explore all sports')) ?></span>
    <span class="sc-line"></span>
    <span class="sc-arrows">
      <button type="button" class="sc-arrow" onclick="scScroll(-1)" aria-label="<?= e(A('السابق','Previous')) ?>">‹</button>
      <button type="button" class="sc-arrow" onclick="scScroll(1)" aria-label="<?= e(A('التالي','Next')) ?>">›</button>
    </span>
  </div>
</section>

<section class="def-state">
  <h2><?= A('<b>٨ أيام.</b> مدينة واحدة. <b>حماس لا يتوقف!</b>', '<b>8 DAYS.</b> ONE CITY. <b>GAME ON!</b>') ?></h2>
  <p><?= e(A('من 6 إلى 13 نوفمبر تتحول كلباء إلى ملعب كبير مفتوح للجميع — منافسات رسمية على الشاطئ وتحديات للمدارس والعائلات وفعاليات مجتمعية.', 'From 6 to 13 November, Kalba becomes one giant open playground — official beach competitions, school and family challenges, and community events.')) ?></p>
  <div class="def-stats">
    <?php foreach ([['15','رياضة معتمدة','official sports'],['8','أيام منافسة','days of competition'],['+50,000','زائر متوقع','expected visitors'],['4','فئات رياضية','sport categories']] as $s): ?>
      <div class="def-stat"><b><?= e($s[0]) ?></b><span><?= e(A($s[1], $s[2])) ?></span></div>
    <?php endforeach; ?>
  </div>
</section>

<?php require __DIR__ . '/partials/footer.php'; ?>
