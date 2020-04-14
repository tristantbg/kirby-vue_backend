<?php
snippet('cors-headers');

$json = [];
$data = [];
$data['projects'] = [];

$data = [
  'uid'             => (string)$page->uid(),
  'url'             => (string)$page->url().'.json',
  'featured'        => $page->featured()->imageObject(),
  'gridViewOnly'    => (bool)$page->gridViewOnly()->bool(),
  'title'           => (string)$page->title(),
  'instagram'       => (string)$page->instagramName(),
  'website'         => (string)$page->website(),
  'job'             => (string)$page->job(),
  'description'     => (string)$page->text()->html(),
  'descriptionHTML' => (string)$page->text()->kt()
];

$projects = $page->children()->listed();

foreach($projects as $project) {

  $data['projects'][] = [
    'uid'             => (string)$project->uid(),
    'url'             => (string)$project->url().'.json',
    'featured'        => $project->featured()->imageObject('thumbnail'),
    'featuredVideo'   => $project->featuredVideo()->vimeoObject(),
    'title'           => (string)$project->title(),
    'subtitle'        => (string)$project->subtitle(),
    'credit'          => (string)$project->credit(),
    'description'     => (string)$project->text()->html(),
    'descriptionHTML' => (string)$project->text()->kt(),
    'blocks'          => $project->blocks()->blocksObject(),
  ];

}

$json['code'] = 200;
$json['data'] = $data;
$json['status'] = 'ok';
$json['type'] = 'artist';

echo json_encode($json, true);
