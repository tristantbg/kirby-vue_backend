<?php

$json = [
  'type'   => (string)$block->_key(),
  'media'   => []
];

if($oembed = $block->oembed()->toEmbed()) {

  $json['media'] = $oembed->toArray();

}

echo $oembed ? json_encode($json) : null;

?>
