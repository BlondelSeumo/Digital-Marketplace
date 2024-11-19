<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Active Theme
    |--------------------------------------------------------------------------
    |
    | This option determines the active theme for your application.
    | You can change the default theme by setting DEFAULT_THEME in your .env file.
    |
     */
    'active' => env('DEFAULT_THEME', 'basic'),

    /*
    |--------------------------------------------------------------------------
    | Stylesheets
    |--------------------------------------------------------------------------
    |
    | Define the stylesheets for your themes. These paths are relative to the public/themes/theme.
    |
     */
    'style' => [
        'colors' => 'assets/css/colors.css',
        'custom_css' => 'assets/css/custom.css',
    ],

];
