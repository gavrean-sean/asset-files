<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Package Information
    |--------------------------------------------------------------------------
    |
    | Package information.
    |
    */

    'package_information' => [
        'name' => 'asset-files',
        'description' => 'Asset Files.',
    ],

    /*
    |--------------------------------------------------------------------------
    | Optimization Commands
    |--------------------------------------------------------------------------
    |
    | Optimization commands.
    |
    */

    'optimization_commands' => [
        'optimize:clear',
        'config:cache',
        'event:cache',
        'route:cache',
        'view:cache',
    ],

    /*
    |--------------------------------------------------------------------------
    | Package Commands
    |--------------------------------------------------------------------------
    |
    | Package commands.
    |
    */

    'package_commands' => [
        'assets' => true,
        'config' => true,
    ],

];
