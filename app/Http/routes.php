<?php

/*
|--------------------------------------------------------------------------
| Routes File
|--------------------------------------------------------------------------
|
| Here is where you will register all of the routes in an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/admin', function () {
    return view('backend.index');
});

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| This route group applies the "web" middleware group to every route
| it contains. The "web" middleware group is defined in your HTTP
| kernel and includes session state, CSRF protection, and more.
|
*/

Route::group(['middleware' => ['web', 'auth']], function () {

    // QUESTION
    Route::post('/api/question/store', 'QuestionController@store');
    Route::post('/api/question/upvote', 'QuestionController@upvote');
    Route::post('/api/question/downvote', 'QuestionController@downvote');

    // ANSWER
	Route::post('/api/answer/like', 'AnswerController@like');
	Route::post('/api/answer/store', 'AnswerController@store');

    // profile
    Route::post('/api/user/picture', 'UserController@uploadPicture');
    Route::post('/api/user/profile/update', 'UserController@updateProfile');
});

Route::group(['middleware' => 'web'], function () {
    Route::auth();

    Route::get('/social-login/{provider?}',['uses' => 'Auth\AuthController@getSocialAuth', 'as' => 'auth.getSocialAuth']);
	Route::get('/social-login/callback/{provider?}',['uses' => 'Auth\AuthController@getSocialAuthCallback', 'as' => 'auth.getSocialAuthCallback']);

    Route::get('/{slug}', 'HomeController@index');
    Route::get('/', 'HomeController@index');

    // AJAX LOGIN
    Route::post('/api/login', ['uses' => 'Auth\AuthController@ajaxLogin', 'as' => 'auth.ajaxLogin']);

    // AJAX SIGNUP
    Route::post('/api/user/store', 'UserController@store');

    // SOCIAL LOGIN
    Route::get('/social-login/{provider?}',['uses' => 'Auth\AuthController@getSocialAuth', 'as' => 'auth.getSocialAuth']);
    Route::get('/social-login/callback/{provider?}',['uses' => 'Auth\AuthController@getSocialAuthCallback', 'as' => 'auth.getSocialAuthCallback']);
});
