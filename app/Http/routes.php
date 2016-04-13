<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::group(['prefix' => 'admin', 'middleware' => 'auth.admin'], function () {
    Route::get('/', ['as' => 'admin.home', 'uses' => 'AdminHomeController@index']);

    Route::group(['prefix' => 'poll'], function () {
        Route::get('/', ['as' => 'admin.poll.list', 'uses' => 'AdminPollController@index']);
        Route::get('view/{id}', ['as' => 'admin.poll.view', 'uses' => 'AdminPollController@view']);
        Route::get('create', ['as' => 'admin.poll.create', 'uses' => 'AdminPollController@create']);
        Route::post('create', ['as' => 'admin.poll.create.post', 'uses' => 'AdminPollController@createPost']);
        Route::get('update/{id}', ['as' => 'admin.poll.update', 'uses' => 'AdminPollController@update']);
        Route::post('update/{id}', ['as' => 'admin.poll.update.post', 'uses' => 'AdminPollController@updatePost']);
        Route::get('archive/{id}', ['as' => 'admin.poll.archive', 'uses' => 'AdminPollController@archive']);
        Route::get('delete/{id}', ['as' => 'admin.poll.delete', 'uses' => 'AdminPollController@delete']);
    });

    Route::group(['prefix' => 'user'], function () {
        Route::get('/', ['as' => 'admin.user.list', 'uses' => 'AdminUserController@index']);
        Route::get('view/{id}', ['as' => 'admin.user.view', 'uses' => 'AdminUserController@view']);
        Route::get('create', ['as' => 'admin.user.create', 'uses' => 'AdminUserController@create']);
        Route::post('create', ['as' => 'admin.user.create.post', 'uses' => 'AdminUserController@createPost']);
        Route::get('update/{id}', ['as' => 'admin.user.update', 'uses' => 'AdminUserController@update']);
        Route::post('update/{id}', ['as' => 'admin.user.update.post', 'uses' => 'AdminUserController@updatePost']);
        Route::get('ban/{id}', ['as' => 'admin.user.ban', 'uses' => 'AdminUserController@ban']);
        Route::get('delete/{id}', ['as' => 'admin.user.delete', 'uses' => 'AdminUserController@delete']);
    });

});

Route::get('register', ['as' => 'auth.register', 'uses' => 'AuthController@getRegistration']);
Route::post('register', ['as' => 'auth.postRegister', 'uses' => 'AuthController@postRegistration']);
Route::get('login', ['as' => 'auth.login', 'uses' => 'AuthController@getLogin']);
Route::post('login', ['as' => 'auth.postLogin', 'uses' => 'AuthController@postLogin']);
Route::get('logout', ['as' => 'auth.logout', 'uses' => 'AuthController@getLogout']);
Route::get('email/verify/{token}', ['as' => 'auth.emailVerify', 'uses' => 'AuthController@verifyEmail']);
Route::get('email/verify/resend/{id}', ['as' => 'auth.emailResend', 'uses' => 'AuthController@resendVerificationEmail']);

Route::get('/', ['as' => 'home', 'uses' => 'HomeController@index']);


