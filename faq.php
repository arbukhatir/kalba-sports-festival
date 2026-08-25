<?php
require_once __DIR__ . '/lib/render.php';
$C = content(); $FAQS = $C['FAQS']; $FAQ_CATS = $C['FAQ_CATS'];
$PAGE_TITLE = A('الأسئلة الشائعة', 'FAQ');
require __DIR__ . '/partials/head.php';
require __DIR__ . '/partials/header.php';
echo page_head(A('مركز المساعدة', 'HELP CENTRE'), A('الأسئلة الشائعة', 'Frequently asked questions'),
  A('كل ما تحتاج معرفته عن التسجيل والتصاريح والنقاط والفعاليات.', 'Everything about registration, passes, points and events.'),
  ['bg' => 'champs/ai-padel.webp']);
?>
<section class="container section" style="max-width:820px">
  <?php foreach ($FAQ_CATS as $cat):
    $items = array_filter($FAQS, function ($f) use ($cat) { return $f['c'] === $cat['k']; });
    if (!$items) continue; ?>
    <h2 class="sec-title"><?= e(tx($cat)) ?></h2>
    <?php foreach ($items as $f): ?>
      <details class="faq-item"><summary><?= e(tx($f['q'])) ?></summary><p><?= e(tx($f['a'])) ?></p></details>
    <?php endforeach; ?>
  <?php endforeach; ?>
  <div class="panel" style="margin-top:20px"><strong>❓ <?= e(A('لم تجد إجابتك؟', 'Didn’t find your answer?')) ?></strong>
    <?= btn(A('تواصل معنا', 'Contact us'), 'contact.php', 'sm gold') ?></div>
</section>
<?php require __DIR__ . '/partials/footer.php'; ?>
