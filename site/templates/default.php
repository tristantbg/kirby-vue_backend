<?php
$url = $_SERVER['SERVER_NAME'];
$parts = explode('.', $url);
$final = 'http://'.$parts[1].'.'.$parts[2];

if($url != '127.0.0.1') {
  go($final);
} else {
  echo $url;
}

?>