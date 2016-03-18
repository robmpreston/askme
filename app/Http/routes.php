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

// HOME
Route::get('/api/home', 'HomeController@index');

// QUESTION
Route::post('/api/question/store', 'QuestionController@store');
Route::post('/api/question/upvote', 'QuestionController@upvote');
Route::post('/api/question/downvote', 'QuestionController@downvote');

// ANSWER
Route::post('/api/answer/like', 'AnswerController@like');
Route::post('/api/answer/store', 'AnswerController@store');

Route::get('/{slug}', 'HomeController@index');
Route::get('/', 'HomeController@index');
