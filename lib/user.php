<?php
function getUser($id, $mode = "") {
  global $userCache;
  if (isset($userCache[$id])) return $userCache[$id];
  if (!$id) return false;
  $mysqli = db_start();
  if ($mode === "user") {
    $stmt = $mysqli->prepare("SELECT * FROM `users` WHERE username = ?;");
  } else {
    $stmt = $mysqli->prepare("SELECT * FROM `users` WHERE id = ?;");
  }
  $stmt->bind_param("s", $id);
  $stmt->execute();
  $row = db_fetch_all($stmt);
  $stmt->close();
  $mysqli->close();

  if (isset($row[0]["id"])) {
    $row[0]["config"] = json_decode($row[0]["config"], true);
  }
  $userCache[$id] = isset($row[0]["id"]) ? $row[0] : false;
  return $userCache[$id];
}

function getMe() {
  return isset($_SESSION["id"]) ? getUser($_SESSION["id"]) : false;
}

function setConfig($id, $conf) {
  $conf = json_encode($conf, true);
  $mysqli = db_start();
  $stmt = $mysqli->prepare("UPDATE `users` SET config = ? WHERE id = ?;");
  $stmt->bind_param("ss", $conf, $id);
  $stmt->execute();
  $stmt->close();
  $mysqli->close();
}

function verifyInviteCode($code) {
  if (empty($code)) return false;
  $code = s($code);
  $mysqli = db_start();
  $stmt = $mysqli->prepare("SELECT * FROM `users` WHERE pass_hash = ? AND role_id = 1;");
  $stmt->bind_param("s", $code);
  $stmt->execute();
  $row = db_fetch_all($stmt);
  $stmt->close();
  $mysqli->close();
  return isset($row[0]);
}

function user4Pub($u) {
  return [
    "id" => $u["id"],
    "username" => $u["username"],
    "display_name" => $u["display_name"],
    "role_id" => $u["role_id"]
  ];
}
