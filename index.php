<?php
require_once __DIR__ . '/lib/render.php';
$C = content(); $CHAMPS = $C['CHAMPS'];
$PAGE_TITLE = A('مهرجان كلباء الرياضي 2026', 'Kalba Sports Festival 2026');
$PAGE_DESC = A('مهرجان كلباء الرياضي 2026 — ٨ أيام و١٣ رياضة معتمدة وفعاليات مجتمعية على كورنيش كلباء، 6–13 نوفمبر 2026.', 'Kalba Sports Festival 2026 — 8 days, 13 official sports and community events on the Kalba Corniche, 6–13 November.');
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
    <video class="hm-video" src="portals/hero.mp4" autoplay muted loop playsinline preload="auto" poster="<?= e(champ_img($CHAMPS[0])) ?>"></video>
    <div class="hero-overlay"></div>
  </div>
  <div class="def-hero-in">
    <div class="def-kicker"><?= e(A('مهرجان كلباء الرياضي — 6–13 نوفمبر 2026', 'KALBA SPORTS FESTIVAL — NOV 6–13, 2026')) ?></div>
    <h1><?= A('<b>٨ أيام.</b> مدينة واحدة. <b>حماس لا يتوقف!</b>', '<b>8 DAYS.</b> ONE CITY. <b>GAME ON!</b>') ?></h1>
    <p class="def-sub"><?= e(A('١٣ رياضة معتمدة وفعاليات مجتمعية على كورنيش كلباء.', '13 official sports and community events on the Kalba Corniche.')) ?></p>
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
  <?= section_title(A('الرياضات والأنشطة', 'Sports & Activities'),
     A('١٣ بطولة معتمدة و٤ فعاليات مجتمعية و٦ ورش', '13 championships, 4 community events and 6 workshops')) ?>
  <?php
  /* One rail for everything the festival puts on: the championships first,
     then the community events, then the workshops. Each entry keeps its own
     destination, so a card always lands where that thing actually lives. */
  $rail = [];
  foreach ($CHAMPS as $k => $c) {
    $rail[] = ['img' => champ_img($c), 'ey' => champ_cat_name($c['c']),
               'ti' => champ_name($c), 'href' => 'champ.php?i=' . $k,
               'go' => A('استكشف', 'Explore')];
  }
  foreach ($C['COMMUNITY'] as $ev) {
    $rail[] = ['img' => $ev['img'] ?? '', 'ey' => A('فعالية مجتمعية', 'Community event'),
               'ti' => tx($ev['t']), 'href' => 'community.php',
               'go' => A('التفاصيل', 'Details')];
  }
  foreach ($C['WORKSHOPS'] as $w) {
    $tba = strpos($w['s'], 'workshop-') === 0;
    $rail[] = ['img' => $w['img'] ?? '', 'ey' => A('ورشة صحية', 'Health workshop'),
               'ti' => tx($w['t']), 'href' => 'community.php',
               'go' => $tba ? A('قريباً', 'Soon') : A('احجز مقعدك', 'Reserve a seat')];
  }
  ?>
  <div class="showcase" id="scRow">
    <?php foreach ($rail as $k => $it): ?>
      <a class="sc-item" href="<?= e(url($it['href'])) ?>" aria-label="<?= e($it['ti']) ?>">
        <img src="<?= e($it['img']) ?>" alt="" loading="lazy">
        <div class="sc-body">
          <span class="sc-num"><?= sprintf('%02d', $k + 1) ?></span>
          <div class="sc-ey"><?= e($it['ey']) ?></div>
          <h3 class="sc-ti"><?= e($it['ti']) ?></h3>
          <span class="sc-go"><?= e($it['go']) ?> <span class="ar" aria-hidden="true">&rarr;</span></span>
        </div>
      </a>
    <?php endforeach; ?>
  </div>
  <div class="sc-rail"><span><?= e(A('اسحب لاستكشاف كل الرياضات والأنشطة', 'Drag to explore every sport and activity')) ?></span>
    <span class="sc-line"></span>
    <span class="sc-arrows">
      <button type="button" class="sc-arrow" onclick="scScroll(-1)" aria-label="<?= e(A('السابق','Previous')) ?>">‹</button>
      <button type="button" class="sc-arrow" onclick="scScroll(1)" aria-label="<?= e(A('التالي','Next')) ?>">›</button>
    </span>
  </div>
</section>

<section class="def-wrap news-strip">
  <div class="def-sec-head" style="text-align:start;margin-bottom:18px">
    <h2><?= e(A('آخر الأخبار والتحديثات', 'Latest news & updates')) ?></h2>
    <p><?= e(A('أهم الإعلانات والتغطيات من غرفة أخبار المهرجان.', 'The announcements and coverage that matter, from the festival newsroom.')) ?></p>
  </div>
  <div class="nw-grid">
    <?php foreach (array_slice($C['NEWS'], 0, 4) as $k => $n): ?>
      <a class="nw-card" href="<?= e(url('news.php')) ?>">
        <span class="nw-date">
          <?php if (!empty($n['u'])): ?><span class="nw-live"><?= e(A('عاجل', 'Breaking')) ?></span> <?php endif; ?>
          <?= e(sprintf(A('تحديث %02d', 'Update %02d'), $k + 1)) ?>
        </span>
        <span class="nw-title"><?= e(tx($n)) ?></span>
        <span class="nw-more"><?= e(A('اقرأ المزيد', 'Read more')) ?> →</span>
      </a>
    <?php endforeach; ?>
  </div>
</section>

<section class="def-state">
  <h2><?= A('<b>٨ أيام.</b> مدينة واحدة. <b>حماس لا يتوقف!</b>', '<b>8 DAYS.</b> ONE CITY. <b>GAME ON!</b>') ?></h2>
  <p><?= e(A('من 6 إلى 13 نوفمبر تتحول كلباء إلى ملعب كبير مفتوح للجميع — منافسات رسمية على الشاطئ وتحديات للمدارس والعائلات وفعاليات مجتمعية.', 'From 6 to 13 November, Kalba becomes one giant open playground — official beach competitions, school and family challenges, and community events.')) ?></p>
  <div class="def-stats">
    <?php foreach ([['13','بطولة معتمدة','official championships'],['4','فعاليات مجتمعية','community events'],['6','ورش صحية','health workshops'],['8','أيام منافسة','days of competition']] as $s): ?>
      <div class="def-stat"><b><?= e($s[0]) ?></b><span><?= e(A($s[1], $s[2])) ?></span></div>
    <?php endforeach; ?>
  </div>
</section>

<?php require __DIR__ . '/partials/footer.php'; ?>
