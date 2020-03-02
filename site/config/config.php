<?php
return [
    'debug' => false,
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

                function isFeatured($value) {
                    return $value['featured'];
                }

                function isNotFeatured($value) {
                    return !($value['featured']);
                }

                // Kirbytags
                function kt($array) {
                    foreach ($array as $key => $value) {
                        if (is_array($value)) {
                            $array[$key] = kt($value);
                        } else {
                            $array[$key] = kirbytags($value);
                        }
                    }
                    return $array;
                }

                $decoded = kt($decoded);
                $encoded = json_encode($decoded, true);

                return Response::json($encoded);
            }
        ]
    ]
];
