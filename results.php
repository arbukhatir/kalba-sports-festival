<?php
require_once __DIR__ . '/lib/render.php';
$C = content(); $CHAMPS = $C['CHAMPS'];
$PAGE_TITLE = A('النتائج الفورية', 'Live Results');
$PAGE_DESC = A('النتائج الفورية لمهرجان كلباء الرياضي 2026 — نتائج المباريات وترتيب البطولات والترتيب العام.', 'Live results from Kalba Sports Festival 2026 — match scores, championship standings and the overall ranking.');
$rows = [];
try { $rows = db_all('SELECT * FROM matches ORDER BY sport, day'); } catch (Throwable $ex) {}

/* three levels of the results requirement, one tab each */
$TABS = [
  'live'     => [A('المباريات', 'Matches'),            A('نتيجة كل مباراة فور انتهائها', 'Every match as it finishes')],
  'tables'   => [A('ترتيب البطولات', 'Standings'),     A('جدول الترتيب الداخلي لكل بطولة', 'The table inside each championship')],
  'overall'  => [A('الترتيب العام', 'Overall'),        A('ترتيب شامل عبر كل البطولات', 'One ranking across every championship')],
];
$tab = isset($_GET['t']) && isset($TABS[$_GET['t']]) ? $_GET['t'] : 'live';

require __DIR__ . '/partials/head.php';
require __DIR__ . '/partials/header.php';
echo page_head(A('النتائج', 'RESULTS'), A('النتائج الفورية', 'Live results'),
  $TABS[$tab][1], ['bg' => 'champs/ai-basketball-3x3.webp']);
