<?php
require_once("../lib/bootloader.php");
$n = getNote(s($_GET["id"]));
if (empty($n)) exit("ERROR:このノートは存在しません。");
if ($n["is_deleted"] == 2) exit("ERROR:このノートは削除済みです。");
if ($n["is_admin"] == 1 && $my["role_id"] != 3) exit("ERROR:このノートは非公開です。");

header("content-type: text/x-markdown; charset=utf-8");
echo $n["body"];
