<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;


use App\Http\Requests;
use Auth;
use App\User;
use App\Question;
use App\Quiz;
use Debugbar;
use Redirect;

class QuizController extends Controller
{	

	public function __construct()
	{
		$this->middleware('auth');
	}
	
	/**
     * Display all the Quizzes
     */
	public function showQuiz(Request $request){
		$testsByMe = Quiz::where('user_id', Auth::user()->id)->paginate(5);
		return view('createQuiz', ['testCreated' => $request->get('testCreated'), 'testsByMe' => $testsByMe]);
	} 
	public function getQuizData($id){
	$result = Quiz::where('user_id', Auth::user()->id)
				 ->where('quizid',$id)->first();

		  return response()->json(['data' => $result]);
	}
	

	/**
     * Creates the Quiz
     */
	public function createQuiz(Request $request){
		$this->validate($request, [
			'quiz-title' => 'required|unique:quizzes,title|max:255',
			'num-questions' => 'required|integer|min:2',
		]);

		$quiz = new Quiz;
		$quiz->title = $request->get('quiz-title');
		$quiz->no_of_questions = $request->get('num-questions');
		$quiz->permitted = false;
		$quiz->user_id = Auth::user()->id;

		$quiz->save();
		return Redirect::to('createQuiz')->with('success','Quiz created successfully');
	}

	/**
     * Delete Quiz
     */
	public function deleteQuiz($quizid){
		$quiz = Quiz::findOrFail($quizid);

		$questions = Question::where('quiz_id', $quizid);
		$questions->delete();
		$quiz->delete();
		return Redirect::to('createQuiz')->with('success','Quiz deleted successfully');
	}


	/**
     * View Single Quiz
     */
	public function viewQuiz(Request $request, Quiz $quiz){
		$questionsCount = Question::where('quiz_id', '=', $quiz->quizid)->count();
		
		$questions = Question::where('quiz_id', '=', $quiz->quizid)->paginate(5);
		return view('viewQuiz', ['questionsCount' => $questionsCount,'test' => $quiz, 'questions' => $questions, 'questionAdded' => $request->get('questionAdded'), 'minQuestions' => $request->get('minQuestions')]);
	}


	/**
     * Add Question to the quiz
     */
	public function addQuestion(Request $request, Quiz $quiz, $quizId){	
		$this->validate($request, [
			'question-text' => 'required',
			'question-type' => 'required',
			'question-duration' => 'required|regex:/([0-9]{1,2}):([0-5][0-9])/',
			'answer' => 'required_if:question-type,mcq,fib',
			'option1' => 'required_if:question-type,mcq',
			'option2' => 'required_if:question-type,mcq',
			'option3' => 'required_if:question-type,mcq',
			'option4' => 'required_if:question-type,mcq',
		]);
		$question = new Question;
		$quizId;

		$question->quiz_id = $quizId ;
		$question->user_id = Auth::user()->id;

		$question->question = $request->get('question-text');
		$question->question_type = $request->get('question-type');
		if(empty($request->get('question-duration'))) {
			$question->question_duration = 300;
		} else {
			$duration = preg_split('/:/', $request->get('question-duration'));
			$question->question_duration = ((int)$duration[0] * 60) + ((int)$duration[1]) ;
		}
		$question->answer = $request->get('answer');
		switch($request->get('question-type')) {
			case 'mcq':
			$question->option_1 = $request->get('option1');
			$question->option_2 = $request->get('option2');
			$question->option_3 = $request->get('option3');
			$question->option_4 = $request->get('option4');
			break;
			case 'fib':
			$question->option_1 = null;
			$question->option_2 = null;
			$question->option_3 = null;
			$question->option_4 = null;
			break;
			case 'tf':
			$question->option_1 = null;
			$question->option_2 = null;
			$question->option_3 = null;
			$question->option_4 = null;
			$question->answer = $request->get('tfanswer');
			break;
		}
		// $question;
		$question->save();
        $totalQuestionCount = Question::where('quiz_id', $quizId)->count();
        \DB::table('quizzes')
		->where('quizid', $quizId)
		->update(['total_questions' => $totalQuestionCount]);
		return redirect('/viewQuiz/'.$quizId)->with('success','Question added successfully'); 
	}

	/**
     * Activate a Quiz
     */
	public function activateQuiz(Request $request, Quiz $quiz, $quizId)
	{	
		$questionsCount = Question::where('quiz_id', '=', $quizId)->count();

		//query for selecting that quiz
		$myquery = \DB::table('quizzes')->where('quizid', $quizId)->select('no_of_questions');

		//extracting no_of_question from that query
		$getMinQuestionObj =  $myquery->get('no_of_questions');
		$x = json_decode($getMinQuestionObj, TRUE);
		$minQuestionsObj = array_column($x, 'no_of_questions');
		$minQuestionByInDb = $minQuestionsObj[0];

		$remQueToAct = $minQuestionByInDb - $questionsCount;
        //checking if no. of question created is less than no. of question for quiz
		if($questionsCount < $minQuestionByInDb) {
			return redirect('/viewQuiz/'.$quizId)->with('failure','Please enter ' . $remQueToAct.' more Question to activate the Quiz!');;    
		}
		
		$quiz->permitted = true;
		\DB::table('quizzes')
		->where('quizid', $quizId)
		->update(['permitted' => true]);
		return redirect('/viewQuiz/'.$quizId);	
	}

