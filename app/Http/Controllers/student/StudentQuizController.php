<?php

namespace App\Http\Controllers\student;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
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

class StudentQuizController extends Controller
{
     public function quizWelcome(Request $request, Quiz $quiz){
    	return view('student/quizWelcome', ['test' => $quiz]);
    }

    /**
     * For Quiz Questions(One Question at a time using Pagination)
     */
    public function takeQuiz(Quiz $quiz){    	
    	$quizId = 	$quiz['quizid'];
        $allQuestion = Question::where('quiz_id', $quizId)->paginate(1);
        $totalQuestionCount = Question::where('quiz_id', $quizId)->count();
        return view('student/appearQuiz', ['questions' => $allQuestion, 'quiz' => $quiz]);
    }

    /**
     * Storing last question and displaying results
     */
    public function store(Request $request){
        $question_id = $request->input('question_id');
       /* $time_remaining = $request->input('queDuration');*/
        $page = $request->input('page');       
        $question_id = reset($question_id);
        $quizid = $request->input('quiz-id');          
        $userId  = Auth::user()->id;
        $userName  = Auth::user()->name;
        $answer = $request->input('answer');
        if ($answer) {
            $answer = reset($answer);
        }else{
            $answer = '';
        }        

        /*$duration = preg_split('/:/', $time_remaining);
        $time_remaining_in_seconds = ((int)$duration[0] * 60) + ((int)$duration[1]);*/
        
        $uniqueQuizQuery = \DB::table('quiz_appears')->where('user_id', $userId)->where('quiz_id',$quizid)->orderBy('quizappearid','desc')->first();

        $uniqueQuizAppearId = $uniqueQuizQuery->quizappearid;
        $marks_scored = $uniqueQuizQuery->marks_scored;
        $userResponse = new UserResponse;
        $userResponse->user_id = $userId;
        $userResponse->userData_appear = $uniqueQuizAppearId;
        $userResponse->quiz_id = $quizid;
        $userResponse->question_id = $question_id;        
        $userResponse->attempt_no_of__que = $page; 

        if ($answer == null) {
            $userResponse->user_response = "Not Answered";
        }else{
            $userResponse->user_response = $answer;
        }

        $findQuestion = \DB::table('questions')->where('questionid', $question_id)->first();

        $correctAnsDb = $findQuestion->answer;
       /* $totalTimeForQuestion = $findQuestion->question_duration;

        $time_taken = $totalTimeForQuestion - $time_remaining_in_seconds;
        $userResponse->time_taken = $time_taken;*/
        
        if ($correctAnsDb == $answer) {
            $marks_scored += 1;
            \DB::table('quiz_appears')
            ->where('quizappearid', $uniqueQuizAppearId)
            ->update(['marks_scored' => $marks_scored]);
            $userResponse->correct = 1;
        }else{
            $userResponse->correct = 0;
        }

        $userResponse->save();
        $marks_scored = $marks_scored;

        $attempQue = \DB::table('user_responses')->where('user_id', $userId)->where('quiz_id',$quizid)->first();  

         \DB::table('user_responses')
            ->where('responseid', $attempQue->responseid)            
            ->update(['attempt_no_of__que' => $page]);

        /**
         * Storing average score for particular Quiz of user
        */
        $avgScoreCount = \DB::table('average_scores')->where('user_id', $userId)->where('quiz_id', $quizid)->count();

        $quizAppearCount = \DB::table('quiz_appears')->where('user_id', $userId)->where('quiz_id', $quizid)->count();

        $avg_marks = \DB::table('quiz_appears')
        ->where('user_id', $userId)
        ->where('quiz_id', $quizid)
        ->avg('marks_scored');

        $avgScore = new AverageScore;
        if ($avgScoreCount == 0 ) {
            $avgScore->user_id = $userId;
            $avgScore->quiz_id = $quizid;
            $avgScore->avg_score = $avg_marks;
            $avgScore->appear_count = $quizAppearCount;
            $avgScore->save();  
        }else{
            $userFindQuery = \DB::table('average_scores')->where('user_id', $userId)->where('quiz_id', $quizid)->select('avgid');
            $getAvgidObj = $userFindQuery->get('avgid');

            foreach ($getAvgidObj as $id){
               $avgId = $id->avgid;
           }
           $updateAvgScore = ['avg_Score' => $avg_marks, 'appear_count' => $quizAppearCount];
           AverageScore::where('avgid', $avgId)->update($updateAvgScore);
       }

       $questionsCount = Question::where('quiz_id', '=', $quizid)->count();

       $percentage_correct = 100 * $marks_scored / $questionsCount;
       return view('student/finishQuiz', [
        'score_percentage' => $percentage_correct, 'questionsCount' => $questionsCount, 'uniqueQuizAppearId' => $uniqueQuizAppearId]);
   }

