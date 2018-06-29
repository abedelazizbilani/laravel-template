<?php

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

//Auth
Route::post('login', 'API\AuthController@login');

//Feedbacks
Route::post('add-feedback', 'API\FeedbackController@add');
Route::post('delete-feedback', 'API\FeedbackController@delete');

//Device
Route::post('update-token', 'Device\TokenController@update');

//
Route::group(
    ['middleware' => 'jwt.auth'], function () {
    Route::get('users','Api\UserController@index');
    Route::get('users/{id}','Api\UserController@one');
});

