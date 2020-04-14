<?php
snippet('cors-headers');

$json = [];
$data = [];
$data['pages'] = [];

$data = [
  'url'              => (string)$site->url(),
  'title'            => (string)$site->title(),
  'description'      => (string)$site->description()->html(),
  'about'            => (string)$site->about()->kt(),
  'contact'          => (string)$site->contact()->kt(),
  'og_image'         => $site->ogimage()->imageObject(),
  'instagram'        => (string)$site->instagramName(),
  'newsletterUserId' => (string)$site->newsletterUserId(),
  'newsletterListId' => (string)$site->newsletterListId(),
  'keywords'         => (string)$site->keywords(),
  'google_analytics' => (string)$site->googleAnalytics(),
];

$sitePages = $site->pages()->listed();

foreach($sitePages as $sitePage) {

  $data['pages'][] = [
    'uid'             => (string)$sitePage->uid(),
    'template'        => (string)$sitePage->intendedTemplate(),
    'url'             => (string)$sitePage->url().'.json',
    'featured'        => $sitePage->featured()->imageObject(),
    'title'           => (string)$sitePage->title(),
    'description'     => (string)$sitePage->text()->html(),
    'descriptionHTML' => (string)$sitePage->text()->kt(),
    'blocks'          => $sitePage->blocks()->blocksObject(),
  ];

}

$json['code'] = 200;
$json['data'] = $data;
$json['status'] = 'ok';
$json['type'] = 'index';

echo json_encode($json, true);
