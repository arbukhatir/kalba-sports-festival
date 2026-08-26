<?php
require_once __DIR__ . '/lib/render.php';
$C = content(); $CHAMPS = $C['CHAMPS'];
$PAGE_TITLE = A('الأجندة اليومية', 'Programme');
$PAGE_DESC = A('الأجندة اليومية لمهرجان كلباء الرياضي 2026 — كل الفعاليات على مدى ثمانية أيام مع تصفية حسب البطولة واليوم والفئة.', 'The daily programme of Kalba Sports Festival 2026 — every event across eight days, filtered by championship, day and category.');

/* Build the schedule from every sport's fixture grid, grouped by day. Each row
   carries its filter keys as data attributes so the browser narrows the list
   without a round trip, and an .ics link so a visitor can keep the slot. */
$byDay = [];
foreach ($CHAMPS as $i => $c) {
  foreach ($c['sch'] as $x) {
    $byDay[$x[0]][] = [
      't' => $x[1], 'round' => round_name($x[2]), 'i' => $i, 'c' => $c,
      'title' => champ_name($c) . ' — ' . round_name($x[2]),
    ];
  }
}
uksort($byDay, function ($a, $b) { return ((int)explode('/', $a)[0]) <=> ((int)explode('/', $b)[0]); });
foreach ($byDay as $d => &$evs) { usort($evs, function ($a, $b) { return strcmp($a['t'], $b['t']); }); }
unset($evs);
$total = array_sum(array_map('count', $byDay));

require __DIR__ . '/partials/head.php';
require __DIR__ . '/partials/header.php';
echo page_head(A('البرنامج', 'PROGRAMME'), A('الأجندة اليومية', 'Daily programme'),
  A('كل فعاليات المهرجان على مدى 8 أيام — صفِّ حسب البطولة أو اليوم أو الفئة، وأضف ما يهمك إلى تقويمك.', 'Every festival event across 8 days — filter by championship, day or category, and add what matters to your calendar.'),
  ['bg' => 'champs/ai-running.webp']);
