<?php
require_once("../lib/bootloader.php");
if (isset($_GET["edit_id"])) { //編集モード
  $is_edit = true;
  $n = getNote(s($_GET["edit_id"]));
  if (!$n) exit("ERR:ノートが存在しません。");
} else {
  $is_edit = false;
  $n = [];
}
$tags = null;
$title = $is_edit ? $n["title"] . "を編集" : "新規投稿";
?>
<!DOCTYPE html>
<html data-page="new">
<head>
  <?php include "../include/header.php"; ?>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tui-editor@1.2.6/dist/tui-editor.min.css" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tui-editor@1.2.6/dist/tui-editor-contents.min.css" />
</head>
<body>
<?php include "../include/navbar.php"; ?>
<main>
  <div class="container">
    <h2><?=$title?></h2>
    <div class="form-group">
      <label>タイトル</label>
      <input type="text" class="form-control" id="title" required value="<?=$n["title"]?>">
    </div>
    <!--
    <div class="form-group">
      <label>タグ</label>
      <input type="text" class="form-control" id="tags" value="<?=$tags?>">
      <small class="form-text text-muted">カンマで区切る (例: 行事,予定 など)</small>
    </div>
    -->
    <div id="post"></div>
    <div class="custom-control custom-checkbox">
      <input type="checkbox" class="custom-control-input" id="only_admin" <?=($my["role_id"] == 3 ? "" : "disabled")?> <?=($n["is_admin"] ? "checked" : "")?>>
      <label class="custom-control-label" for="only_admin">特権ユーザー以外は閲覧できないようにする（非公開投稿）</label>
    </div>
    <div class="form-group mt-4">
      <label>ピン留め</label>
      <input type="text" class="form-control" id="pin" value="<?=$n["pinned"]?>">
      <small class="form-text text-muted">ピン留めするとダッシュボードの右側に強調表示されます (空欄で解除)</small>
    </div>
    <input type="hidden" value="<?=(isset($n["id"]) ? $n["id"] : "")?>" id="edit_id">
    <div class="form-group mt-4">
      <button class="btn btn-primary btn-lg btn-block" onclick="post.post(editor.getValue())">:: 投稿 ::</button>
    </div>
  </div>
</main>
<?php include "../include/footer.php"; ?>
<script>
  let editor;
  window.onload = function() {
<?php if (isset($n["id"])) : ?>
    note.get_note(<?=$n["id"]?>).then(text => {
      load(text);
    });
<?php else : ?>
    load();
<?php endif; ?>
  };

  function load(text = "") {
    editor = new Editor({
      el: elemId("post"),
      initialEditType: 'wysiwyg',
      previewStyle: 'vertical',
      height: '400px',
      initialValue: text
    });
  }
</script>
</body>
</html>
