<?php
/* One-time seed: operator accounts (real bcrypt hashes) + the activity points.
   Run once on the server after importing sql/schema.sql:  php tools/seed.php
   Change the passwords below first, or change them later in the admin panel. */
require __DIR__ . '/../lib/db.php';

$accounts = [
  ['admin',     'Kalba@Admin-2026',  'admin',     null],
  ['organizer', 'Kalba@Award-2026',  'organizer', null],
  ['results',   'Kalba@Scores-2026', 'results',   null],
];
foreach ($accounts as [$u, $p, $role, $sport]) {
  db_run(
    'INSERT INTO admin_users (username, pass_hash, role, sport) VALUES (?,?,?,?)
     ON DUPLICATE KEY UPDATE pass_hash=VALUES(pass_hash), role=VALUES(role), sport=VALUES(sport)',
    [$u, password_hash($p, PASSWORD_DEFAULT), $role, $sport]
  );
  echo "seeded account: $u ($role)\n";
}

$activities = [
  ['تحدي القوة', 'Strength Challenge', 'corniche', 50],
  ['سباق الكاياك', 'Kayak Race', 'sea', 40],
  ['الجري على الشاطئ', 'Beach Run', 'corniche', 30],
  ['تحدي المانغروف', 'Mangrove Challenge', 'mangrove', 35],
  ['هايك الجبل', 'Mountain Hike', 'mountains', 45],
  ['زيارة المزرعة', 'Farm Visit', 'farms', 20],
];
foreach ($activities as [$ar, $en, $zone, $pts]) {
  db_run('INSERT INTO activities (name_ar, name_en, zone, points) VALUES (?,?,?,?)', [$ar, $en, $zone, $pts]);
}
echo "seeded " . count($activities) . " activities\n";
echo "done.\n";
