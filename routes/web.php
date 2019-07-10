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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@viewAllQuiz');
Route::get('/createQuiz', 'QuizController@showQuiz');
Route::post('/createQuiz', 'QuizController@createQuiz');
Route::delete('/deleteQuiz/{quiz}', 'QuizController@deleteQuiz');
Route::get('/viewQuiz/{quiz}', 'QuizController@viewQuiz');

Route::post('addQuestion/{quizId}', 'QuizController@addQuestion');
Route::post('/deleteQuestion/{quizId}', 'QuizController@deleteQuestion');
Route::post('/activateQuiz/{quizId}', 'QuizController@activateQuiz');
Route::post('/deactivateQuiz/{quizId}', 'QuizController@deactivateQuiz');

Route::get('/quizWelcome/{quiz}', 'appearQuiz@quizWelcome');
Route::get('/takeQuiz/{quiz}', 'appearQuiz@takeQuiz');
Route::post('/nextClick', 'appearQuiz@nextClickStore');
Route::post('/finishQuiz', 'appearQuiz@store');
Route::get('/finishQuiz','HomeController@viewAllQuiz');

Route::get('/userResults', 'userController@showAppearedQuiz');
Route::get('/viewSigleResult/{quizappearid}', 'userController@singleResult');
Route::get('/quizLeaderboard/{quiz}', 'userController@viewLeaderboard');