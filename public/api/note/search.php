<?php
require_once("../../../lib/apiloader.php");
require_once("../../../lib/bootloader.php");

$page = $_GET["page"] ? s($_GET["page"]) : 0;
$word = urldecode($_GET["word"]);
$is_admin = $my["role_id"] == 3;

$data = getNoteSearch($word, $page, $is_admin);
$i = 0;
while (isset($data[$i])) {
  $data[$i]["created_by"] = user4Pub(getUser($data[$i]["created_by"]));
  if (!empty($data[$i]["edited_by"])) $data[$i]["edited_by"] = user4Pub(getUser($data[$i]["edited_by"]));
  $data[$i]["body"] = mb_substr($data[$i]["body"], 0, 100);
  $i++;
}

api_json($data);
