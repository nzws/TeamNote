<?php
function u($p) {
  global $env;
  return $env["RootUrl"].$p.($env["is_debug"] ? ".php" : "");
}

function s($p) {
  return htmlspecialchars($p, ENT_QUOTES|ENT_HTML5);
}

function checkV($var, $min_length, $max_length) {
  $length = mb_strlen($var);
  return ($length >= $min_length && $length <= $max_length);
}
