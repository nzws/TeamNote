<?php
$nologin = true;
require_once("../../../lib/apiloader.php");
require_once("../../../lib/bootloader.php");

$user = s($_POST["username"]);
$pass = s($_POST["password"]);
if (!$user || !$pass) {
  api_json(["error" => "値が入力されていません。"]);
}

$mysqli = db_start();
$stmt = $mysqli->prepare("SELECT * FROM `users` WHERE username = ? AND role_id != 0 AND role_id != 1;");
$stmt->bind_param("s", $user);
$stmt->execute();
$row = db_fetch_all($stmt);
$stmt->close();
$mysqli->close();

if (isset($row[0]) && password_verify($pass, $row[0]["pass_hash"])) {
  $_SESSION["id"] = $row[0]["id"];
  api_json(["ok" => true]);
} else {
  api_json(["error" => "ユーザIDかパスワードが一致しません。"]);
}
