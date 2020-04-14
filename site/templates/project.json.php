<?php
snippet('cors-headers');

$json = [];
$data = [];
$project = $page;

$data = [
  'uid'             => (string)$project->uid(),
  'url'             => (string)$project->url().'.json',
  'featured'        => $project->featured()->imageObject('thumbnail'),
  'featuredVideo'   => $project->featuredVideo()->vimeoObject(),
  'title'           => (string)$project->title(),
  'subtitle'        => (string)$project->subtitle(),
  'credit'          => (string)$project->credit(),
  'description'     => (string)$project->text()->html(),
  'descriptionHTML' => (string)$project->text()->kt()
  'blocks'          => $project->blocks()->blocksObject(),
];

$json['code'] = 200;
$json['data'] = $data;
$json['status'] = 'ok';
$json['type'] = 'project';

echo json_encode($json, true);
