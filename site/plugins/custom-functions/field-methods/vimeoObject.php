<?php

return function ($field) {

    $json = null;

    if($vimeoPage = $field->toPage()) {

      $thumbnails = $vimeoPage->vimeoThumbnails()->toStructure();

      if($thumbnails->count()) {
        $sd = $thumbnails->filter(function($thumb){ return $thumb->width()->int() < 960;})->last();
        $hd = $thumbnails->filter(function($thumb){ return $thumb->width()->int() >= 960;})->last();
        $srcSet = implode(', ', $thumbnails->filter(function($thumb){ return $thumb->width()->int() > 200;})->map(function($thumb){ return strtok($thumb->link(), '?').' '.$thumb->width().'w';})->data());
        // $srcSet = [];
        // if($sd) $srcSet[] = $sd;
        // if($hd) $srcSet[] = $hd;
      }

      $json = [
        'title' => (string)$vimeoPage->vimeoName(),
        'id' => (string)$vimeoPage->vimeoID(),
        'description' => (string)$vimeoPage->vimeoDescription(),
        'url' => (string)$vimeoPage->vimeourl(),
        // 'thumbnails' => $vimeoPage->vimeoThumbnails()->yaml(),
        'width' => isset($hd) ? $hd->width()->int() : $sd->width()->int(),
        'height' => isset($hd) ? $hd->height()->int() : $sd->height()->int(),
        'ratio' => isset($hd) ? ($hd->width()->int() / $hd->height()->int()) : ($sd->width()->int() / $sd->height()->int()),
        'thumbSd' => isset($sd) ? strtok($sd->link(), '?') : null,
        'thumbHd' => isset($hd) ? strtok($hd->link(), '?') : null,
        'thumbSrcSet' => isset($srcSet) ? $srcSet : null,
        // 'thumbnailSrcSet' =>
        //   isset($srcSet)
        //   ? implode(', ', array_map(function($thumb){ return strtok($thumb->link(), '?').' '.$thumb->width().'w';}, $srcSet))
        //   : null,
        'files' => $vimeoPage->vimeoFiles()->yaml(),
        'fileSd' => $vimeoPage->vimeoSD()->last() ? $vimeoPage->vimeoSD()->last()->toArray() : null,
        'fileHd' => $vimeoPage->vimeoHD()->last() ? $vimeoPage->vimeoHD()->last()->toArray() : null,
        // 'data' => $vimeoPage->vimeodata()->yaml()
      ];

    }

    return $json;

};
