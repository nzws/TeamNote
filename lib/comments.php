<?php
function getComments($id, $max_id = 0) {
  $mysqli = db_start();
  $stmt = $mysqli->prepare("SELECT * FROM `comments` WHERE note_id = ? AND id > ? AND is_deleted = 0 ORDER BY id DESC LIMIT 50;");
  $stmt->bind_param("ss", $id, $max_id);
  $stmt->execute();
  $row = db_fetch_all($stmt);
  $stmt->close();
  $mysqli->close();
  return $row;
}
