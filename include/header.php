<meta charset=utf-8>
<meta name="viewport" content="initial-scale=1.0"/>
<title><?php echo $title ? "{$title} - ": ""; ?><?=$env["SiteName"]?></title>

<script>
  const API = {
    suffix: "<?=($env["is_debug"] ? ".php" : "")?>",
    endpoint: "<?=$env["RootUrl"]?>api/",
    csrf: "<?=$_SESSION['csrf_token']?>"
  };
</script>
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.4.2/css/all.css" integrity="sha384-/rXc/GQVaYpyDdyxK+ecHPVYJSN9bmVFBvjA/9eOB+pb3F2w2N6fc5qB9Ew5yIns" crossorigin="anonymous">
<link rel="stylesheet" href="<?=$env["RootUrl"]?>css/style.min.css?t=<?=filemtime(PATH."/public/css/style.min.css")?>" />
<script src="<?=$env["RootUrl"]?>js/bundle.min.js?t=<?=filemtime(PATH."/public/js/bundle.min.js")?>"></script>
