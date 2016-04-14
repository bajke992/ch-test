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

    Route::group(['prefix' => 'question'], function () {
        Route::get('/', ['as' => 'admin.question.list', 'uses' => 'AdminQuestionController@index']);
        Route::get('view/{id}', ['as' => 'admin.question.view', 'uses' => 'AdminQuestionController@view']);
        Route::get('create', ['as' => 'admin.question.create', 'uses' => 'AdminQuestionController@create']);
        Route::post('create', ['as' => 'admin.question.create.post', 'uses' => 'AdminQuestionController@createPost']);
        Route::get('update/{id}', ['as' => 'admin.question.update', 'uses' => 'AdminQuestionController@update']);
        Route::post('update/{id}', ['as' => 'admin.question.update.post', 'uses' => 'AdminQuestionController@updatePost']);
        Route::get('delete/{id}', ['as' => 'admin.question.delete', 'uses' => 'AdminQuestionController@delete']);
    });

    Route::group(['prefix' => 'answer'], function () {
        Route::get('/', ['as' => 'admin.answer.list', 'uses' => 'AdminAnswerController@index']);
        Route::get('view/{id}', ['as' => 'admin.answer.view', 'uses' => 'AdminAnswerController@view']);
        Route::get('create', ['as' => 'admin.answer.create', 'uses' => 'AdminAnswerController@create']);
        Route::post('create', ['as' => 'admin.answer.create.post', 'uses' => 'AdminAnswerController@createPost']);
        Route::get('update/{id}', ['as' => 'admin.answer.update', 'uses' => 'AdminAnswerController@update']);
        Route::post('update/{id}', ['as' => 'admin.answer.update.post', 'uses' => 'AdminAnswerController@updatePost']);
        Route::get('delete/{id}', ['as' => 'admin.answer.delete', 'uses' => 'AdminAnswerController@delete']);
    });

    Route::group(['prefix' => 'create'], function () {
        Route::get('poll', ['as' => 'admin.flowCreate.poll', 'uses' => 'AdminFlowController@poll']);
        Route::post('question', ['as' => 'admin.flowCreate.question', 'uses' => 'AdminFlowController@pollPost']);
        Route::post('answer', ['as' => 'admin.flowCreate.answer', 'uses' => 'AdminFlowController@questionPost']);
        Route::post('finish', ['as' => 'admin.flowCreate.finish', 'uses' => 'AdminFlowController@answerPost']);
    });

});

Route::get('register', ['as' => 'auth.register', 'uses' => 'AuthController@getRegistration']);
Route::post('register', ['as' => 'auth.postRegister', 'uses' => 'AuthController@postRegistration']);
Route::get('login', ['as' => 'auth.login', 'uses' => 'AuthController@getLogin']);
Route::post('login', ['as' => 'auth.postLogin', 'uses' => 'AuthController@postLogin']);
Route::get('logout', ['as' => 'auth.logout', 'uses' => 'AuthController@getLogout']);
Route::get('email/verify/{token}', ['as' => 'auth.emailVerify', 'uses' => 'AuthController@verifyEmail']);
//Route::get('email/verify/resend/{id}', ['as' => 'auth.emailResend', 'uses' => 'AuthController@resendVerificationEmail']);

Route::get('password/reset/{token}', ['as' => 'auth.passwordReset', 'uses' => 'AuthController@getReset']);
Route::post('password/reset', ['as' => 'auth.postPasswordReset', 'uses' => 'AuthController@postReset']);
Route::get('password/email', ['as' => 'auth.passwordEmail', 'uses' => 'AuthController@getEmail']);
Route::post('password/email', ['as' => 'auth.postPasswordEmail', 'uses' => 'AuthController@postEmail']);

Route::get('/my-polls', ['as' => 'user.polls', 'uses' => 'HomeController@myPolls']);
Route::get('/my-polls/{id}', ['as' => 'user.polls.view', 'uses' => 'HomeController@myPollView']);
Route::get('/', ['as' => 'home', 'uses' => 'HomeController@index']);
Route::get('/{id}', ['as' => 'poll', 'uses' => 'HomeController@poll']);
Route::post('/{id}', ['as' => 'poll.post', 'uses' => 'HomeController@pollPost']);


