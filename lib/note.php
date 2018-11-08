<?php
function getNoteList($mode = "home", $max_id = 0, $is_admin = false) {
  $mysqli = db_start();
  $sql = $mode === "pinned" ? "(pinned != '' AND pinned IS NOT NULL)" : "(pinned = '' OR pinned IS NULL)";
  $sql = $mode === "admin" ? "is_admin = 1" : $sql;
  $is_deleted = $mode === "archive" ? 1 : 0;
  if ($is_admin) {
    $stmt = $mysqli->prepare("SELECT * FROM `note` WHERE {$sql} AND id > ? AND is_deleted = ? ORDER BY id DESC LIMIT 50;");
  } else {
    $stmt = $mysqli->prepare("SELECT * FROM `note` WHERE {$sql} AND is_admin = 0 AND id > ? AND is_deleted = ? ORDER BY id DESC LIMIT 50;");
  }
  $stmt->bind_param("ss", $max_id, $is_deleted);
  $stmt->execute();
  $row = db_fetch_all($stmt);
  $stmt->close();
  $mysqli->close();
  return $row;
}

function getNoteSearch($word, $page = 0, $is_admin = false, $is_deleted = 0) {
  $mysqli = db_start();
  $max_id = $page * 50;
  if ($is_admin) {
    $stmt = $mysqli->prepare("SELECT * FROM `note` WHERE MATCH(`title`, `body`) AGAINST(?) AND is_deleted = ? ORDER BY MATCH (`title`, `body`) AGAINST (?) DESC LIMIT ?, 50;");
  } else {
    $stmt = $mysqli->prepare("SELECT * FROM `note` WHERE MATCH(`title`, `body`) AGAINST(?) AND is_admin = 0 AND is_deleted = ? ORDER BY MATCH (`title`, `body`) AGAINST (?) DESC LIMIT ?, 50;");
  }
  $stmt->bind_param("ssss", $word, $is_deleted, $word, $max_id);
  $stmt->execute();
  $row = db_fetch_all($stmt);
  $stmt->close();
  $mysqli->close();
  return $row;
}

function getNote($id) {
  $mysqli = db_start();
  $stmt = $mysqli->prepare("SELECT * FROM `note` WHERE id = ?;");
  $stmt->bind_param("s", $id);
  $stmt->execute();
  $row = db_fetch_all($stmt);
  $stmt->close();
  $mysqli->close();
  if (!empty($row[0]["created_by"])) $row[0]["created_by"] = getUser($row[0]["created_by"]);
  if (!empty($row[0]["edited_by"])) $row[0]["edited_by"] = getUser($row[0]["edited_by"]);
  return $row[0];
}
