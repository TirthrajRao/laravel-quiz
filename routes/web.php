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
Route::get('/getQuizData/{id}', 'QuizController@getQuizData');
Route::get('/getName/{id}', 'QuizController@getName');
Route::post('/verify_step', 'QuizController@verify_step')->name('verify_step');
Route::post('/createQuiz', 'QuizController@createQuiz');
Route::post('/updateQuiz', 'QuizController@updateQuiz')->name('updateQuiz');
Route::get('/deleteQuiz/{quiz}', 'QuizController@deleteQuiz')->name('deleteQuiz');
Route::get('/viewQuiz/{quiz}', 'QuizController@viewQuiz');
Route::get('/delQuestion/{id}/{qid}', 'QuizController@delQuestion')->name('delQuestion');
Route::get('/getQuestionData/{id}', 'QuizController@getQuestionData');
Route::post('addQuestion/{quizId}', 'QuizController@addQuestion');
Route::post('editQuestion/{quizId}', 'QuizController@editQuestion');
Route::post('/deleteQuestion/{quizId}', 'QuizController@deleteQuestion');
Route::post('/activateQuiz/{quizId}', 'QuizController@activateQuiz');
Route::post('/deactivateQuiz/{quizId}', 'QuizController@deactivateQuiz');
Route::post('/shareQuiz', 'QuizController@shareQuiz');
Route::get('/studentList', 'QuizController@studentList');
Route::get('/sharedQuiz', 'QuizController@sharedQuiz');
Route::get('/deleteStudent/{id}', 'QuizController@deleteStudent')->name('deleteStudent');
Route::get('/quizWelcome/{quiz}', 'appearQuiz@quizWelcome');
Route::get('/takeQuiz/{quiz}', 'appearQuiz@takeQuiz');
Route::post('/nextClick', 'appearQuiz@nextClickStore');
Route::post('/finishQuiz', 'appearQuiz@store');
Route::get('/finishQuiz','HomeController@viewAllQuiz');
Route::get('/userResults', 'userController@showAppearedQuiz');
Route::get('/viewSigleResult/{quizappearid}', 'userController@singleResult');
Route::get('/quizLeaderboard/{quiz}', 'userController@viewLeaderboard');
Route::get('/userReport/{id}', 'userController@userReport')->name('userReport');
Route::post('/addSuggestion', 'QuizController@addSuggestion');
Route::get('/suggestion/{id}/{qid}', 'QuizController@suggestion')->name('suggestion');
Route::post('/createUser', 'QuizController@createUser');
Route::get('/detailPage/{id}', 'QuizController@detailPage')->name('detailPage');
Route::get('/quizDetail/{id}', 'QuizController@quizDetail')->name('quizDetail');
Route::get('/getStudentList/{id}', 'QuizController@getStudentList')->name('getStudentList');


/* student module route */
Route::get('/studentDashboard', 'student\studentController@dashboard')->name('studentDashboard');
Route::get('/quizWelcomeStudent/{quiz}', 'student\StudentQuizController@quizWelcome');
Route::get('/takeQuizStudent/{quiz}', 'student\StudentQuizController@takeQuiz');
Route::post('/nextClickStudent', 'student\StudentQuizController@nextClickStore');
Route::post('/finishQuizStudent', 'student\StudentQuizController@store');
Route::get('/viewSigleResultStudent/{quizappearid}', 'student\StudentQuizController@singleResult');
Route::get('/quizLeaderboardStudent/{quiz}', 'student\StudentQuizController@viewLeaderboard');
Route::get('/userResultsStudent', 'student\StudentQuizController@showAppearedQuiz');
Route::get('/lessionPlans', 'student\LessionPlanController@lessionPlan');
Route::post('/createLession/{id?}', 'student\LessionPlanController@createLession')->name('createLession');
Route::get('/addReference', 'student\LessionPlanController@addReference')->name('addReference');
Route::get('lessionPlan2/{id}', 'student\LessionPlanController@lessionPlan2')->name('lessionPlan2');
Route::post('/createLession2/{id}', 'student\LessionPlanController@createLession2')->name('createLession2');
Route::get('/lessionPlan3/{id}', 'student\LessionPlanController@lessionPlan3')->name('lessionPlan3');
Route::post('/createLession3/{id}', 'student\LessionPlanController@createLession3')->name('createLession3');
Route::get('/lessionList', 'student\LessionPlanController@lessionList')->name('lessionList');
Route::get('/deleteLession/{id}', 'student\LessionPlanController@deleteLession')->name('deleteLession');
Route::get('/editLession/{id}', 'student\LessionPlanController@editLession')->name('editLession');
Route::post('/updateLesson2/{id}', 'student\LessionPlanController@updateLesson2')->name('updateLesson2');
Route::post('/updateLession3/{id}', 'student\LessionPlanController@updateLession3')->name('updateLession3');
Route::get('/openPdf/{id}', 'student\LessionPlanController@openPdf')->name('openPdf');
Route::get('/lessionPlan2Edit/{id}', 'student\LessionPlanController@lessionPlan2Edit')->name('lessionPlan2Edit');
Route::get('/downloadLesson/{id}', 'student\LessionPlanController@downloadLesson')->name('downloadLesson');

/* admin route */
Route::group(['prefix' => 'admin'], function() {
Route::get('/login', 'admin\AdminController@home')->name('admin/login');
Route::post('/adminLogin', 'admin\AdminController@adminLogin')->name('adminLogin');
Route::get('admindashboard', 'admin\AdminController@admindashboard')->name('admindashboard');
Route::get('/teacherList', 'admin\AdminController@teacherList')->name('teacherList');
Route::get('/approveTeacher/{id}', 'admin\AdminController@approveTeacher')->name('approveTeacher');
Route::get('/denyTeacher/{id}', 'admin\AdminController@denyTeacher')->name('denyTeacher');
Route::get('/deleteTeacher/{id}', 'admin\AdminController@deleteTeacher')->name('deleteTeacher');
Route::get('/adminLogout', 'admin\AdminController@adminLogout')->name('adminLogout');
});