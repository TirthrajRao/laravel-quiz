<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function viewAllQuiz()
    {
        $user = Auth::user();        
        $id =  $user->id;   

        /* if user complete second step of verification and wait for admin approval */  
        if($user->is_admin == '1' && $user->is_approved == 0 && $user->idcard_no != ''){
            return view('welcome_user');
        }
        /* user complete first step of registration and move on second step */
        elseif($user->is_admin == '1' && $user->is_approved == 0 && $user->idcard_no == ''){
            return view('teacherSignup2',compact('id',$id));
        }elseif($user->is_admin == '0'){

        $result = User::where('id',$id)->first();
        $idsArr = explode(',',$result->shared_quiz_id);            
        $allQuiz = \DB::table('quizzes')
        ->select('title', 'no_of_questions', 'users.id' , 'users.name','quizid')
        ->join('users', 'users.id', '=', 'quizzes.user_id')
        ->where('user_id', '!=' , Auth::user()->id)
        ->where('permitted', '=', true)
        ->whereIn('quizid',$idsArr)       
        ->get();   
             return view('student/studentDashboard', ['allQuiz' => $allQuiz]);
        }
        /* user finished verification process */
        else{        
        $result = User::where('id',$id)->first();
        $idsArr = explode(',',$result->shared_quiz_id);            
        $allQuiz = \DB::table('quizzes')
        ->select('title', 'no_of_questions', 'users.id' , 'users.name','quizid')
        ->join('users', 'users.id', '=', 'quizzes.user_id')
        ->where('user_id', '!=' , Auth::user()->id)
        ->where('permitted', '=', true)
        ->whereIn('quizid',$idsArr)       
        ->get();        
        return view('home', ['allQuiz' => $allQuiz]);   
        }
    }
}
