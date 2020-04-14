<?php
snippet('cors-headers');

$json = [];
$data = [];
$data['subpages'] = [];

$data = [
  'uid'       => (string)$page->uid(),
  'url'       => (string)$page->url().'.json',
  'featured'  => $page->featured()->imageObject(),
  'title'     => (string)$page->title(),
];

$subpages = $page->children()->listed();

foreach($subpages as $subpage) {

  $data['subpages'][] = [
    'uid'             => (string)$subpage->uid(),
    'url'             => (string)$subpage->url().'.json',
    'featured'        => $subpage->featured()->imageObject(),
    'title'           => (string)$subpage->title(),
    'instagram'       => (string)$subpage->instagramName(),
    'website'         => (string)$subpage->website(),
    'job'             => (string)$subpage->job(),
    'description'     => (string)$subpage->text()->html(),
    'descriptionHTML' => (string)$subpage->text()->kt()
  ];

}

$json['code'] = 200;
$json['data'] = $data;
$json['status'] = 'ok';
$json['type'] = 'artists';

echo json_encode($json, true);
