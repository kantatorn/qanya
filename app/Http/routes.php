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

Route::get('/', 'HomeController@index');
Route::get('/previous', 'HomeController@previous');



Route::auth();


//RESOURCES
//https://laravel.com/docs/5.2/controllers
Route::resource('question', 'QuestionController');
Route::resource('tag',      'TagsController');
Route::resource('answer',   'AnswerController');
Route::resource('profile',  'UsersController');


/* USER ROUTES */
Route::get('/create_displyname','UsersController@create_displayname');
Route::post('/addExpertise','UsersController@addExpertise');
Route::post('/listExpertise','UsersController@listExpertise');

/* QUESTION ROUTES */
Route::post('/followQuestion','QuestionController@follow');
Route::post('/upvoteQuestion','QuestionController@upvote');
Route::post('/downvoteQuestion','QuestionController@downvote');


/* ANSWER ROUTES */
Route::post('/commentAnswer','AnswerController@commentAnswer');


Route::get('/home', 'HomeController@index');
Route::get('/create', 'HomeController@create');
//Route::post('/create/callback', 'HomeController@validateQuestion');

Route::get('auth/facebook', 'Auth\AuthController@redirectToProvider');
Route::get('auth/facebook/callback', 'Auth\AuthController@handleProviderCallback');