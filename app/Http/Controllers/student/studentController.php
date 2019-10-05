<?php

namespace App\Http\Controllers\student;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Auth;
use QuizAppear;
use DB;

class studentController extends Controller
{
    public function dashboard()
    {
        $allQuiz = DB::table('quizzes')
        ->select('title', 'no_of_questions','users.id','users.name','quizid','status','attempt_no_of__que','question_id')
        ->join('users', 'users.id', '=', 'quizzes.user_id')         
        ->leftJoin('user_responses', 'user_responses.quiz_id', '=', 'quizzes.quizid')       
        ->where('quizzes.user_id', '!=' , Auth::user()->id)        
        ->where('quizzes.user_year','=',Auth::user()->year)   
        ->where('quizzes.permitted', '=', true)     
        ->groupBy('quizzes.quizid')
        ->orderBy('quizzes.created_at','desc')  
        ->get();
          
                        
         $allQuizArray = array();
        foreach($allQuiz as $allQuizes){
            $allQuizArray[] = $allQuizes->quizid;    
             }
        $userResonse = DB::table('user_responses')
                       ->whereIn('quiz_id', $allQuizArray)
                       ->get();  
    	return view('student/studentDashboard',['allQuiz' => $allQuiz,'userResonse' => $userResonse]);
    }
     
    
}
