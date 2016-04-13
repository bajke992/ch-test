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


Route::get('register', ['as' => 'auth.register', 'uses' => 'AuthController@getRegistration']);
Route::post('register', ['as' => 'auth.postRegister', 'uses' => 'AuthController@postRegistration']);
Route::get('login', ['as' => 'auth.login', 'uses' => 'AuthController@getLogin']);
Route::post('login', ['as' => 'auth.postLogin', 'uses' => 'AuthController@postLogin']);
Route::get('logout', ['as' => 'auth.logout', 'uses' => 'AuthController@getLogout']);
Route::get('email/verify/{token}', ['as' => 'auth.emailVerify', 'uses' => 'AuthController@verifyEmail']);
Route::get('email/verify/resend/{id}', ['as' => 'auth.emailResend', 'uses' => 'AuthController@resendVerificationEmail']);

Route::get('/',['as' => 'home', 'uses' => 'HomeController@index']);