?>
<section class="container section" style="max-width:900px">

  <nav class="lb-tabs res-tabs" aria-label="<?= e(A('مستويات النتائج', 'Result levels')) ?>">
    <?php foreach ($TABS as $k => $t): ?>
      <a class="lb-tab<?= $k === $tab ? ' active' : '' ?>" href="<?= e(url('results.php?t=' . $k)) ?>"
         <?= $k === $tab ? 'aria-current="page"' : '' ?>><?= e($t[0]) ?></a>
    <?php endforeach; ?>
  </nav>

  <?php if (!$rows): ?>
    <div class="panel" style="text-align:center"><div class="be"><?= icon('trophy') ?></div>
      <h2 class="sec-h" style="margin-top:0"><?= e(A('تبدأ النتائج مع انطلاق المنافسات', 'Results begin when competition starts')) ?></h2>
      <p class="muted"><?= e(A('من 6 إلى 13 نوفمبر 2026 — تظهر النتائج والترتيب هنا فور إدخالها من غرفة التحكم.', 'From 6–13 November 2026 — scores and standings appear here as they are entered from the control room.')) ?></p>
      <div class="btn-row" style="justify-content:center"><?= btn(A('تصفح الرياضات', 'Browse the sports'), 'champs.php', 'primary') ?></div>
    </div>

  <?php elseif ($tab === 'live'): ?>
    <?php foreach ($CHAMPS as $i => $c):
      $m = array_values(array_filter($rows, function ($r) use ($c) { return (string)$r['sport'] === $c['s']; }));
      if (!$m) continue; ?>
      <h2 class="sec-title"><?= $c['ic'] ?> <?= e(champ_name($c)) ?></h2>
      <?php foreach ($m as $r): ?>
        <div class="match-row <?= e($r['status']) ?>">
          <span class="m-side"><?= e(lang() === 'ar' ? ($r['side_a_ar'] ?: '—') : ($r['side_a_en'] ?: '—')) ?></span>
          <span class="m-score" dir="ltr"><?= $r['score_a'] === null ? '–' : (int)$r['score_a'] ?> : <?= $r['score_b'] === null ? '–' : (int)$r['score_b'] ?></span>
          <span class="m-side"><?= e(lang() === 'ar' ? ($r['side_b_ar'] ?: '') : ($r['side_b_en'] ?: '')) ?></span>
          <span class="badge <?= $r['status'] === 'live' ? 'accepted' : ($r['status'] === 'finished' ? 'rejected' : 'pending') ?>">
            <?= e($r['status'] === 'live' ? A('مباشر', 'Live') : ($r['status'] === 'finished' ? A('انتهت', 'Finished') : A('قادمة', 'Upcoming'))) ?></span>
        </div>
      <?php endforeach; ?>
    <?php endforeach; ?>

  <?php elseif ($tab === 'tables'): ?>
    <?php $any = false; foreach ($CHAMPS as $i => $c):
      $s = standings_from_matches($rows, $c['s']);
      if (!$s) continue; $any = true; ?>
      <div class="points-board">
        <div class="points-board-head">
          <h2 class="points-board-title"><span><?= $c['ic'] ?></span> <?= e(champ_name($c)) ?></h2>
          <span class="points-board-count"><?= e(count($s) . ' ' . A('فريق', 'teams')) ?></span>
        </div>
        <div class="points-table-wrap">
          <table class="pts-table">
            <thead><tr>
              <th scope="col"><?= e(A('#', '#')) ?></th>
              <th scope="col"><?= e(A('الفريق', 'Team')) ?></th>
              <th scope="col" title="<?= e(A('لعب', 'Played')) ?>"><?= e(A('لعب', 'P')) ?></th>
              <th scope="col"><?= e(A('فاز', 'W')) ?></th>
              <th scope="col"><?= e(A('تعادل', 'D')) ?></th>
              <th scope="col"><?= e(A('خسر', 'L')) ?></th>
              <th scope="col"><?= e(A('الفارق', 'GD')) ?></th>
              <th scope="col"><?= e(A('النقاط', 'Pts')) ?></th>
            </tr></thead>
            <tbody>
              <?php $k = 0; foreach ($s as $row): $k++; ?>
                <tr class="<?= $k <= 3 ? 't' . $k : '' ?>">
                  <td class="points-rank" data-label="#"><?= $k ?></td>
                  <td class="points-team" data-label="<?= e(A('الفريق', 'Team')) ?>"><strong><?= e(team_name($row)) ?></strong></td>
                  <td data-label="<?= e(A('لعب', 'P')) ?>"><?= (int)$row['p'] ?></td>
                  <td data-label="<?= e(A('فاز', 'W')) ?>"><?= (int)$row['w'] ?></td>
                  <td data-label="<?= e(A('تعادل', 'D')) ?>"><?= (int)$row['d'] ?></td>
                  <td data-label="<?= e(A('خسر', 'L')) ?>"><?= (int)$row['l'] ?></td>
                  <td data-label="<?= e(A('الفارق', 'GD')) ?>" dir="ltr"><?= ($row['gd'] > 0 ? '+' : '') . (int)$row['gd'] ?></td>
                  <td class="points-total" data-label="<?= e(A('النقاط', 'Pts')) ?>"><strong><?= (int)$row['pts'] ?></strong></td>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      </div>
    <?php endforeach; ?>
    <?php if (!$any): ?>
      <div class="panel" style="text-align:center"><div class="be"><?= icon('clipboard') ?></div>
        <h2 class="sec-h" style="margin-top:0"><?= e(A('لم تكتمل أي مباراة بعد', 'No match has finished yet')) ?></h2>
        <p class="muted"><?= e(A('يظهر جدول ترتيب كل بطولة فور انتهاء أول مبارياتها.', 'Each championship table appears once its first matches are final.')) ?></p>
      </div>
    <?php endif; ?>
    <p class="points-note hint"><?= e(A('الفوز 3 نقاط، التعادل نقطة واحدة. عند التساوي يُرتَّب الفريق الأعلى في فارق النقاط ثم النقاط المسجَّلة.', 'Win 3 points, draw 1. Teams level on points are separated by difference, then by points scored.')) ?></p>

  <?php else:
    $overall = overall_standings($rows, $CHAMPS);
    $champions = champions_by_sport($rows, $CHAMPS); ?>
    <?php if ($champions): ?>
      <h2 class="sec-title"><?= e(A('الأبطال والمتوّجون', 'Champions')) ?></h2>
      <div class="champ-podium">
        <?php foreach ($champions as $i => $w): ?>
          <a class="champ-win" href="<?= e(url('champ.php?i=' . $i)) ?>">
            <img src="<?= e(champ_img($w['champ'])) ?>" alt="" loading="lazy">
            <span class="cw-body">
              <span class="cw-sport"><?= e(champ_name($w['champ'])) ?></span>
              <span class="cw-name"><?= icon('trophy') ?> <?= e(team_name($w['name'])) ?></span>
              <span class="cw-pts"><?= e((int)$w['name']['pts'] . ' ' . A('نقطة', 'pts')) ?></span>
            </span>
          </a>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>

    <h2 class="sec-title"><?= e(A('الترتيب العام', 'Overall ranking')) ?></h2>
    <?php if ($overall): ?>
      <div class="lb-list">
        <?php $k = 0; foreach ($overall as $row): $k++; ?>
          <div class="lb-row <?= $k <= 3 ? 't' . $k : '' ?>">
            <span class="lb-rank"><?= $k ?></span>
            <span class="lb-id">
              <span class="lb-name"><?= e(team_name($row)) ?></span>
              <span class="lb-sub"><?= e(sprintf(A('%d بطولة · %d مباراة · %d فوز', '%d championships · %d matches · %d wins'),
                    $row['sports'], $row['p'], $row['w'])) ?></span>
            </span>
            <span class="lb-pts"><?= (int)$row['pts'] ?> <small><?= e(A('نقطة', 'pts')) ?></small></span>
          </div>
        <?php endforeach; ?>
      </div>
    <?php else: ?>
      <div class="panel" style="text-align:center"><div class="be"><?= icon('medal') ?></div>
        <h2 class="sec-h" style="margin-top:0"><?= e(A('الترتيب العام يبدأ مع أول نتيجة', 'The overall ranking starts with the first result')) ?></h2>
        <p class="muted"><?= e(A('يجمع هذا الترتيب نقاط كل فريق عبر جميع البطولات التي يشارك فيها.', 'This table adds up each team\'s points across every championship it competes in.')) ?></p>
      </div>
    <?php endif; ?>
    <p class="hint" style="text-align:center;margin-top:14px"><?= e(A('هذه النسخة الأولى من المهرجان، ويبدأ أرشيف النتائج بعد ختام دورة 2026.', 'This is the festival\'s first edition; the results archive opens after the 2026 closing ceremony.')) ?></p>
  <?php endif; ?>
</section>
<?php require __DIR__ . '/partials/footer.php'; ?>
