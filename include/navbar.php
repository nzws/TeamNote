<nav class="navbar navbar-expand-lg navbar-light">
  <a class="navbar-brand" href="<?=u("home")?>"><?=$env["SiteName"]?></a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item">
        <a class="nav-link" href="<?=u("home")?>"><i class="fas fa-th-large fa-fw"></i> ダッシュボード</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="<?=u("tags")?>"><i class="fas fa-tags fa-fw"></i> タグ一覧</a>
      </li>
    </ul>
    <ul class="navbar-nav ml-auto">
      <form class="form-inline">
        <a class="btn btn-outline-warning" href="<?=u("new")?>"><b>新規投稿</b></a>
      </form>

      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle mr-sm-2" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <?=$my["display_name"]?>
        </a>
        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
          <a class="dropdown-item" href="<?=u("new")?>">新規投稿</a>
          <a class="dropdown-item" href="<?=u("settings")?>">設定</a>
          <a class="dropdown-item" href="<?=u("logout")?>">ログアウト</a>
        </div>
      </li>
    </ul>
  </div>
</nav>
<div class="now_loading" style="display: none">
  <div class="progress">
    <div class="progress-bar bg-transparent"></div>
    <div class="progress-bar pg-main"></div>
  </div>
</div>
