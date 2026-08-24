<?php
/* Copy this file to config.php on the server and fill in your cPanel MySQL details.
   config.php is gitignored so credentials never enter version control. */
return [
  'db' => [
    'host'    => 'localhost',
    'name'    => 'kalba_festival',   // the database you create in cPanel > MySQL Databases
    'user'    => 'kalba_user',       // the DB user you create and add to that database
    'pass'    => 'CHANGE_ME',
    'charset' => 'utf8mb4',
  ],
  // Any real deployment must change this — it salts the session cookie name only.
  'app_key' => 'kalba-2026',
];
