<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Names, icons and urls for urls segments
    |--------------------------------------------------------------------------
    |
    | Set names, icons and urls for each dashboard url segment
    */

    'dashboard' => [
        'name' => 'dashboard',
        'icon' => 'dashboard',
        'url' => '/dashboard',
    ],
    'users' =>
    [
        'name' => 'users',
        'icon' => 'user',
        'url' => '/dashboard/users',
    ],
    'roles' =>
    [
        'name' => 'roles',
        'icon' => 'users',
        'url' => '/dashboard/roles',
    ],
    'edit' =>
    [
        'name' => 'edition',
        'icon' => 'edit',
    ],
    'create' =>
    [
        'name' => 'creation',
        'icon' => 'edit'
    ],
    'profiles' =>
        [
            'name' => 'profile',
            'icon' => 'user',
            'url' => '/dashboard/profiles',
        ],
    'feedbacks' =>
        [
            'name' => 'feedbacks',
            'icon' => 'comment',
            'url' => '/dashboard/feedbacks',
        ],
    'devices' =>
        [
            'name' => 'devices',
            'url' => '/dashboard/devices',
        ],
    'posts' =>
        [
            'name' => 'posts',
            'url' => '/dashboard/posts',
        ]
];