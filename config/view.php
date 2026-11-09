<?php

use Illuminate\Support\Facades\Facade;

return [
    'paths' => [
        resource_path('views'),
    ],

    'compiled' => env(
        'VIEW_COMPILED_PATH',
        realpath(storage_path('framework/views-runtime')) ?: storage_path('framework/views-runtime'),
    ),

    'compiled_extension' => 'php',

    'except' => [
        'errors::*',
    ],

    'cache' => true,

    'facade' => Facade::class,
];
