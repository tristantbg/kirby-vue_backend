<?php
return [
    'frontendUrl' => 'https://frontend.cms',
    'panel'         => [
        'slug' => 'adminpanel',
        'css' => 'assets/panel.css'
    ],
    'debug'         => true,
    'environnement' => 'dev',
    'thumbs'        => [
        'srcsets' => [
            'default' => [200, 400, 600, 1024, 1600, 1920],
            'thumbnail' => [200, 400],
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
            'active' => false,
        ],
    ],
    'api' => [
        'basicAuth' => true
    ],
    'routes' => [
        [
          'pattern' => '(:any).json',
          'method'  => 'GET',
          'action'  => function () {
            // $customHeader = $_SERVER['HTTP_X_REQUESTED_WITH'] ?? null;

            // // Secure JSON output from direct access in production environment
            // if (option('environnement') !== 'devd' && $customHeader !== 'fetch') {
            //   go(url('error'));
            // }

            $this->next();
          }
        ]
    ]
];
