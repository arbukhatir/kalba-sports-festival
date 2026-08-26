<?php
/* Server-side render helpers — produce the same cinematic markup/classes the old
   JS builders did, so assets/style.css styles them unchanged. */
require_once __DIR__ . '/i18n.php';
require_once __DIR__ . '/security.php';
/* Start the session before a single byte of the page is emitted. Left until
   csrf_field() renders mid-body, session_start() would come after the headers
   had gone and no cookie would ever reach the visitor — so every token would
   fail to match on the next request. */
sec_session();
require_once __DIR__ . '/icons.php';
require_once __DIR__ . '/qr.php';

/* ---- sport helpers ---- */
function champ_name($c) { return lang() === 'ar' ? $c['ar'] : $c['en']; }
function champ_cat_name($k) {
  foreach (content()['CHAMP_CATS'] as $cat) if ($cat['k'] === $k) return tx($cat);
  return '';
}
function champ_img($c) {
  $img = isset($c['img']) ? $c['img'] : '';
  return $img !== '' ? $img : 'gallery/beach-football.webp';
}
function round_name($k) {
  $r = content()['ROUNDS'];
  return isset($r[$k]) ? tx($r[$k]) : $k;
}
/* '06/11' -> 'الجمعة · 6 نوفمبر' / 'Fri · 6 Nov' */
function fest_day_label($d) {
  $parts = explode('/', $d);
  if (count($parts) !== 2) return $d;
  $ts = mktime(0, 0, 0, (int)$parts[1], (int)$parts[0], 2026);
  $wdAr = ['Sun'=>'الأحد','Mon'=>'الاثنين','Tue'=>'الثلاثاء','Wed'=>'الأربعاء','Thu'=>'الخميس','Fri'=>'الجمعة','Sat'=>'السبت'];
  $wd = date('D', $ts);
  $day = (int)$parts[0];
  return lang() === 'ar'
    ? ($wdAr[$wd] ?? $wd) . ' · ' . $day . ' نوفمبر'
    : $wd . ' · ' . $day . ' Nov';
}
function champ_dates($c) {
  $sch = $c['sch'];
  $first = $sch[0][0]; $last = end($sch)[0];
  $f = (int) explode('/', $first)[0]; $l = (int) explode('/', $last)[0];
  return lang() === 'ar' ? "{$f}–{$l} نوفمبر 2026" : "{$f}–{$l} Nov 2026";
}
function days_label($n) { return lang() === 'ar' ? "$n أيام" : "$n days"; }

/* ---- components ---- */
function btn($label, $href, $variant = 'primary', $attrs = '') {
  $cls = 'btn ' . $variant;
  return '<a class="' . $cls . '" href="' . e(url($href)) . '"' . ($attrs ? ' ' . $attrs : '') . '>' . e($label) . '</a>';
}

/* Cinematic shared page header (mirrors the old pageHead). */
function page_head($kicker, $title, $sub = '', $opts = []) {
  $h  = '<header class="pagehead">';
  if (!empty($opts['bg'])) $h .= '<div class="ph-bg" style="background-image:url(' . e($opts['bg']) . ')"></div>';
  $h .= '<div class="pagehead-in">';
  if (!empty($opts['back'])) $h .= '<a class="ph-back" href="' . e(url($opts['back'][0])) . '">&larr; ' . e($opts['back'][1]) . '</a>';
  if ($kicker) $h .= '<div class="ph-kicker">' . e($kicker) . '</div>';
  $h .= '<h1>' . e($title) . '</h1>';
  if ($sub) $h .= '<p class="ph-sub">' . e($sub) . '</p>';
  if (!empty($opts['actions'])) $h .= '<div class="ph-actions">' . $opts['actions'] . '</div>';
  $h .= '</div></header>';
  return $h;
}

/* Section eyebrow + title used across content pages. */
function section_title($title, $sub = '') {
  $h = '<div class="cine-head"><h2 class="cine-ey">' . e($title) . '</h2>';
  if ($sub) $h .= '<span class="cine-sub">' . e($sub) . '</span>';
  return $h . '</div>';
}

/* Render one FORMS field server-side (name attr = f_<n> so the action can read it). */
function form_field($f) {
  $req = !empty($f['r']);
  $name = 'f_' . $f['n'];
  $lab = tx($f['l']) . ($req ? ' <span class="req">*</span>' : ' <span class="opt">(' . A('اختياري', 'optional') . ')</span>');
  $h = '<div class="field"><label class="flabel" for="' . e($name) . '">' . $lab . '</label>';
  $r = $req ? ' required' : '';
  switch ($f['t']) {
    case 'number':   $h .= '<input type="number" id="' . e($name) . '" name="' . e($name) . '" min="0" max="99999"' . $r . '>'; break;
    case 'textarea': $h .= '<textarea id="' . e($name) . '" name="' . e($name) . '" rows="3" maxlength="1000"' . $r . '></textarea>'; break;
    case 'select':
      $h .= '<select id="' . e($name) . '" name="' . e($name) . '"' . $r . '><option value="">' . e(A('اختر', 'Choose')) . '</option>';
      foreach ($f['o'] as $o) $h .= '<option value="' . e(tx($o)) . '">' . e(tx($o)) . '</option>';
      $h .= '</select>'; break;
    case 'file':     $h .= '<input type="file" id="' . e($name) . '" name="' . e($name) . '" accept=".pdf,.jpg,.jpeg,.png"' . $r . '><div class="hint">PDF / JPG / PNG — 8 MB</div>'; break;
    case 'checks':
    case 'days':
      $opts = $f['t'] === 'days'
        ? array_map(function ($x) { return ['ar' => $x, 'en' => $x]; }, ['السبت','الأحد','الاثنين','الثلاثاء','الأربعاء','الخميس','الجمعة'])
        : $f['o'];
      $h .= '<div class="checks">';
      foreach ($opts as $j => $o) $h .= '<label class="check"><input type="checkbox" name="' . e($name) . '[]" value="' . e(tx($o)) . '"> <span>' . e(tx($o)) . '</span></label>';
      $h .= '</div>'; break;
    default:         $h .= '<input type="text" id="' . e($name) . '" name="' . e($name) . '" maxlength="200"' . $r . '>';
  }
  return $h . '</div>';
}

