<?php

return [
    /**
     * Determine if the gui is enabled or not.
     */
    'enabled' => env('TRANSLATION_LOADER_GUI_ENABLED', true),

    'name' => 'Translation Loader Gui',

    /**
     * The configuration for the route group.
     */
    'route' => [
        'prefix' => null,
        'middleware' => [
            'web',
            //'auth',
        ],
    ],

    /**
     * The locales that is supported to by managable.
     */
    'locales' => [
        'ar',
        'en',
    ],
];