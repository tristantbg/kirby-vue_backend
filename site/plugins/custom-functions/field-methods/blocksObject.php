<?php

return function ($field) {

    $json = [];
    $blocks = $field->toBuilderBlocks();

    foreach ($blocks as $key => $block) {
      if ($block->_key() == 'images') {
        foreach ($block->files()->toFiles() as $key => $file) {
          $jsonBlock = snippet('blocks/image', ['file' => $file], true);
          if ($jsonBlock) $json[] = json_decode($jsonBlock);
        }
      }
      else {
        $jsonBlock = snippet('blocks/' . $block->_key(), ['block' => $block], true);
        if ($jsonBlock) $json[] = json_decode($jsonBlock);
      }

    }

    return $json;

};
