<?php

$json = [
  'type'   => (string)$block->_key(),
  'medias'   => []
];

$files = $block->files()->toFiles();

foreach ($files as $key => $file) {
  $json['medias'][] = $file->imageObject();
}

echo $files->count() ? json_encode($json) : null;

?>
