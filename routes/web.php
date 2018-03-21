<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::name('home')->get('/', function () {
    return redirect('login');
}
);

/*
|--------------------------------------------------------------------------
| Frontend
|--------------------------------------------------------------------------|
*/

// Contact
Route::resource('contacts', 'Front\ContactController', ['only' => ['create', 'store']]);


Route::name('category')->get('category/{category}', 'Front\PostController@category');

// Authentification

$this->get('login', 'Auth\LoginController@showLoginForm')->name('login');
$this->post('login', 'Auth\LoginController@login');
$this->post('logout', 'Auth\LoginController@logout')->name('logout');

// Password Reset Routes...
$this->get('password/reset', 'Auth\ResetPasswordController@showLinkRequestForm')->name('password.request');
$this->post('password/reset', 'Auth\ResetPasswordController@resetPassword')->name('password.reset');
$this->get('password/confirm', 'Auth\ResetPasswordController@showConfirmCodeForm')->name('password.confirm');
$this->post('password/confirm', 'Auth\ResetPasswordController@confirmPassword')->name('password.confirm');

Route::get('/redirect', 'FacebookAuthController@redirect');
Route::get('/callback', 'FacebookAuthController@callback');

/*
|--------------------------------------------------------------------------
| Backend
|--------------------------------------------------------------------------|
*/

Route::prefix('dashboard')->namespace('Back')->group(function () {

    //Dashboard
    Route::name('dashboard')->get('/', 'DashboardController@index');

    // Users
    Route::name('users.valid')->put('users/valid/{user}', 'UserController@updateValid');
    Route::resource('users', 'UserController', [
            'middleware' => ['permission:manage_users'], 'only' => [
                'index', 'edit', 'update', 'destroy', 'create', 'store'
            ]
        ]
    );

    //Roles
    Route::resource('roles', 'RoleController', [
            'middleware' => ['permission:manage_roles'], 'only' => [
                'index', 'edit', 'update', 'destroy', 'create', 'store'
            ]
        ]
    );

    //Profiles
    Route::resource('profiles', 'ProfileController', [
            'only' => [
                'edit', 'update'
            ]
        ]
    );

    //FeedBacks
    Route::resource('feedbacks', 'FeedBackController', [
            'middleware' => ['permission:manage_feedbacks'], 'only' => [
                'index', 'destroy'
            ]
        ]
    );

    //Devices
    Route::resource('devices', 'DeviceController', [
            'only' => [
                'index'
            ]
        ]
    );

    //audit
    Route::resource('audit', 'DeviceController', [
            'only' => [
                'index'
            ]
        ]
    );
    //notifications
    Route::resource('notifications', 'DeviceController');

    //performance
    Route::name('performance')->get('/performance', 'DashboardController@index');

    //performance
    Route::name('countries')->get('/countries', 'DashboardController@index');

    //configurations
    Route::name('configurations')->get('/configurations', 'DashboardController@index');

    Route::resource('posts', 'PostsController');

});
