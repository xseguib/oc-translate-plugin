<?php return [
    'packages' => [
        'weglot/translate-laravel' => [
            'providers' => [
                '\Weglot\Translate\TranslateServiceProvider',
            ],

            'config_namespace' => 'weglot-translate',

            'config' => [
                'api_key' => env('WG_API_KEY'),
                'original_language' => config('app.locale', 'en'),
                'destination_languages' => [
                    'fr'
                ],
                'exclude_blocks' => [],
                'cache' => true,

                'laravel' => [
                    'controller_namespace' => 'App\Http\Controllers',
                    'routes_web' => 'routes/web.php'
                ]
            ],
        ],
    ],
];