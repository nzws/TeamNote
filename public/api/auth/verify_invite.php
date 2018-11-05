<?php
$nologin = true;
require_once("../../../lib/apiloader.php");
require_once("../../../lib/bootloader.php");

if (verifyInviteCode($_POST["invite_code"])) {
  api_json(["ok" => true]);
} else {
  api_json(["error" => "招待コードが存在しません。"]);
}
