<?php
require_once("../lib/bootloader.php");
$n = getNote(s($_GET["id"]));
if (empty($n)) exit("ERROR:このノートは存在しません。");
if ($n["is_deleted"] == 2) exit("ERROR:このノートは削除済みです。");
if ($n["is_admin"] == 1 && $my["role_id"] != 3) exit("ERROR:このノートは非公開です。");
?>
<!DOCTYPE html>
<html data-page="note">
<head>
  <?php
  $title = $n["title"] . " - ノート";
  include "../include/header.php"; ?>
</head>
<body>
<?php include "../include/navbar.php"; ?>
<main>
  <div class="container">
    <div class="row">
      <div class="col-md-9">
        <div class="shadow-sm p-3 mb-3 bg-white rounded">
          <h3><?=$n["title"]?></h3>
          <?php if ($n["is_admin"] == 1) : ?>
            <span class="badge badge-warning"><i class="fas fa-user-lock fa-fw"></i> 閲覧制限</span>
          <?php endif; ?>
          <?php if ($n["is_deleted"] == 1) : ?>
            <span class="badge badge-warning"><i class="fas fa-archive fa-fw"></i> アーカイブ中</span>
          <?php endif; ?>
          <div class="text-secondary show_pc">
            <?php if ($n["edited_by"]) : ?>
              編集: <i class="fas fa-clock fa-fw"></i> <?=$n["edited_at"]?> · <i class="fas fa-user-edit fa-fw"></i> <?=$n["edited_by"]["display_name"]?><br>
            <?php endif; ?>
            投稿: <i class="far fa-clock fa-fw"></i> <?=$n["created_at"]?> · <i class="fas fa-user fa-fw"></i> <?=$n["created_by"]["display_name"]?>
          </div>
          <div class="text-secondary show_smp">
            <?php if ($n["edited_by"]) : ?>
              <p>
                <small>
                  編集: <i class="fas fa-clock fa-fw"></i> <?=$n["edited_at"]?><br>
                  <i class="fas fa-user-edit fa-fw"></i> <?=$n["edited_by"]["display_name"]?>
                </small>
              </p>
            <?php endif; ?>
            <p>
              <small>
                投稿: <i class="far fa-clock fa-fw"></i> <?=$n["created_at"]?><br>
                <i class="fas fa-user fa-fw"></i> <?=$n["created_by"]["display_name"]?>
              </small>
            </p>
          </div>
          <hr>
          <a href="<?=(u("new") . "?edit_id=" . $n["id"])?>" class="btn btn-outline-info btn-sm"><i class="fas fa-pen fa-fw"></i> 編集</a>
          <?php if ($n["is_deleted"] == 1) : ?>
            <button class="btn btn-outline-success btn-sm" onclick="note.delete(<?=$n["id"]?>, 0)"><i class="fas fa-archive fa-fw"></i> アーカイブから戻す</button>
          <?php else : ?>
            <button class="btn btn-outline-warning btn-sm" onclick="note.delete(<?=$n["id"]?>, 1)"><i class="fas fa-archive fa-fw"></i> アーカイブ</button>
          <?php endif; ?>
          <?php if ($my["role_id"] == 3 || $n["created_by"]["id"] === $my["id"]) : ?>
            <button class="btn btn-outline-danger btn-sm" onclick="note.delete(<?=$n["id"]?>, 2)"><i class="fas fa-trash-alt fa-fw"></i> 削除</button>
          <?php endif; ?>
        </div>
        <div class="shadow-sm p-3 bg-white rounded" id="note"><?=$n["body"]?></div>
      </div>
      <div class="col-md-3">
        <b>コメント</b>
        <div class="form-group">
          <textarea class="form-control" id="com_textarea" rows="3" placeholder="コメント... (Markdown記法が使用できます)"></textarea>
        </div>
        <div class="input-group">
          <button class="btn btn-outline-primary" onclick="note.post_comment(<?=$n["id"]?>)">コメント</button>
        </div>
        <hr>
        <div id="comments" class="list"></div>
      </div>
    </div>
  </div>
</main>

<script id="com_tmpl" type="text/x-handlebars-template">
  <div class="card mb-3">
    <div class="card-body">
      <h6 class="card-subtitle mb-2 text-muted"><i class="fas fa-comment fa-fw"></i> {{created_by.display_name}}</h6>
      <p class="card-text">{{{body}}}</p>
    </div>
  </div>
</script>
<?php include "../include/footer.php"; ?>
<script>
  window.onload = function() {
    note.view_comment(<?=$n["id"]?>);

    const n = elemId("note");
    n.innerHTML = markdown(n.innerHTML);
  }
</script>
</body>
</html>
