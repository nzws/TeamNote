<?php
require_once("../../../lib/apiloader.php");
require_once("../../../lib/bootloader.php");

$max_id = $_GET["max_id"] ? s($_GET["max_id"]) : 0;

$data = getComments($_GET["id"], $max_id);
$i = 0;
while (isset($data[$i])) {
  $data[$i]["created_by"] = user4Pub(getUser($data[$i]["created_by"]));
  $i++;
}

api_json($data);
