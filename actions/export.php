<?php
/* CSV export of registrations for the organising committee. Opens directly in
   Excel; a UTF-8 BOM is written first so Arabic names are not mangled there. */
require_once __DIR__ . '/../lib/render.php';
require_once __DIR__ . '/../lib/auth.php';
/* same guard as the panel itself: only a signed-in admin may export */
require_view('admin');

$set  = isset($_GET['set']) ? trim($_GET['set']) : '';
$type = isset($_GET['type']) ? trim($_GET['type']) : '';

/* contact messages and newsletter subscribers export the same way */
if ($set === 'messages' || $set === 'subscribers') {
    $name = 'kalba-' . $set . '-' . date('Ymd-Hi') . '.csv';
    header('Content-Type: text/csv; charset=utf-8');
    header('Content-Disposition: attachment; filename="' . $name . '"');
    $out = fopen('php://output', 'w');
    fwrite($out, chr(0xEF) . chr(0xBB) . chr(0xBF));
    try {
        if ($set === 'messages') {
            fputcsv($out, ['Name', 'Email', 'Message', 'Received'], ',', '"', '');
            foreach (db_all('SELECT name, email, body, created_at FROM messages ORDER BY id DESC') as $r)
                fputcsv($out, [$r['name'], $r['email'], $r['body'], $r['created_at']], ',', '"', '');
        } else {
            fputcsv($out, ['Email', 'Subscribed'], ',', '"', '');
            foreach (db_all('SELECT email, created_at FROM subscribers ORDER BY id DESC') as $r)
                fputcsv($out, [$r['email'], $r['created_at']], ',', '"', '');
        }
    } catch (Throwable $ex) { /* an empty file is clearer than a fatal */ }
    fclose($out);
    exit;
}
$rows = [];
try {
  $rows = $type !== ''
    ? db_all('SELECT ref, type, name, email, phone, status, created_at, payload FROM applications WHERE type = ? ORDER BY created_at DESC', [$type])
    : db_all('SELECT ref, type, name, email, phone, status, created_at, payload FROM applications ORDER BY created_at DESC');
} catch (Throwable $ex) { $rows = []; }

$name = 'kalba-registrations-' . ($type !== '' ? preg_replace('/[^a-z0-9-]/i', '', $type) . '-' : '') . date('Ymd-Hi') . '.csv';
header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename="' . $name . '"');

$out = fopen('php://output', 'w');
fwrite($out, chr(0xEF) . chr(0xBB) . chr(0xBF));   /* UTF-8 BOM, so Excel reads Arabic correctly */
fputcsv($out, ['Reference', 'Type', 'Name', 'Email', 'Phone', 'Status', 'Submitted', 'Team', 'Squad'], ',', '"', '');
foreach ($rows as $r) {
  $pl = $r['payload'] ? (json_decode($r['payload'], true) ?: []) : [];
  $squad = isset($pl['players']) && is_array($pl['players']) ? implode(' / ', $pl['players']) : '';
  fputcsv($out, [$r['ref'], $r['type'], $r['name'], $r['email'], $r['phone'],
                 $r['status'], $r['created_at'], $pl['team_name'] ?? '', $squad], ',', '"', '');
}
fclose($out);
