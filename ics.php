<?php
/* =============================================================================
   Calendar export (RFC 5545).

   ics.php                     -> the whole festival programme
   ics.php?i=6&d=07/11&t=16:00–21:00 -> one fixture

   Times in the schedule are local Gulf time; they are emitted with an explicit
   +04:00 offset converted to UTC so the slot lands correctly in any calendar,
   wherever the visitor happens to be.
   ============================================================================= */
require_once __DIR__ . '/lib/render.php';
$C = content(); $CHAMPS = $C['CHAMPS'];

/* '07/11' + '16:00–21:00' -> [startUtc, endUtc] as YYYYMMDDTHHMMSSZ */
function ics_times($day, $slot) {
    $p = explode('/', $day);
    if (count($p) !== 2) return null;
    $d = (int)$p[0]; $m = (int)$p[1];
    $parts = preg_split('/[–—-]/u', $slot);
    $from = trim($parts[0] ?? '16:00');
    $to   = trim($parts[1] ?? '');
    $mk = function ($hhmm) use ($d, $m) {
        $t = explode(':', $hhmm);
        $h = (int)($t[0] ?? 16); $min = (int)($t[1] ?? 0);
        /* Gulf Standard Time is UTC+4 with no daylight saving */
        return gmdate('Ymd\THis\Z', gmmktime($h - 4, $min, 0, $m, $d, 2026));
    };
    $start = $mk($from);
    $end   = $to !== '' ? $mk($to) : gmdate('Ymd\THis\Z', strtotime($start) + 3600);
    return [$start, $end];
}

function ics_escape($s) {
    return str_replace(["\\", "\n", ",", ";"], ["\\\\", "\\n", "\\,", "\\;"], $s);
}

/* Fold long lines at 75 octets, as the spec requires. */
function ics_line($s) {
    $out = ''; $len = 0;
    foreach (preg_split('//u', $s, -1, PREG_SPLIT_NO_EMPTY) as $ch) {
        $w = strlen($ch);
        if ($len + $w > 73) { $out .= "\r\n "; $len = 1; }
        $out .= $ch; $len += $w;
    }
    return $out;
}

$one = isset($_GET['i']) && isset($CHAMPS[(int)$_GET['i']]);
$events = [];
if ($one) {
    $i = (int)$_GET['i']; $c = $CHAMPS[$i];
    $day  = isset($_GET['d']) ? $_GET['d'] : ($c['sch'][0][0] ?? '06/11');
    $slot = isset($_GET['t']) ? $_GET['t'] : ($c['sch'][0][1] ?? '16:00');
    $events[] = ['i' => $i, 'c' => $c, 'day' => $day, 'slot' => $slot, 'round' => ''];
    $fname = 'kalba-' . $c['s'] . '.ics';
} else {
    foreach ($CHAMPS as $i => $c) {
        foreach ($c['sch'] as $x) {
            $events[] = ['i' => $i, 'c' => $c, 'day' => $x[0], 'slot' => $x[1], 'round' => round_name($x[2])];
        }
    }
    $fname = 'kalba-sports-festival-2026.ics';
}

/* Disposition decides what a phone does with this.
   A single event is served inline: iOS Safari then opens its "Add Event"
   sheet directly instead of dropping a file in Downloads, and Android Chrome
   still hands it to Google Calendar. The whole-programme file is an import,
   so that one is offered as a download.
   text/calendar is what both platforms match on, so it is stated explicitly
   and the filename keeps the .ics extension Android relies on. */
header('Content-Type: text/calendar; charset=utf-8');
header('Content-Disposition: ' . ($one ? 'inline' : 'attachment') . '; filename="' . $fname . '"');
header('Cache-Control: no-store');

$out = ["BEGIN:VCALENDAR", "VERSION:2.0",
        "PRODID:-//Kalba Sports Festival//2026//" . strtoupper(lang()),
        "CALSCALE:GREGORIAN", "METHOD:PUBLISH",
        ics_line("X-WR-CALNAME:" . ics_escape(A('مهرجان كلباء الرياضي 2026', 'Kalba Sports Festival 2026'))),
        "X-WR-TIMEZONE:Asia/Dubai"];

foreach ($events as $n => $ev) {
    $t = ics_times($ev['day'], $ev['slot']);
    if (!$t) continue;
    $title = champ_name($ev['c']) . ($ev['round'] !== '' ? ' — ' . $ev['round'] : '');
    $uid = 'kalba-' . $ev['i'] . '-' . preg_replace('/\D/', '', $ev['day']) . '-' . $n . '@kalbasports';
    $out[] = "BEGIN:VEVENT";
    $out[] = "UID:" . $uid;
    $out[] = "DTSTAMP:" . gmdate('Ymd\THis\Z');
    $out[] = "DTSTART:" . $t[0];
    $out[] = "DTEND:"   . $t[1];
    $out[] = ics_line("SUMMARY:" . ics_escape($title));
    $out[] = ics_line("DESCRIPTION:" . ics_escape(A('منافسة ضمن مهرجان كلباء الرياضي 2026.', 'A competition at Kalba Sports Festival 2026.')));
    $out[] = ics_line("LOCATION:" . ics_escape(A('كورنيش كلباء، الشارقة', 'Kalba Corniche, Sharjah')));
    $out[] = "GEO:25.0757;56.3620";
    /* the 30-minute reminder the requirements ask for, carried by the calendar */
    $out[] = "BEGIN:VALARM";
    $out[] = "TRIGGER:-PT30M";
    $out[] = "ACTION:DISPLAY";
    $out[] = ics_line("DESCRIPTION:" . ics_escape($title));
    $out[] = "END:VALARM";
    $out[] = "END:VEVENT";
}
$out[] = "END:VCALENDAR";
echo implode("\r\n", $out) . "\r\n";
