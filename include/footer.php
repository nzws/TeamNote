<div class="footer mt-5 mb-4 container center">
  TeamNote Project by T氏 & nzws / <a href="https://github.com/yuzulabo/TeamNote" target="_blank"><i class="fab fa-github fa-fw"></i> GitHub</a> / <a href="mailto:webmaster@nzws.me" target="_blank">Contact</a>
<?php if (isset($env["push7"]["domain"]) && !empty($my)) : ?>
  <br>
  <h4><a href="https://<?=$env["push7"]["domain"]?>" target="_blank">新規投稿をプッシュ通知</a></h4>
<?php endif; ?>
</div>

<script src="<?=$env["RootUrl"]?>js/bundle.min.js?t=<?=filemtime(PATH."/public/js/bundle.min.js")?>"></script>
