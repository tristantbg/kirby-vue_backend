<?php

$json = [
  'type'   => (string) isset($block) ? $block->_key() : 'image',
  'media'   => []
];

if (isset($block)) {
  $file = $block->file()->toFile();
}

$json['media'] = $file->imageObject();

echo $file ? json_encode($json) : null;

?>
