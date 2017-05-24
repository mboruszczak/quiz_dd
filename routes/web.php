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





Auth::routes();
Route::get('/', 'HomeController@index');
Route::get('/home', 'HomeController@index');
Route::get('/quiz/{quiz}', 'QuizController@start');
Route::post('/quiz_main', 'QuizController@showQuest');
Route::get('/quiz_main', 'QuizController@showQuest');
Route::get('/admin/dashboard', 'AdminController@index');
/*Route::post('/quiz/{quiz}/q/{question}', 'QuizController@showQuest');
Route::post('/quiz/{quiz}/q/finish/end', 'QuizController@endQuiz');*/
