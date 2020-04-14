<?php

return function ($srcSet = 'default') {

    $srcSetArray = option('thumbs')['srcsets'][$srcSet];
    $image = $this;

    if($image) {

      if ($image->alt()->isNotEmpty()) {
        $alt = $image->alt().' - © '.r($image->credits()->isNotEmpty(), $image->credits()->html().', ').$site->title()->html();
      }
      elseif ($image->caption()->isNotEmpty()) {
        $alt = $image->caption().' - © '.r($image->credits()->isNotEmpty(), $image->credits()->html().', ').$site->title()->html();
      }
      elseif($currentPage = $image->page()) {
        if ($currentPage->depth() > 1) {
          $alt = $currentPage->title()->html().' - '. $currentPage->parent()->title()->html() .' © '.r($image->credits()->isNotEmpty(), $image->credits()->html().', ').site()->title()->html();
        } else {
          $alt = $currentPage->title()->html().' - © '.r($image->credits()->isNotEmpty(), $image->credits()->html().', ').site()->title()->html();
        }
      } else {
        $alt = $site->title()->html().' - © '.r($image->credits()->isNotEmpty(), $image->credits()->html().', ').site()->title()->html();
      }
      $alt = Escape::html($alt);

      $json = [
        'placeholder'     => (string)$image->resize($srcSetArray[0])->url(),
        'src'             => (string)$image->resize($srcSetArray[min(3, count($srcSetArray) - 1)])->url(),
        'srcSet'          => (string)$image->srcSet($srcSet),
        'srcSetThumbnail' => (string)$image->srcSet('thumbnail'),
        'width'           => (string)$image->width(),
        'height'          => (string)$image->height(),
        'ratio'           => (string)$image->ratio(),
        'caption'         => (string)$image->caption()->kt(),
        'alt'             => (string)$alt,
      ];

    } else {

      $json = null;

    }

    return $json;

};