    /**
     * Storing all attemted questions by users except last Question
     */
    public function nextClickStore(request $request){   

        $page = $request->input('page');             
        $question_id = $request->input('question_id');
        /*$time_remaining = $request->input('queDuration');*/
        $question_id = reset($question_id);
        $quizid = $request->input('quiz-id');
        $userId  = Auth::user()->id;
        $userName  = Auth::user()->name;
        $answer = $request->input('answer');
        if(!empty($answer)){       
        $answer = reset($answer);
        }
       /* $duration = preg_split('/:/', $time_remaining);
        $time_remaining_in_seconds = ((int)$duration[0] * 60) + ((int)$duration[1]);*/

        if ($page == 1) {
            $newQuizAppear = new QuizAppear;
            $newQuizAppear->marks_scored = 0;
            $newQuizAppear->user_id = $userId;
            $newQuizAppear->user_name = $userName;
            $newQuizAppear->quiz_id = $quizid;           
            $newQuizAppear->save();
        }      

        $uniqueQuizQuery = \DB::table('quiz_appears')->where('user_id', $userId)->where('quiz_id',$quizid)->orderBy('quizappearid','desc')->first();

       /*  echo "<pre>";
        print_r($uniqueQuizQuery);
        exit;*/

        $uniqueQuizAppearId = $uniqueQuizQuery->quizappearid;
       
        $marks_scored = $uniqueQuizQuery->marks_scored;
        $userResponse = new UserResponse;
        $userResponse->user_id = $userId;
        $userResponse->userData_appear = $uniqueQuizAppearId;
        $userResponse->quiz_id = $quizid;
        $userResponse->question_id = $question_id;
        $userResponse->status = 1;
        $userResponse->attempt_no_of__que = $page;

        if ($answer == null) {
            $userResponse->user_response = "Not Answered";
        }else{
            $userResponse->user_response = $answer;
        }

        $findQuestion = \DB::table('questions')->where('questionid', $question_id)->first();

        $correctAnsDb = $findQuestion->answer;
        /*$totalTimeForQuestion = $findQuestion->question_duration;

        $time_taken = $totalTimeForQuestion - $time_remaining_in_seconds;
        $userResponse->time_taken = $time_taken;*/

        if ($correctAnsDb == $answer) {
            $marks_scored += 1;
            \DB::table('quiz_appears')
            ->where('quizappearid', $uniqueQuizAppearId)
            ->update(['marks_scored' => $marks_scored]);

            $userResponse->correct = 1;

        }else{
            $userResponse->correct = 0;
        }
        
        $userResponse->save();
        $page += 1;
        return redirect('/takeQuizStudent/'.$quizid.'?page='.$page);
    }
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

		return view('student/viewSingleResult', ['question' => $allQuestions, 'chart' => $chart, 'countTrue' => $countTrue, 'totalQuestion' =>$totalQuestion]);
	}
	public function viewLeaderboard(Request $request, Quiz $quiz){
		$topScorer = \DB::table('average_scores')
		->join('quizzes', 'quizzes.quizid', '=' , 'average_scores.quiz_id')
		->join('users', 'users.id', '=', 'average_scores.user_id')
		->where('quiz_id', $quiz->quizid)
		->orderBy('avg_score', 'desc')
		->limit(10)
		->get(array('users.name', 'quizzes.title', 'quizzes.total_questions', 'average_scores.*'));
        $arrscore = array();
        foreach($topScorer as $arrytopScorer){
            $arrscore[] = $arrytopScorer->avg_score;
        }
     $ranks = array(1);
   /* for ($i = 1; $i < count($arrscore); $i++)
    {
        if ($arrscore[$i] != $arrscore[$i-1])
            $ranks[$i] = $i + 1;
        else
            $ranks[$i] = $ranks[$i-1];
    }*/



		return view('student/quizLeaderboard', ['leaderboard' => $topScorer,'arrscore'=> $arrscore]);
	}
	public function showAppearedQuiz(Request $request){
		$userId  = Auth::user()->id;

        

		/*$quizAppeared = \DB::table('quiz_appears')
		->join('quizzes', 'quizzes.quizid', '=', 'quiz_appears.quiz_id')
		->join('users','users.id', '=', 'quizzes.user_id')
		->where('quiz_appears.user_id', $userId)
		->select(array('quiz_appears.*', 'users.name','quizzes.title','quizzes.total_questions'))
        ->orderBy('quiz_appears.created_at','desc')
		->paginate(12);*/
        /* code */
        $testQuiz = \DB::table('quiz_appears')
        ->join('quizzes', 'quizzes.quizid', '=', 'quiz_appears.quiz_id')
        ->join('users','users.id', '=', 'quizzes.user_id')
        ->where('quiz_appears.user_id', $userId)
        ->select(array('quiz_appears.*', 'users.name','quizzes.title','quizzes.quizid','quizzes.no_of_questions','quizzes.total_questions'))
        ->orderBy('quiz_appears.created_at','desc')
        ->get();
        $quizId = array();
        //$latestQue = array();
        foreach($testQuiz as $testQuizes){           
            $latestQue = \DB::table('user_responses')->where('user_id',$userId)->where('quiz_id',$testQuizes->quizid)->latest()->first();
            $att_que_user = $latestQue->attempt_no_of__que;
            if($testQuizes->no_of_questions == $att_que_user){
                $quizId[] =  $testQuizes->quizid;  
            }
        }        
        $quizAppeared = \DB::table('quiz_appears')
        ->join('quizzes', 'quizzes.quizid', '=', 'quiz_appears.quiz_id')
        ->join('users','users.id', '=', 'quizzes.user_id')
        ->whereIn('quizzes.quizid',$quizId)
        ->where('quiz_appears.user_id', $userId)
        ->select(array('quiz_appears.*', 'users.name','quizzes.title','quizzes.quizid','quizzes.no_of_questions','quizzes.total_questions'))
        ->orderBy('quiz_appears.created_at','Desc')
        //->groupBy('quiz_appears.quiz_id')
        ->paginate(12);    
		return view('student/userResults', ['quizAppeared' => $quizAppeared]);
	}
}
