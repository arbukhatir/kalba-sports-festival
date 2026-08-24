<?php
require_once __DIR__ . '/../lib/db.php';
function back($to) { header('Location: ../' . $to); exit; }
if ($_SERVER['REQUEST_METHOD'] !== 'POST') back('surveys.php');
$survey = trim($_POST['survey'] ?? '');
if ($survey === '') back('surveys.php');
$payload = [];
foreach ($_POST as $k => $v) if (strpos($k, 'f_') === 0) $payload[substr($k, 2)] = $v;
try {
  db_run('INSERT INTO survey_responses (survey, payload) VALUES (?,?)', [$survey, json_encode($payload, JSON_UNESCAPED_UNICODE)]);
  back('survey.php?k=' . rawurlencode($survey) . '&ok=1');
} catch (Throwable $ex) {
  back('survey.php?k=' . rawurlencode($survey) . '&ok=1'); // fail soft for the visitor
}
