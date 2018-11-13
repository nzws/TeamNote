<?php
// ルートURL: テスト環境等 http://example.com/hoge/ とかは /hoge/ と記入
$env["RootUrl"] = "/";
$env["domain"] = "example.com";

$env["SiteName"] = "TeamNote";

$env["database"]["host"] = "localhost";
$env["database"]["port"] = 3306;
$env["database"]["db"] = "dbname";
$env["database"]["user"] = "Username";
$env["database"]["pass"] = "Password";

// デバッグモード: ログを常時表示とか色々
$env["is_debug"] = false;

// メンテナンスモード: 全てのAPIとWeb UIをロックし503にします(キャッシュ分は表示されるかも)
$env["is_maintenance"] = false;

// https://push7.jp/
// $env["push7"]["domain"] = "example.app.push7.jp";
// $env["push7"]["appno"] = "";
// $env["push7"]["apikey"] = "";

// 定数: いじらないでね
define('PATH', dirname(__FILE__) . '/');
define('CONF_VERSION', 1); //Devtip: CONF_VERSIONを変えたらlib/bootloader.phpの$ConfigVersionの数字を変える
