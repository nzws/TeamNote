<?php
$nologin = true;
require_once("../../../lib/apiloader.php");
require_once("../../../lib/bootloader.php");

if (!verifyInviteCode($_POST["invite_code"])) {
  api_json(["error" => "招待コードが存在しません。"]);
}
$code = s($_POST["invite_code"]);

$user = s($_POST["username"]);
$pass = s($_POST["password"]);
$name = s($_POST["display_name"]);
if (!$user || !$pass || !$name) {
  api_json(["error" => "値が入力されていません。"]);
}

if (!checkV($name, 1, 10)) api_json(["error" => "表示名は1～10文字でお願いします。"]);
if (!checkV($user, 2, 10) || !ctype_alnum($user)) api_json(["error" => "ユーザIDは2～10文字の英数字でお願いします。"]);
if (!checkV($pass, 8, 64)) api_json(["error" => "パスワードは8～64文字でお願いします。"]);

$pass = password_hash($pass, PASSWORD_DEFAULT);

$mysqli = db_start();
$stmt = $mysqli->prepare("UPDATE `users` SET username = ?, display_name = ?, pass_hash = ?, role_id = 2, created_at = CURRENT_TIMESTAMP, ip = ?, config = '{}' WHERE pass_hash = ? AND role_id = 1;");
$stmt->bind_param("sssss", $user, $name, $pass, $_SERVER["REMOTE_ADDR"], $code);
$stmt->execute();
$err = $stmt->error;
$stmt->close();
$mysqli->close();

if (!$err) {
  api_json(["ok" => true]);
} else {
  api_json(["error" => "データベースエラー"]);
}
