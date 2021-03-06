<?php
# site/plugins/page-methods/index.php

// Looks for `methods` in eponymous folder.
$siteMethods = [];
foreach (glob( __DIR__ . "/site-methods/*.php") as $filename) {
  $path_parts = pathinfo($filename);
  $siteMethods[$path_parts['filename']] = require_once $filename;
};

$pagesMethods = [];
foreach (glob( __DIR__ . "/pages-methods/*.php") as $filename) {
  $path_parts = pathinfo($filename);
  $pagesMethods[$path_parts['filename']] = require_once $filename;
};

$pageMethods = [];
foreach (glob( __DIR__ . "/page-methods/*.php") as $filename) {
  $path_parts = pathinfo($filename);
  $pageMethods[$path_parts['filename']] = require_once $filename;
};

$fieldMethods = [];
foreach (glob( __DIR__ . "/field-methods/*.php") as $filename) {
  $path_parts = pathinfo($filename);
  $fieldMethods[$path_parts['filename']] = require_once $filename;
};

$fileMethods = [];
foreach (glob( __DIR__ . "/file-methods/*.php") as $filename) {
  $path_parts = pathinfo($filename);
  $fileMethods[$path_parts['filename']] = require_once $filename;
};

Kirby::plugin('tristantbg/kirby-functions', [
  'collections' => [
    'artistsPage' => function ($site) {
      return $site->pages()->filterBy('intendedTemplate', 'artists')->first();
    },
    'artists' => function ($site) {
      if ($p = collection('artistsPage')) {
        return $p->children()->listed();
      } else {
        return false;
      }
    },
    'projects' => function ($site) {
      return collection('artists')->children()->listed();
    },
    'index' => function ($site) {
      return collection('projects')->add(site()->homepage());
    },
  ],
  'collectionFilters' => [
      'i*=' => function ($collection, $field, $value, $split = false) {
          foreach($collection->data as $key => $item) {
            if($split) {
              $values = Str::split($item->$field(), $split);
              foreach($values as $val) {
                if(stripos($val, $value) === false) {
                  unset($collection->$key);
                  break;
                }
              }
            } else if(stripos($item->$field(), $value) === false) {
              unset($collection->$key);
            }
          }
          return $collection;
      }
  ],
  'siteMethods'  => $siteMethods,
  'pagesMethods' => $pagesMethods,
  'pageMethods'  => $pageMethods,
  'fieldMethods' => $fieldMethods,
  'fileMethods' => $fileMethods,
  'routes' => [
  ]
]);

foreach (glob( __DIR__ . "/functions/*.php") as $filename) {
  require_once $filename;
};
