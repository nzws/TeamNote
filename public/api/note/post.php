<?php
require_once("../../../lib/apiloader.php");
require_once("../../../lib/bootloader.php");

$title = s($_POST["title"]);
//$tags = json_decode($_POST["tags"]);
$body = s($_POST["body"]);
$body = str_replace('&gt;', '>', $body); //Markdownの引用がぶっ壊れる
$edit = s($_POST["edit_id"]);
$pin = s($_POST["pin"]);

$is_admin = $_POST["is_admin"] == 1 ? 1 : 0;

if (!checkV($title, 1, 100)) api_json(["error" => "タイトルは1～100文字でお願いします。"]);
if (!checkV($pin, 0, 100)) api_json(["error" => "ピン留め説明は0～100文字でお願いします。"]);

$mysqli = db_start();
if ($edit) {
  $stmt = $mysqli->prepare("UPDATE `note` SET `title` = ?, `body` = ?, `edited_by` = ?, `is_admin` = ?, `edited_at` = CURRENT_TIMESTAMP, `pinned` = ? WHERE id = ?;");
  $stmt->bind_param("ssssss", $title, $body, $my["id"], $is_admin, $pin, $edit);
} else {
  $stmt = $mysqli->prepare("INSERT INTO `note` (`title`, `body`, `created_by`, `is_admin`, `pinned`) VALUES (?, ?, ?, ?, ?);");
  $stmt->bind_param("sssss", $title, $body, $my["id"], $is_admin, $pin);
}
$stmt->execute();
$err = $stmt->error;
$id = $stmt->insert_id;
$stmt->close();
$mysqli->close();

if ($edit) $id = $edit;

if (!$err && $id) {
  api_json(["id" => $id]);
} else {
  api_json(["error" => "データベースエラー"]);
}
