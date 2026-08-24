<?php
/* Lazy PDO connection to MySQL. Only opened when a page or action actually needs
   data, so the server-rendered content pages work even before the DB is set up. */

function config() {
  static $cfg = null;
  if ($cfg === null) {
    $file = __DIR__ . '/../config.php';
    $cfg = is_file($file) ? require $file : require __DIR__ . '/../config.sample.php';
  }
  return $cfg;
}

function db() {
  static $pdo = null;
  if ($pdo === null) {
    $c = config()['db'];
    $dsn = "mysql:host={$c['host']};dbname={$c['name']};charset={$c['charset']}";
    $pdo = new PDO($dsn, $c['user'], $c['pass'], [
      PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
      PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
      PDO::ATTR_EMULATE_PREPARES   => false,
    ]);
  }
  return $pdo;
}

/* Small helpers over PDO — all queries are parameterized. */
function db_all($sql, $params = []) { $s = db()->prepare($sql); $s->execute($params); return $s->fetchAll(); }
function db_one($sql, $params = []) { $s = db()->prepare($sql); $s->execute($params); return $s->fetch(); }
function db_run($sql, $params = []) { $s = db()->prepare($sql); $s->execute($params); return $s; }
function db_insert($sql, $params = []) { db_run($sql, $params); return db()->lastInsertId(); }
