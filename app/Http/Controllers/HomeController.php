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
        $allQuiz = \DB::table('quizzes')
        ->select('title', 'no_of_questions', 'users.id' , 'users.name','quizid')
        ->join('users', 'users.id', '=', 'quizzes.user_id')
        ->where('user_id', '!=' , Auth::user()->id)
        ->where('permitted', '=', true)
        ->get();
        return view('home', ['allQuiz' => $allQuiz]);
    }
}
