<?php
require_once __DIR__ . '/../lib/db.php';
require_once __DIR__ . '/../lib/security.php';
function back($to) { header('Location: ../' . $to); exit; }
guard_post('surveys.php', 'survey', 10, 600);
$survey = clean_text($_POST['survey'] ?? '', 40);
if ($survey === '') back('surveys.php');
$payload = [];
$payload = clean_payload($_POST, 60, 500);
try {
  db_run('INSERT INTO survey_responses (survey, payload) VALUES (?,?)', [$survey, json_encode($payload, JSON_UNESCAPED_UNICODE)]);
  back('survey.php?k=' . rawurlencode($survey) . '&ok=1');
} catch (Throwable $ex) {
  /* telling a visitor their answers were saved when they were not is worse
     than telling them to try again */
  back('survey.php?k=' . rawurlencode($survey) . '&err=1');
}
