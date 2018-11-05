<?php require_once("../lib/bootloader.php"); ?>
<!DOCTYPE html>
<html data-page="home">
<head>
  <?php
  $title = "ホーム";
  include "../include/header.php"; ?>
  <script>
    document.addEventListener("turbolinks:load", function() {
      trends.init();
    })
  </script>
</head>
<body>
<?php include "../include/navbar.php"; ?>
<main>
  <div class="container">
    <div class="row">
      <div class="col-md-9">
        <div class="input-group">
          <div class="input-group-prepend">
            <select class="form-control" id="search_type">
              <option>キーワード</option>
              <option>タグ</option>
            </select>
          </div>
          <input type="text" class="form-control" id="search_text" placeholder="検索ワード..." required>
          <div class="input-group-append">
            <button class="btn btn-primary" type="button" id="search_button"><i class="fas fa-search"></i></button>
          </div>
        </div>

        <div id="home_posts"></div>
        <div id="now_loading" class="center">
          <?=ui_progress()?>
          <b>Now Loading...</b>
        </div>
      </div>
      <div class="col-md-3">
        <b>ピン留め中のノート</b>
      </div>
    </div>
  </div>
</main>

<?php include "../include/footer.php"; ?>
</body>
</html>
