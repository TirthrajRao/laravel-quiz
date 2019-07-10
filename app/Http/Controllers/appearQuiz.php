<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Auth;
use App\User;
use App\Question;
use App\Quiz;
use App\UserResponse;
use App\QuizAppear;
use App\AverageScore;
use Debugbar;
use Redirect;


class appearQuiz extends Controller
{
    /**
     * authenticates the user
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * For Welcome Page of Quiz(Guidlines and rules)
     */
    public function quizWelcome(Request $request, Quiz $quiz){
    	return view('quizWelcome', ['test' => $quiz]);
    }

    /**
     * For Quiz Questions(One Question at a time using Pagination)
     */
    public function takeQuiz(Quiz $quiz){
    	$quizId = 	$quiz['quizid'];
        $allQuestion = Question::where('quiz_id', $quizId)->paginate(1);
        $totalQuestionCount = Question::where('quiz_id', $quizId)->count();
        return view('appearQuiz', ['questions' => $allQuestion, 'quiz' => $quiz]);
    }

    /**
     * Storing last question and displaying results
     */
    public function store(Request $request){
        $question_id = $request->input('question_id');
        $time_remaining = $request->input('queDuration');
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

        $duration = preg_split('/:/', $time_remaining);
        $time_remaining_in_seconds = ((int)$duration[0] * 60) + ((int)$duration[1]);
        
        $uniqueQuizQuery = \DB::table('quiz_appears')->where('user_id', $userId)->orderBy('quizappearid','desc')->first();

        $uniqueQuizAppearId = $uniqueQuizQuery->quizappearid;
        $marks_scored = $uniqueQuizQuery->marks_scored;
        $userResponse = new UserResponse;
        $userResponse->user_id = $userId;
        $userResponse->userData_appear = $uniqueQuizAppearId;
        $userResponse->quiz_id = $quizid;
        $userResponse->question_id = $question_id;

        if ($answer == null) {
            $userResponse->user_response = "Not Answered";
        }else{
            $userResponse->user_response = $answer;
        }

        $findQuestion = \DB::table('questions')->where('questionid', $question_id)->first();

        $correctAnsDb = $findQuestion->answer;
        $totalTimeForQuestion = $findQuestion->question_duration;

        $time_taken = $totalTimeForQuestion - $time_remaining_in_seconds;
        $userResponse->time_taken = $time_taken;
        
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
       return view('finishQuiz', [
        'score_percentage' => $percentage_correct, 'questionsCount' => $questionsCount, 'uniqueQuizAppearId' => $uniqueQuizAppearId]);
   }

    /**
     * Storing all attemted questions by users except last Question
     */
    public function nextClickStore(request $request){
        $page = $request->input('page');
        $question_id = $request->input('question_id');
        $time_remaining = $request->input('queDuration');
        $question_id = reset($question_id);
        $quizid = $request->input('quiz-id');
        $userId  = Auth::user()->id;
        $userName  = Auth::user()->name;
        $answer = $request->input('answer');
        $answer = reset($answer);

        $duration = preg_split('/:/', $time_remaining);
        $time_remaining_in_seconds = ((int)$duration[0] * 60) + ((int)$duration[1]);

        if ($page == 1) {
            $newQuizAppear = new QuizAppear;
            $newQuizAppear->marks_scored = 0;
            $newQuizAppear->user_id = $userId;
            $newQuizAppear->user_name = $userName;
            $newQuizAppear->quiz_id = $quizid;
            $newQuizAppear->save();
        }

        $uniqueQuizQuery = \DB::table('quiz_appears')->where('user_id', $userId)->orderBy('quizappearid','desc')->first();

        $uniqueQuizAppearId = $uniqueQuizQuery->quizappearid;
        $marks_scored = $uniqueQuizQuery->marks_scored;
        $userResponse = new UserResponse;
        $userResponse->user_id = $userId;
        $userResponse->userData_appear = $uniqueQuizAppearId;
        $userResponse->quiz_id = $quizid;
        $userResponse->question_id = $question_id;

        if ($answer == null) {
            $userResponse->user_response = "Not Answered";
        }else{
            $userResponse->user_response = $answer;
        }

        $findQuestion = \DB::table('questions')->where('questionid', $question_id)->first();

        $correctAnsDb = $findQuestion->answer;
        $totalTimeForQuestion = $findQuestion->question_duration;

        $time_taken = $totalTimeForQuestion - $time_remaining_in_seconds;
        $userResponse->time_taken = $time_taken;

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
        return redirect('/takeQuiz/'.$quizid.'?page='.$page);
    }
}