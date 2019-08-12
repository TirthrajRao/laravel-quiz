<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Auth;
use App\User;
use App\Question;
use App\Quiz;
use App\UserResponse;
use App\QuizAppear;
use App\AverageScore;
use Debugbar;
use Redirect;
use Charts;

class userController extends Controller
{
    /**
     * Constructer
     */
	public function __construct()
	{
		$this->middleware('auth');
	}

	/**
     * Lists all appeared quizzes to the user 
     */
	public function showAppearedQuiz(Request $request){
		$userId  = Auth::user()->id;

		$quizAppeared = \DB::table('quiz_appears')
		->join('quizzes', 'quizzes.quizid', '=', 'quiz_appears.quiz_id')
		->join('users','users.id', '=', 'quizzes.user_id')
		->where('quiz_appears.user_id', $userId)
		->select(array('quiz_appears.*', 'users.name','quizzes.title','quizzes.total_questions'))
		->paginate(12);

		return view('userResults', ['quizAppeared' => $quizAppeared]);
	}

	/**
     * View detailed result for particular Quiz to the user
     */
	public function singleResult(Request $request, QuizAppear $quizappearid){

		$allQuestions = \DB::table('user_responses')
		->join('questions','questions.questionid', '=', 'user_responses.question_id')
		->join('quizzes','quizzes.quizid', '=', 'user_responses.quiz_id')
		->where('user_responses.userData_appear', $quizappearid->quizappearid)
		->get(array('user_responses.*', 'quizzes.*', 'questions.*'));

		//for chart************
		$countTrue = \DB::table('user_responses')->where('userData_appear' , $quizappearid->quizappearid)->where('correct' , 1)->count();

		$countFalse = \DB::table('user_responses')->where('userData_appear' , $quizappearid->quizappearid)->where('correct' , 0)->count();

		$totalQuestion = $countTrue + $countFalse;
		$chart = Charts::create('pie', 'highcharts')
		->title('Result Analysis')
		->labels(['Correct', 'Incorrect'])
		->values([$countTrue,$countFalse])
		->dimensions(350,300)
		->responsive(false);

		return view('viewSingleResult', ['question' => $allQuestions, 'chart' => $chart, 'countTrue' => $countTrue, 'totalQuestion' =>$totalQuestion]);
	}

	/**
     * Displays the leaderboard for Quiz
     */
	public function viewLeaderboard(Request $request, Quiz $quiz){
		$topScorer = \DB::table('average_scores')
		->join('quizzes', 'quizzes.quizid', '=' , 'average_scores.quiz_id')
		->join('users', 'users.id', '=', 'average_scores.user_id')
		->where('quiz_id', $quiz->quizid)
		->orderBy('avg_score', 'desc')
		->limit(10)
		->get(array('users.name', 'quizzes.title', 'quizzes.total_questions', 'average_scores.*'));

		return view('quizLeaderboard', ['leaderboard' => $topScorer]);
	}
}
