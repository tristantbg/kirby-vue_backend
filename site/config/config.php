<?php
return [
    'panel'         => [
        'slug' => 'adminpanel',
        'css' => 'assets/panel.css'
    ],
    'debug'         => false,
    'thumbs'        => [
        'driver' => 'im',
        'srcsets' => [
            'default' => [200, 400, 600, 1024, 1600, 1920],
            'cover'   => [800, 1024, 2048, 4000],
        ],
    ],
    'hooks'         => [
        'page.create:after' => function ($page) {
          if ($page->intendedTemplate() != 'vimeo.video') {
            $page->changeStatus('listed');
          }
        },
    ],
    'cache'         => [
        'pages' => [
            'active' => true,
        ],
    ],
    'api' => [
        'basicAuth' => true
    ],
    'routes' => [
        [
            'pattern' => 'rest/(:all)',
            'method'  => 'GET',
            'env'     => 'api',
            'action'  => function ($path = null) {
                $kirby = new Kirby([
                    'roots' => [
                        'index'    => dirname(dirname(__DIR__)) . '/public',
                        'base'     => $base    = dirname(dirname(__DIR__)),
                        'content'  => $base . '/content',
                        'site'     => dirname(dirname(__DIR__)) . '/site',
                        'storage'  => $storage = $base . '/storage',
                        'accounts' => $storage . '/accounts',
                        'cache'    => $storage . '/cache',
                        'sessions' => $storage . '/sessions',
                    ]
                ]);

                // $kirby->impersonate('kirby');

                $request = $kirby->request();

                $render = $kirby->api()->render($path, $this->method(), [
                    'body'    => $request->body()->toArray(),
                    'headers' => $request->headers(),
                    'query'   => $request->query()->toArray(),
                ]);

                $decoded = json_decode($render, true);

                if ($decoded['type'] == 'collection') {
                  $p = 0;
                  foreach ($decoded['data'] as $project) {
                      $kirbyPage = page($project['id']);
                      $project['template'] = $kirbyPage->intendedtemplate();

                      if (isset($project['content']['cover'])) {
                          $i = 0;

                          $img = $project['content']['cover'][0];

                          $img['large'] = image($img['id'])->resize(1200, 1200, 90)->url();
                          $img['medium'] = image($img['id'])->resize(900, 900, 90)->url();
                          $img['small'] = image($img['id'])->resize(600, 600, 90)->url();
                          $img['orientation'] = image($img['id'])->orientation();
                          $img['width'] = image($img['id'])->width();
                          $img['ratio'] = image($img['id'])->ratio();

                          $project['content']['cover'][0] = $img;
                      };
                      $decoded['data'][$p] = $project;
                      $p++;
                  };
                }

                $decoded = convert_to_kt($decoded);
                $encoded = json_encode($decoded, true);

                return Response::json($encoded);
            }
        ]
    ]
];
