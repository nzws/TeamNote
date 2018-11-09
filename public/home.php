<?php require_once("../lib/bootloader.php"); ?>
<!DOCTYPE html>
<html data-page="home">
<head>
  <?php
  $title = "ホーム";
  include "../include/header.php"; ?>
</head>
<body>
<?php include "../include/navbar.php"; ?>
<main>
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-9 order-12 order-md-11">
        <div class="input-group">
          <input type="text" class="form-control" id="search_text" placeholder="検索ワード..." required>
          <div class="input-group-append">
            <button class="btn btn-primary" type="button" id="search_button" onclick="home.search(0)"><i class="fas fa-search"></i></button>
          </div>
        </div>

        <ul class="nav justify-content-center">
          <li class="nav-item">
            <a class="nav-link active" href="javascript:home.list('home')">全て</a>
          </li>
          <?php if ($my["role_id"] == 3) : ?>
          <li class="nav-item">
            <a class="nav-link" href="javascript:home.list('admin')"><i class="fas fa-user-lock fa-fw"></i> 閲覧制限中</a>
          </li>
          <?php endif; ?>
          <li class="nav-item">
            <a class="nav-link" href="javascript:home.list('archive')"><i class="fas fa-archive fa-fw"></i> アーカイブ中</a>
          </li>
        </ul>

        <div id="home_posts" class="card-columns list"></div>
        <div id="search_posts" class="list" style="display: none;">
          <h3><span id="search_result_text"></span>の検索結果</h3>
          <div class="card-columns" id="search_posts_content"></div>
        </div>
        <div id="admin_posts" class="card-columns list" style="display: none;"></div>
        <div id="archive_posts" class="card-columns list" style="display: none;"></div>
      </div>
      <div class="col-md-3 order-11 order-md-12 mb-4">
        <b>ピン留め中のノート</b>

        <div id="pinned_posts" class="list"></div>
      </div>
    </div>
  </div>
</main>

<script id="card_tmpl" type="text/x-handlebars-template">
  {{#if pinned}}
    <div class="card pinned">
  {{else}}
    <div class="card">
  {{/if}}
    <div class="card-body">
      <a href="<?=u("note")?>?id={{id}}" class="card_link">
      {{#if pinned}}
      <p class="card-text text-warning"><small><i class="fas fa-thumbtack fa-fw"></i> {{pinned}}</small></p>
      {{/if}}
      <h5 class="card-title">
        {{title}}
        {{#if is_admin}}
          <span class="badge badge-warning"><i class="fas fa-user-lock fa-fw"></i></span>
        {{/if}}
      </h5>
      <p class="card-text">{{{body}}}</p>
      <p class="card-text">
        <small class="text-muted">
          {{#if edited_by}}
            編集<i class="fas fa-clock fa-fw"></i>: {{edited_at}}<br>
            {{#if edited_by_others}}
              編集者: {{edited_by.display_name}}<br>
            {{/if}}
          {{/if}}
            作成<i class="far fa-clock fa-fw"></i>: {{created_at}}<br>
            作成者: {{created_by.display_name}}
        </small>
      </p>
      </a>
    </div>
  </div>
</script>
<?php include "../include/footer.php"; ?>
<script>
  window.onload = function() {
    home.list("home");
    home.list("pinned");
  }
</script>
</body>
</html>
