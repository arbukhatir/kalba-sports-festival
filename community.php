<?php
require_once __DIR__ . '/lib/render.php';
$C = content(); $COMMUNITY = $C['COMMUNITY']; $WORKSHOPS = $C['WORKSHOPS'];
$PAGE_TITLE = A('المجتمع والورش', 'Community');
$PAGE_DESC = A('أربع فعاليات مجتمعية وست ورش صحية في مهرجان كلباء الرياضي 2026 — المواعيد والمواقع والتسجيل المسبق.', 'Four community events and six health workshops at Kalba Sports Festival 2026 — times, venues and how to reserve a seat.');
require __DIR__ . '/partials/head.php';
require __DIR__ . '/partials/header.php';
echo page_head(A('للعائلة كلها', 'FOR EVERYONE'), A('المجتمع والورش', 'Community & workshops'),
  A('المهرجان ليس للمتفرجين فقط — أربع فعاليات مجتمعية وست ورش صحية مفتوحة للجميع طوال أيام المهرجان.', 'The festival is not for spectators only — four community events and six health workshops, open to everyone across all eight days.'),
  ['bg' => 'champs/ai-schools-esports.webp',
   'actions' => btn(A('تصريح الزيارة المجاني', 'Free visitor pass'), 'join.php', 'gold def')]);
?>
<section class="container section" style="max-width:900px">

  <div class="def-stats cw-stats">
    <div class="def-stat"><b>4</b><span><?= e(A('فعاليات مجتمعية', 'community events')) ?></span></div>
    <div class="def-stat"><b>6</b><span><?= e(A('ورش صحية وتوعوية', 'health workshops')) ?></span></div>
    <div class="def-stat"><b>8</b><span><?= e(A('أيام مفتوحة للجميع', 'days open to all')) ?></span></div>
  </div>

  <h2 class="sec-title"><?= e(A('الفعاليات المجتمعية', 'Community events')) ?></h2>
  <p class="sec-intro"><?= e(A('مشاركة فعلية لا مشاهدة — محطات ومسابقات وجلسات مفتوحة بلا تسجيل مسبق.', 'Take part rather than watch — stations, contests and open sessions, no booking needed.')) ?></p>
  <div class="grid g2">
    <?php foreach ($COMMUNITY as $ev): ?>
      <article class="card ce-card">
        <div class="ce-top">
          <span class="ce-ic"><?= icon($ev['ic']) ?></span>
          <h3 class="tt"><?= e(tx($ev['t'])) ?></h3>
        </div>
        <p class="dd"><?= e(tx($ev['d'])) ?></p>
        <ul class="ce-meta">
          <li><?= icon('clock') ?> <span><?= e(tx($ev['when'])) ?></span></li>
          <li><?= icon('pin') ?> <span><?= e(tx($ev['where'])) ?></span></li>
          <li><?= icon('users') ?> <span><?= e(tx($ev['who'])) ?></span></li>
        </ul>
      </article>
    <?php endforeach; ?>
  </div>

  <h2 class="sec-title" style="margin-top:34px"><?= e(A('الورش الصحية والتوعوية', 'Health & awareness workshops')) ?></h2>
  <p class="sec-intro"><?= e(A('ست ورش بمقاعد محدودة — احجز مقعدك مسبقاً لضمانه، والحضور مجاني بالكامل.', 'Six workshops with limited seats — reserve ahead to secure yours. Attendance is free.')) ?></p>
  <div class="ws-list">
    <?php foreach ($WORKSHOPS as $n => $w): $tba = strpos($w['s'], 'workshop-') === 0; ?>
      <article class="ws-row<?= $tba ? ' ws-tba' : '' ?>">
        <span class="ws-n"><?= sprintf('%02d', $n + 1) ?></span>
        <span class="ws-ic"><?= icon($w['ic']) ?></span>
        <span class="ws-body">
          <span class="ws-t"><?= e(tx($w['t'])) ?></span>
          <span class="ws-d"><?= e(tx($w['d'])) ?></span>
          <span class="ws-meta">
            <?= icon('calendar') ?> <?= e(tx($w['when'])) ?>
            · <?= e(sprintf(A('%d دقيقة', '%d min'), (int)$w['len'])) ?>
            · <?= e(sprintf(A('%d مقعداً', '%d seats'), (int)$w['seats'])) ?>
          </span>
        </span>
        <span class="ws-act">
          <?php if ($tba): ?>
            <span class="badge pending"><?= e(A('يُعلن قريباً', 'Announced soon')) ?></span>
          <?php else: ?>
            <a class="btn gold sm" href="<?= e(url('register.php?type=workshop&w=' . rawurlencode($w['s']))) ?>"><?= e(A('احجز مقعدك', 'Reserve a seat')) ?></a>
          <?php endif; ?>
        </span>
      </article>
    <?php endforeach; ?>
  </div>

  <div class="cal-cta" style="margin-top:26px">
    <span class="cal-cta-ic"><?= icon('bulb') ?></span>
    <span class="cal-cta-txt">
      <strong><?= e(A('محتوى تعليمي مرافق', 'Learning material')) ?></strong>
      <span class="cal-cta-sub"><?= e(A('مقاطع قصيرة ونصائح صحية تُنشر مع كل ورشة في قسم الأخبار والإعلام.', 'Short clips and health tips are published alongside each workshop in the news section.')) ?></span>
    </span>
    <?= btn(A('الأخبار والإعلام', 'News & media'), 'news.php', 'ghost') ?>
  </div>
</section>
<?php require __DIR__ . '/partials/footer.php'; ?>
