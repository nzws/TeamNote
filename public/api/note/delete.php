<?php
require_once("../../../lib/apiloader.php");
require_once("../../../lib/bootloader.php");

$id = s($_POST["id"]);
$mode = s($_POST["mode"]);

if (!isset($mode)) api_json(["error" => "モードが指定されていません。"]);

$n = getNote($id);
if (!$n) api_json(["error" => "ノートの取得に失敗しました。"]);

if ($my["role_id"] != 3 && $n["created_by"]["id"] !== $my["id"] && $mode == 2) api_json(["error" => "本人または権限ユーザー以外は削除できません。"]);

$mysqli = db_start();
$stmt = $mysqli->prepare("UPDATE `note` SET `edited_by` = ?, `edited_at` = CURRENT_TIMESTAMP, `is_deleted` = ? WHERE id = ?;");
$stmt->bind_param("sss", $my["id"], $mode, $id);
$stmt->execute();
$err = $stmt->error;
$stmt->close();
$mysqli->close();

if (!$err && $id) {
  api_json(["id" => $id]);
} else {
  api_json(["error" => "データベースエラー"]);
}