    /**
     * Deactivate a Quiz
     */
    public function deactivateQuiz(Request $request, Quiz $quiz, $quizId)
    {
    	\DB::table('quizzes')
    	->where('quizid', $quizId)
    	->update(['permitted' => false]);
    	return redirect('/viewQuiz/'.$quizId);
    }

    /**
     * Deleting a Quiz
     */
    public function deleteQuestion(Request $request, Quiz $quiz, $questionId){
    	$queQuizId = $request->get('queQuizId');
    	$question = Question::where('id', $questionId);
    	$question->delete();
    	return Redirect::to('/viewQuiz/'.$queQuizId)->with('success','Question deleted successfully');
    }
    public function updateQuiz(Request $request){

    	$quizEditId = $request->get('quizEditId');
		$queQuizTitle = $request->get('quiz-title');
		$queQuiznum = $request->get('num-questions');


		$result = Quiz::where('user_id', Auth::user()->id)->where('quizid',$quizEditId)->first();
		$result->title = $queQuizTitle;
		$result->no_of_questions = $queQuiznum;
		$result->no_of_questions = $queQuiznum;
		
		$result->update();
		$questionsCount = Question::where('quiz_id', '=', $quizEditId)->count();
		$myquery = \DB::table('quizzes')->where('quizid', $quizEditId)->select('no_of_questions');

		//extracting no_of_question from that query
		$getMinQuestionObj =  $myquery->get('no_of_questions');
		$x = json_decode($getMinQuestionObj, TRUE);
		$minQuestionsObj = array_column($x, 'no_of_questions');
		$minQuestionByInDb = $minQuestionsObj[0];
		$remQueToAct = $minQuestionByInDb - $questionsCount;
        //checking if no. of question created is less than no. of question for quiz
		if($questionsCount < $minQuestionByInDb) {
			$permission = false;
			$result->permitted = $permission;
			$result->update();
		}else{
			$permission = true;
			$result->permitted = $permission;
			$result->update();
		}
		return Redirect::to('createQuiz')->with('success','Quiz updated successfully');
	}
	public function delQuestion($id,$qid){
		$questions = Question::where('questionid', '=', $id)->delete();	
		return Redirect::to('/viewQuiz/'.$qid)->with('success','Question deleted successfully');
	 }
	 public function getQuestionData($id){
		$questions_data = Question::where('questionid', '=', $id)->first();	
		return response()->json(['data' => 'success','questions_data' => $questions_data]);

	 }
	 public function editQuestion(Request $request, $id){
	 	
	 $this->validate($request, [
			'question-text' => 'required',
			'question-type' => 'required',
			'question-duration' => 'required|regex:/([0-9]{1,2}):([0-5][0-9])/',
			'answer' => 'required_if:question-type,mcq,fib',
			'option1' => 'required_if:question-type,mcq',
			'option2' => 'required_if:question-type,mcq',
			'option3' => 'required_if:question-type,mcq',
			'option4' => 'required_if:question-type,mcq',
		]);

	 	$queId = $request->get('quesionModelIdEdit');
	 	$question = Question::where('questionid',$queId)->first();	 	
		$question->question = $request->get('question-text-edit');
		$question->question_type = $request->get('question-type-edit');
		if(empty($request->get('question-duration-edit'))) {
			$question->question_duration = 300;
		} else {
			$duration = preg_split('/:/', $request->get('question-duration-edit'));
			$question->question_duration = ((int)$duration[0] * 60) + ((int)$duration[1]) ;
		}
		$question->answer = $request->get('sel1-edit');
		switch($request->get('question-type-edit')) {
			case 'mcq':
			$question->option_1 = $request->get('option1-edit');
			$question->option_2 = $request->get('option2-edit');
			$question->option_3 = $request->get('option3-edit');
			$question->option_4 = $request->get('option4-edit');
			break;
			case 'fib':
			$question->option_1 = null;
			$question->option_2 = null;
			$question->option_3 = null;
			$question->option_4 = null;
			break;
			case 'tf':
			$question->option_1 = null;
			$question->option_2 = null;
			$question->option_3 = null;
			$question->option_4 = null;
			$question->answer = $request->get('sel1-edit');
			break;
		}
		// $question;
		$question->update();
        $totalQuestionCount = Question::where('quiz_id', $id)->count();
        \DB::table('quizzes')
		->where('quizid', $id)
		->update(['total_questions' => $totalQuestionCount]);
		return redirect('/viewQuiz/'.$id)->with('success','Question updated successfully'); 
	 }
	 
	 
	
}
