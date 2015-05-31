<?
function getIp() {
  if ($HTTP_SERVER_VARS["HTTP_X_FORWARDED_FOR"]) {
    $ip = $HTTP_SERVER_VARS["HTTP_X_FORWARDED_FOR"];
  } elseif ($HTTP_SERVER_VARS["HTTP_CLIENT_IP"]) {
    $ip = $HTTP_SERVER_VARS["HTTP_CLIENT_IP"];
  } elseif ($HTTP_SERVER_VARS["REMOTE_ADDR"]) {
    $ip = $HTTP_SERVER_VARS["REMOTE_ADDR"];
  } elseif (getenv("HTTP_X_FORWARDED_FOR")) {
    $ip = getenv("HTTP_X_FORWARDED_FOR");
  } elseif (getenv("HTTP_CLIENT_IP")) {
    $ip = getenv("HTTP_CLIENT_IP");
  } elseif (getenv("REMOTE_ADDR")) {
    $ip = getenv("REMOTE_ADDR");
  } else {
    $ip = "Unknown";
  }
  return "IP: ".$ip;
}

function getCookie() {
  $cookie;
  foreach($_COOKIE as $c => & $v) {
    $cookie_value = $c."=".$v;
    $cookie = empty($cookie) ? $cookie_value : $cookie."|".$cookie_value;
  }
  return $cookie;
}

function saveLog() {
  $agent = 'AGENT: '.$_SERVER['HTTP_USER_AGENT'];
  $t = strftime("%Y%m%d %H:%M:%S %A" ,time()); 
  $ip = getIp();
  $cookie = getCookie();
  $line = $ip.", ".$agent.", ".$t;
  $file = "cinfo.data";
  $fh = fopen($file, "a+");
  fwrite($fh, $line.", ".$cookie."\r\n");
  fclose($fh);
  return $line;
}
?>
