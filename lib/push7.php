<?php
function sendPush7($title, $body, $url) {
  global $env;
  if (empty($env["push7"]["apikey"]) || empty($env["push7"]["appno"])) return;

  post("https://api.push7.jp/api/v1/{$env["push7"]["appno"]}/send", [
    "title" => "TeamNote: " . $title,
    "body" => $body,
    "url" => $url,
    "icon" => "https://dashboard.push7.jp/uploads/034a359ed2874f788da3c508e973652b.png",
    "apikey" => $env["push7"]["apikey"]
  ]);
}

function post($url, $data) {
  $header = [
    'Content-Type: application/json'
  ];

  $options = array('http' => array(
    'method' => 'POST',
    'content' => json_encode($data),
    'header' => implode(PHP_EOL,$header)
  ));
  $options = stream_context_create($options);
  $contents = file_get_contents($url, false, $options);
  return json_decode($contents,true);
}
