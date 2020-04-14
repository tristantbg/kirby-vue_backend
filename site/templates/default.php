<?php

if (option('frontendUrl')) {

  $url = str_replace($site->url(), option('frontendUrl'), $page->url());
  go($url);

} else {

  $url = $_SERVER['SERVER_NAME'];
  $parts = explode('.', $url);
  $final = 'http://'.$parts[1].'.'.$parts[2];

  if($url != '127.0.0.1') {
    go($final);
  } else {
    echo $url;
  }

}

?>
