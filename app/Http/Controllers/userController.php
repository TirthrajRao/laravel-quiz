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
use App\LessionPlan;


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
	public function userReport($id){
		$userId  = $id;
		$username =  User::find($userId);
		$quizAppeared = \DB::table('quiz_appears')
		->join('quizzes', 'quizzes.quizid', '=', 'quiz_appears.quiz_id')
		->join('users','users.id', '=', 'quizzes.user_id')
		->where('quiz_appears.user_id', $userId)
		->select(array('quiz_appears.*', 'users.name','quizzes.title','quizzes.total_questions'))
		->orderBy('quizzes.created_at','Desc')
		->paginate(12);

		return view('userResults', ['quizAppeared' => $quizAppeared,'username' => $username->name]);
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
	public function searchStudent(Request $request){
		$query = $request->searchStudent;
		$student = User::where('name','LIKE', '%'.$query.'%')->orwhere('enroll_no','LIKE', '%'.$query.'%')->orderBy('name','asc')->paginate(5)->setPath ( '' ); 
            $pagination = $student->appends ( array (
                'searchStudent' => $query
            ) );
        return view('studentList',['student'=>$student]); 
	}
	public function getLessonPlan(Request $request,$id){
		$lesson_complete =  LessionPlan::where('user_id',$id)->where('draft_page',3)->paginate(5); 
		return view('lessionList',['lesson_complete' => $lesson_complete,'id' => $id]);

	}
	public function viewLession(Request $request,$id,$uid){
		$user = User::find($uid);
    	$lession_result = LessionPlan::where('id',$id)->first();  
        return view('lessionPlansEdit',['lession_result'=>$lession_result,'user' => $user]);
	}
	public function viewLession2(Request $request,$id,$uid){
		$lession_result = LessionPlan::where('id',$id)->first();  
        return view('lessionPlan2Edit',['lession_result'=>$lession_result,'uid' => $uid]);
	}
	public function viewLession3(Request $request,$id,$uid){
		$lession_result = LessionPlan::where('id',$id)->first();  
   		return view('lessionPlan3Edit',['id'=>$id,'lession_result' => $lession_result,'uid' => $uid]);
	}
	public function observerLession3(Request $request,$id,$uid){
		$lession_result = LessionPlan::where('id',$id)->first();  
		$lession_result->observers_remark = $request->observers_remark;
		$lession_result->observers_sign = $request->observers_sign;
		$lession_result->observers_date = $request->observers_date;
		$lession_result->update();

		return redirect()->route('getLessonPlan',$uid);

	}
}
