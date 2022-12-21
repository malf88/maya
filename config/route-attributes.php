<?php

return [
    /*
     *  Automatic registration of routes will only happen if this setting is `true`
     */
    'enabled' => true,

    /*
     * Controllers in these directories that have routing attributes
     * will automatically be registered.
     *
     * Optionally, you can specify group configuration by using key/values
     */
    'directories' => [

        app_path('Domain/Home/Controller') => [
            'prefix' => '/',
            'middleware' => ['web']
        ],
        app_path('Domain/Auth/Controller') => [
            'middleware' => ['web']
        ],


        //        app_path('Domain/Auth/Controller') => [
        //           'prefix' => 'api',
        //           'middleware' => 'api',
        //        ],

    ],

    /**
     * This middleware will be applied to all routes.
     */
    'middleware' => [
        \Illuminate\Routing\Middleware\SubstituteBindings::class,
    ],
];
