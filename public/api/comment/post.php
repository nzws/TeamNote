<?php
require_once("../../../lib/apiloader.php");
require_once("../../../lib/bootloader.php");

$body = s($_POST["body"]);
$body = str_replace('&gt;', '>', $body); //Markdownの引用がぶっ壊れる
$note_id = s($_POST["note_id"]);

if (!checkV($body, 1, 500)) api_json(["error" => "コメントは1～500文字でお願いします。"]);

$mysqli = db_start();
$stmt = $mysqli->prepare("INSERT INTO `comments` (`note_id`, `body`, `created_by`) VALUES (?, ?, ?);");
$stmt->bind_param("sss", $note_id, $body, $my["id"]);
$stmt->execute();
$err = $stmt->error;
$id = $stmt->insert_id;
$stmt->close();
$mysqli->close();

if (!$err && $id) {
  api_json(["ok" => true]);
} else {
  api_json(["error" => "データベースエラー"]);
}
