<?php
/* Write side of the results pipeline: add, update or remove a fixture.
   Guarded the same way the screen is, and a scoped operator is held to
   their own sport on the server, not merely in the interface. */
require_once __DIR__ . '/../lib/render.php';
require_once __DIR__ . '/../lib/auth.php';
require_once __DIR__ . '/../lib/security.php';

$u = current_user();
function back_to($slug, $q = '') {
    sec_redirect('scores.php?s=' . rawurlencode($slug) . ($q !== '' ? '&' . $q : ''));
}

if (!$u || !role_can($u['role'], 'results')) { sec_redirect('gate.php'); }
if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !csrf_valid()) { sec_redirect('scores.php'); }
if (!rate_ok('score', 240, 600)) { sec_redirect('scores.php?err=rate'); }

$slug = clean_text($_POST['sport'] ?? '', 40);
$do   = clean_text($_POST['do'] ?? '', 10);

/* the slug must name a real sport, and the operator must be allowed it */
$known = false;
foreach (content()['CHAMPS'] as $c) if ($c['s'] === $slug) { $known = true; break; }
if (!$known) sec_redirect('scores.php?err=1');
if (!empty($u['sport']) && $u['sport'] !== $slug) back_to($u['sport'], 'err=scope');

try {
    if ($do === 'add') {
        $a = clean_text($_POST['side_a'] ?? '', 120);
        $b = clean_text($_POST['side_b'] ?? '', 120);
        $day = clean_text($_POST['day'] ?? '', 8);
        if ($a === '' || $b === '' || !preg_match('#^\d{2}/\d{2}$#', $day)) back_to($slug, 'err=1');
        db_run('INSERT INTO matches (sport, day, side_a_ar, side_a_en, side_b_ar, side_b_en, status)
                VALUES (?,?,?,?,?,?,\'upcoming\')', [$slug, $day, $a, $a, $b, $b]);
        db_run("INSERT INTO audit_log (event, actor, detail) VALUES ('match.add', ?, ?)",
               [$u['username'], $slug . ': ' . $a . ' v ' . $b]);
        back_to($slug, 'ok=1');
    }

    $id = (int) ($_POST['id'] ?? 0);
    if ($id <= 0) back_to($slug, 'err=1');
    /* never trust the posted sport alone — confirm the row really is that sport */
    $row = db_one('SELECT id, sport FROM matches WHERE id = ?', [$id]);
    if (!$row || $row['sport'] !== $slug) back_to($slug, 'err=1');

    if ($do === 'delete') {
        db_run('DELETE FROM matches WHERE id = ?', [$id]);
        db_run("INSERT INTO audit_log (event, actor, detail) VALUES ('match.delete', ?, ?)",
               [$u['username'], $slug . ' #' . $id]);
        back_to($slug, 'ok=1');
    }

    /* save: blank score means "not played yet", any number is clamped sane */
    $sa = ($_POST['score_a'] ?? '') === '' ? null : max(0, min(999, (int) $_POST['score_a']));
    $sb = ($_POST['score_b'] ?? '') === '' ? null : max(0, min(999, (int) $_POST['score_b']));
    $status = $_POST['status'] ?? 'upcoming';
    if (!in_array($status, ['upcoming', 'live', 'finished'], true)) $status = 'upcoming';
    /* a fixture cannot be final without both scores — the standings would
       silently count it as a 0-0 draw */
    if ($status === 'finished' && ($sa === null || $sb === null)) back_to($slug, 'err=1');

    db_run('UPDATE matches SET score_a = ?, score_b = ?, status = ? WHERE id = ?', [$sa, $sb, $status, $id]);
    db_run("INSERT INTO audit_log (event, actor, detail) VALUES ('match.score', ?, ?)",
           [$u['username'], $slug . ' #' . $id . ' ' . ($sa ?? '-') . ':' . ($sb ?? '-') . ' ' . $status]);
    back_to($slug, 'ok=1');

} catch (Throwable $ex) {
    back_to($slug, 'err=1');
}
