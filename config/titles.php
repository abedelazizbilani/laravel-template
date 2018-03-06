<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Titles for routes names
    |--------------------------------------------------------------------------
    |
    | Set Titles for each admin routes names
    */

    'admin'         => 'dashboard',
    'users'         => [
        'index' => 'usersGestion',
        'edit'  => 'userEdit',
    ],
    'roles'         => [
        'index'  => 'rolesGestion',
        'edit'   => 'roleEdit',
        'create' => 'roleCreate',
    ],
    'contacts'      => [
        'index' => 'contactsGestion',
    ],
    'posts'         => [
        'index'  => 'postsGestion',
        'edit'   => 'postEdit',
        'create' => 'postCreate',
        'show'   => 'postShow',
    ],
    'notifications' => [
        'index' => 'notificationsGestion',
    ],
    'comments'      => [
        'index' => 'commentsGestion',
    ],
    'medias'        => [
        'index' => 'mediasGestion',
    ],
    'settings'      => [
        'edit' => 'settings',
    ],
    'profiles'      => [
        'edit' => 'profileEdit',
    ],
    'devices'       => [
        'index' => 'devicesGestion',
    ],
    'feedbacks'     => [
        'index' => 'feedbacksGestion',
    ],

];