/* One championship card (matches .ev-card). */
function sport_card($c, $i) {
  return '<a class="ev-card" href="' . e(url('champ.php?i=' . $i)) . '" aria-label="' . e(champ_name($c)) . '">' .
    '<span class="ev-media"><img src="' . e(champ_img($c)) . '" alt="" loading="lazy">' .
    '<span class="ev-tag">' . e(champ_cat_name($c['c'])) . '</span></span>' .
    '<span class="ev-title">' . e(champ_name($c)) . '</span></a>';
}

/* =============================================================================
   Standings — level 2 and 3 of the results requirement.

   The matches table is the single source of truth; standings are derived from
   it rather than stored, so a score corrected in the control room re-ranks
   every table on the next page load with nothing to re-sync.
   Win 3, draw 1, loss 0. Ties broken by goal difference, then goals for.
   ============================================================================= */
function standings_from_matches($rows, $sportSlug = null) {
    $t = [];
    $put = function (&$t, $ar, $en) {
        $key = trim($ar) !== '' ? trim($ar) : trim($en);
        if ($key === '') return null;
        if (!isset($t[$key])) $t[$key] = ['ar' => trim($ar), 'en' => trim($en),
            'p' => 0, 'w' => 0, 'd' => 0, 'l' => 0, 'gf' => 0, 'ga' => 0, 'pts' => 0];
        return $key;
    };
    foreach ($rows as $r) {
        if ($sportSlug !== null && (string)$r['sport'] !== (string)$sportSlug) continue;
        if (($r['status'] ?? '') !== 'finished') continue;
        if ($r['score_a'] === null || $r['score_b'] === null) continue;
        $a = $put($t, $r['side_a_ar'] ?? '', $r['side_a_en'] ?? '');
        $b = $put($t, $r['side_b_ar'] ?? '', $r['side_b_en'] ?? '');
        if ($a === null || $b === null) continue;
        $sa = (int)$r['score_a']; $sb = (int)$r['score_b'];
        $t[$a]['p']++; $t[$b]['p']++;
        $t[$a]['gf'] += $sa; $t[$a]['ga'] += $sb;
        $t[$b]['gf'] += $sb; $t[$b]['ga'] += $sa;
        if ($sa > $sb)      { $t[$a]['w']++; $t[$a]['pts'] += 3; $t[$b]['l']++; }
        elseif ($sa < $sb)  { $t[$b]['w']++; $t[$b]['pts'] += 3; $t[$a]['l']++; }
        else                { $t[$a]['d']++; $t[$b]['d']++; $t[$a]['pts']++; $t[$b]['pts']++; }
    }
    foreach ($t as $k => $row) { $t[$k]['gd'] = $row['gf'] - $row['ga']; }
    uasort($t, function ($x, $y) {
        if ($x['pts'] !== $y['pts']) return $y['pts'] <=> $x['pts'];
        if ($x['gd']  !== $y['gd'])  return $y['gd']  <=> $x['gd'];
        return $y['gf'] <=> $x['gf'];
    });
    return $t;
}

/* Level 3: one table across every championship, plus the winner of each. */
function overall_standings($rows, $champs) {
    $all = [];
    foreach ($champs as $c) {
        foreach (standings_from_matches($rows, $c['s']) as $name => $s) {
            if (!isset($all[$name])) $all[$name] = ['ar' => $s['ar'], 'en' => $s['en'],
                'pts' => 0, 'p' => 0, 'w' => 0, 'sports' => 0];
            $all[$name]['pts']    += $s['pts'];
            $all[$name]['p']      += $s['p'];
            $all[$name]['w']      += $s['w'];
            $all[$name]['sports'] += 1;
        }
    }
    uasort($all, function ($x, $y) {
        if ($x['pts'] !== $y['pts']) return $y['pts'] <=> $x['pts'];
        return $y['w'] <=> $x['w'];
    });
    return $all;
}

/* The champion of each championship: top of its table once matches are done. */
function champions_by_sport($rows, $champs) {
    $out = [];
    foreach ($champs as $i => $c) {
        $s = standings_from_matches($rows, $c['s']);
        if (!$s) continue;
        $name = array_key_first($s);
        $out[$i] = ['champ' => $c, 'name' => $s[$name]];
    }
    return $out;
}

/* Team display name in the current language, falling back to the other. */
function team_name($t) {
    $ar = $t['ar'] ?? ''; $en = $t['en'] ?? '';
    if (lang() === 'ar') return $ar !== '' ? $ar : $en;
    return $en !== '' ? $en : $ar;
}