?>
<section class="container section" style="max-width:880px">

  <div class="cal-cta">
    <span class="cal-cta-ic"><?= icon('calendar') ?></span>
    <span class="cal-cta-txt">
      <strong><?= e(A('أضف المهرجان كاملاً إلى تقويمك', 'Add the whole festival to your calendar')) ?></strong>
      <span class="cal-cta-sub"><?= e(sprintf(A('ملف تقويم واحد يضم %d فعالية — يعمل مع تقويم آيفون وأندرويد وأوتلوك.', 'One calendar file with all %d events — works with iPhone, Android and Outlook.'), $total)) ?></span>
    </span>
    <?= btn(A('تحميل التقويم', 'Download calendar'), 'ics.php', 'gold') ?>
  </div>

  <div class="sc-tools ag-filters" id="agFilters">
    <div class="ag-selects">
      <div class="field">
        <label class="flabel" for="agSport"><?= e(A('البطولة', 'Championship')) ?></label>
        <select id="agSport"><option value=""><?= e(A('كل البطولات', 'All championships')) ?></option>
          <?php foreach ($CHAMPS as $i => $c): ?><option value="<?= $i ?>"><?= e(champ_name($c)) ?></option><?php endforeach; ?>
        </select>
      </div>
      <div class="field">
        <label class="flabel" for="agDay"><?= e(A('اليوم', 'Day')) ?></label>
        <select id="agDay"><option value=""><?= e(A('كل الأيام', 'All days')) ?></option>
          <?php foreach (array_keys($byDay) as $d): ?><option value="<?= e($d) ?>"><?= e(fest_day_label($d)) ?></option><?php endforeach; ?>
        </select>
      </div>
      <div class="field">
        <label class="flabel" for="agCat"><?= e(A('الفئة', 'Category')) ?></label>
        <select id="agCat"><option value=""><?= e(A('كل الفئات', 'All categories')) ?></option>
          <?php foreach ($C['CHAMP_CATS'] as $k): ?><option value="<?= e($k['k']) ?>"><?= e(tx($k)) ?></option><?php endforeach; ?>
        </select>
      </div>
    </div>
    <div class="sc-meta">
      <span><?= e(A('يعرض', 'Showing')) ?> <b id="agCount"><?= $total ?></b> <?= e(A('من', 'of')) ?> <b><?= $total ?></b> <?= e(A('فعالية', 'events')) ?></span>
      <span class="ag-views">
        <button type="button" class="seg-btn on" id="agViewList"><?= icon('clipboard') ?> <?= e(A('قائمة', 'List')) ?></button>
        <button type="button" class="seg-btn" id="agViewCal"><?= icon('calendar') ?> <?= e(A('تقويم', 'Calendar')) ?></button>
        <button type="button" class="sc-reset" id="agReset"><?= e(A('إعادة تعيين', 'Reset')) ?></button>
      </span>
    </div>
  </div>

  <div id="agList">
    <?php foreach ($byDay as $d => $evs): ?>
      <section class="sc-day" data-day="<?= e($d) ?>">
        <h2 class="sc-dayhead">
          <span class="sc-dayname"><?= e(fest_day_label($d)) ?></span>
          <span class="sc-daycount"><?= e(count($evs) . ' ' . A('فعالية', 'events')) ?></span>
        </h2>
        <ul class="sc-list">
          <?php foreach ($evs as $ev): ?>
            <li class="sc-item" data-sport="<?= $ev['i'] ?>" data-day="<?= e($d) ?>" data-cat="<?= e($ev['c']['c']) ?>">
              <div class="sc-toggle" style="cursor:default">
                <span class="sc-node" style="color:var(--gold)"><?= $ev['c']['ic'] ?></span>
                <span>
                  <span class="sc-time" dir="ltr" style="color:var(--gold-soft)"><?= e($ev['t']) ?></span>
                  <span class="sc-title"><?= e($ev['title']) ?></span>
                </span>
                <a class="sc-add" href="<?= e(url('ics.php?i=' . $ev['i'] . '&d=' . rawurlencode($d) . '&t=' . rawurlencode($ev['t']))) ?>"
                   title="<?= e(A('أضف إلى تقويمي', 'Add to my calendar')) ?>"
                   aria-label="<?= e(A('أضف إلى تقويمي: ', 'Add to my calendar: ') . $ev['title']) ?>"><?= icon('calendar') ?></a>
              </div>
            </li>
          <?php endforeach; ?>
        </ul>
      </section>
    <?php endforeach; ?>
    <div class="sc-empty" id="agEmpty" hidden>
      <?= icon('question') ?>
      <p><?= e(A('لا توجد فعاليات مطابقة لهذه التصفية.', 'No events match these filters.')) ?></p>
      <button type="button" class="btn ghost sm" id="agEmptyReset"><?= e(A('إعادة تعيين التصفية', 'Reset filters')) ?></button>
    </div>
  </div>

  <div id="agCal" hidden>
    <div class="agc-grid">
      <?php foreach ($byDay as $d => $evs): ?>
        <div class="agc-day" data-day="<?= e($d) ?>">
          <div class="agc-head">
            <span class="agc-date" dir="ltr"><?= e($d) ?></span>
            <span class="agc-name"><?= e(fest_day_label($d)) ?></span>
          </div>
          <ul class="agc-list">
            <?php foreach ($evs as $ev): ?>
              <li class="agc-ev" data-sport="<?= $ev['i'] ?>" data-cat="<?= e($ev['c']['c']) ?>">
                <span class="agc-t" dir="ltr"><?= e(explode('–', $ev['t'])[0]) ?></span>
                <a href="<?= e(url('champ.php?i=' . $ev['i'])) ?>"><?= e(champ_name($ev['c'])) ?></a>
                <small><?= e($ev['round']) ?></small>
              </li>
            <?php endforeach; ?>
          </ul>
          <span class="agc-count"><?= e(count($evs) . ' ' . A('فعالية', 'events')) ?></span>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>
<?php require __DIR__ . '/partials/footer.php'; ?>
