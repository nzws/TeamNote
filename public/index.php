<?php
$nologin = true;
require_once("../lib/bootloader.php");
if (isset($_SESSION["id"])) {
  header("Location: " . u("home"));
  exit();
}
?>
<!DOCTYPE html>
<html data-page="index">
<head>
  <?php
  $title = "ログイン";
  include "../include/header.php"; ?>
</head>
<body>
<a href="https://github.com/yuzulabo/TeamNote" target="_blank" class="github_ribbon">
  <img src="https://s3.amazonaws.com/github/ribbons/forkme_right_darkblue_121621.png" alt="Fork me on GitHub">
</a>

<main class="center">
  <div class="container">
    <h2>TeamNote</h2>
    <h3>メンバーログイン</h3>
    <div class="col-md-4 offset-md-4 form" id="login_form">

      <div class="input-group mb-4">
        <div class="input-group-prepend">
          <span class="input-group-text"><i class="fas fa-user fa-fw"></i></span>
        </div>
        <input type="text" class="form-control" id="login_username" placeholder="User ID">
      </div>

      <div class="input-group mb-4">
        <div class="input-group-prepend">
          <span class="input-group-text"><i class="fas fa-key fa-fw"></i></span>
        </div>
        <input type="password" class="form-control" id="login_password" placeholder="Password">
      </div>

      <button class="btn btn-primary btn-block" onclick="login.login()">ログイン</button>

      <hr>

      <h4>新規登録</h4>

      <div class="input-group mb-4">
        <div class="input-group-prepend">
          <span class="input-group-text"><i class="fas fa-user-tag fa-fw"></i></span>
        </div>
        <input type="text" class="form-control" id="reg_invite_code" placeholder="招待コード">
        <div class="input-group-append">
          <button class="btn btn-primary" type="button" onclick="login.verifyInviteCode()"><i class="fas fa-chevron-right fa-fw"></i></button>
        </div>
      </div>
    </div>


    <div class="col-md-4 offset-md-4 form" id="register_form" style="display: none">

      <button class="btn btn-primary btn-block" onclick="login.show('login')">ログイン</button>
      <hr>

      <div class="input-group">
        <div class="input-group-prepend">
          <span class="input-group-text"><i class="fas fa-user-friends fa-fw"></i></span>
        </div>
        <input type="text" class="form-control" id="reg_display_name" placeholder="表示名">
      </div>
      <small class="form-text text-muted mb-4">ノートの投稿者名などに表示されます(変更可) 1～15文字</small>

      <div class="input-group">
        <div class="input-group-prepend">
          <span class="input-group-text"><i class="fas fa-user fa-fw"></i></span>
        </div>
        <input type="text" class="form-control" id="reg_username" placeholder="User ID">
      </div>
      <small class="form-text text-muted mb-4">ログイン時に使用 2～10文字の英数字</small>

      <div class="input-group">
        <div class="input-group-prepend">
          <span class="input-group-text"><i class="fas fa-key fa-fw"></i></span>
        </div>
        <input type="password" class="form-control" id="reg_password" placeholder="Password">
      </div>
      <small class="form-text text-muted mb-4">8～64文字</small>

      <div class="input-group mb-4">
        <div class="input-group-prepend">
          <span class="input-group-text"><i class="fas fa-key fa-fw"></i></span>
        </div>
        <input type="password" class="form-control" id="reg_password_2" placeholder="Password (再度入力)">
      </div>

      <button class="btn btn-info btn-block" onclick="login.register()">新規登録</button>
    </div>

    <div class="center now_loading" style="display: none">
      <?=ui_progress()?>
    </div>
  </div>
</main>

<?php include "../include/footer.php"; ?>
</body>
</html>
