<?php
require_once("../../../lib/apiloader.php");
require_once("../../../lib/bootloader.php");

$max_id = $_GET["max_id"] ? s($_GET["max_id"]) : 0;
$mode = s($_GET["mode"]);
$is_admin = $my["role_id"] == 3;

$data = getNoteList($mode, $max_id, $is_admin);
$i = 0;
while (isset($data[$i])) {
  $data[$i]["created_by"] = user4Pub(getUser($data[$i]["created_by"]));
  if (!empty($data[$i]["edited_by"])) $data[$i]["edited_by"] = user4Pub(getUser($data[$i]["edited_by"]));
  $data[$i]["body"] = mb_substr($data[$i]["body"], 0, 100);
  $i++;
}

api_json($data);
