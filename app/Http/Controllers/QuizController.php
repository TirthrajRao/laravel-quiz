<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;


use App\Http\Requests;
use Auth;
use App\User;
use App\Question;
use App\Quiz;
use App\Suggestion;
use Debugbar;
use Redirect;
use Mail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Contracts\Support\Jsonable;



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
		$user = Auth::user();		
		$users = User::where('is_admin',1)
		->where('id','!=', $user->id)	
		->get();
		$testsByMe = Quiz::where('user_id', Auth::user()->id)->orderBy('created_at','Desc')->paginate(5);
		return view('createQuiz', ['testCreated' => $request->get('testCreated'), 'testsByMe' => $testsByMe,'users' => $users]);
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
		
        $user = Auth::user();
        $qtitle = $request->get('quiz-title'); 
        $quizResult = Quiz::where('user_id',$user->id)->where('title',$qtitle)->first();  
        if($quizResult != ''){          
		$validator = Validator::make($request->all(), [
			'quiz-title' => 'required|max:255|unique:quizzes,title',
			'num-questions' => 'required|integer|min:2',
		]);

      

        }else{
            $validator = Validator::make($request->all(), [
            'quiz-title' => 'required|max:255',
            'num-questions' => 'required|integer|min:2',
        ]);

        }

          if ($validator->fails()) {
             return redirect('createQuiz')
                        ->withErrors($validator)
                        ->withInput();
        } 
		

		$quiz = new Quiz;
		$quiz->title = $request->get('quiz-unit').','.$request->get('quiz-number');
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
		
		$questions = Question::where('quiz_id', '=', $quiz->quizid)->get();
		return view('viewQuiz', ['questionsCount' => $questionsCount,'test' => $quiz, 'questions' => $questions, 'questionAdded' => $request->get('questionAdded'), 'minQuestions' => $request->get('minQuestions')]);
	}


	/**
     * Add Question to the quiz
     */
	public function addQuestion(Request $request, Quiz $quiz, $quizId){	
		$this->validate($request, [
			'question-text' => 'required',
			'question-type' => 'required',
			/*'question-duration' => 'required|regex:/([0-9]{1,2}):([0-5][0-9])/',*/
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
		/*if(empty($request->get('question-duration'))) {
			$question->question_duration = 300;
		} else {
			$duration = preg_split('/:/', $request->get('question-duration'));
			$question->question_duration = ((int)$duration[0] * 60) + ((int)$duration[1]) ;
		}*/
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
		->update(['permitted' => true,'user_year' => $request->year]);
		return redirect('/viewQuiz/'.$quizId);	
	}

    /**
     * Deactivate a Quiz
     */
    public function deactivateQuiz(Request $request, Quiz $quiz, $quizId)
    {
    	\DB::table('quizzes')
    	->where('quizid', $quizId)
    	->update(['permitted' => false,'user_year' => Null]);
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
    /**
     * update a Quiz
     */
    public function updateQuiz(Request $request){
    	
    	$quizEditId = $request->get('quizEditId');
    	$queQuizTitle = $request->get('quiz_title');

    	$queQuiznum = $request->get('num-questions');  
    	$result = Quiz::where('user_id', Auth::user()->id)->where('quizid',$quizEditId)->first();

    	if($result->title != $queQuizTitle){
    		$this->validate($request, [
    			'quiz_title' => 'required|unique:quizzes,title|max:255',
				'num-questions' => 'required|integer|min:2',
		]);
    	
    	}
    	
    	$result->title = $queQuizTitle;
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
	 /**
     * ajax function for get question detail
     */
	 public function getQuestionData($id){
	 	$questions_data = Question::where('questionid', '=', $id)->first();	
	 	return response()->json(['data' => 'success','questions_data' => $questions_data]);

	 }
	 /**
     *  edit functionality for edit question
     */
	 public function editQuestion(Request $request, $id){	 	
	 	$this->validate($request, [
	 		'question-text-edit' => 'required',
	 		'question-type-edit' => 'required',	 		
	 		'answer-edit' => 'required_if:question-type-edit,mcq,fib',
	 		'option1-edit' => 'required_if:question-type-edit,mcq',
	 		'option2-edit' => 'required_if:question-type-edit,mcq',
	 		'option3-edit' => 'required_if:question-type-edit,mcq',
	 		'option4-edit' => 'required_if:question-type-edit,mcq',
	 	]);

	 	$queId = $request->get('quesionModelIdEdit');
	 	$question = Question::where('questionid',$queId)->first();	 	
	 	$question->question = $request->get('question-text-edit');
	 	$question->question_type = $request->get('question-type-edit');
	 	/*if(empty($request->get('question-duration-edit'))) {
	 		$question->question_duration = 300;
	 	} else {
	 		$duration = preg_split('/:/', $request->get('question-duration-edit'));
	 		$question->question_duration = ((int)$duration[0] * 60) + ((int)$duration[1]) ;
	 	}*/
	 	$question->answer = $request->get('answer-edit');
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
	 		$question->answer = $request->get('tfanswer');
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
	 /**
     * share quiz to another teacher
     */
	 public function shareQuiz(Request $request){
	 	$quizEditId = $request->get('quizshareId');
	 	$teacher_id = $request->get('teacher_id');
	 	/*$list = implode(', ', $quizEditId); */
	 	$result = User::where('id',$teacher_id)->first();
	 	$quizId = $result->shared_quiz_id;
     	/*echo "quiz id-".$quizId;
     	echo "teacher_id-".$teacher_id;*/
     	/*echo $quizId.','.$quizEditId;
     	exit;*/
     	/*$qid = $quizId.','.$quizEditId;
     	echo $qid;
     	exit;*/
     	if($quizId == ''){
     		$qid = $quizEditId;
     	}else{
     		$qid = $quizId.','.$quizEditId;
     	}
     	$result->shared_quiz_id = $qid;
     	$result->update();
     	return Redirect::to('createQuiz')->with('success','Quiz shared successfully');

     }
     public function verify_step(Request $request){
     	$userid = $request->userId;
     	$result = User::find($userid);     	
     	$admin = User::where('is_admin',2)->first();
     	$result->idcard_no = $request->idCardNo;
     	$result->designation = $request->designation;
     	$result->qualification = $request->qualification;
     	$result->update();
     	/* send mail to admin */
     	$subject = 'Verification Email';
     	$Email = $admin->email; 
     	$c_date =  date('d/m/Y');
     	$html = '<table width="650" align="center" cellspacing="0" cellpadding="0" border="0" bgcolor="#ffffff">

     	<tr>
     	<td bgcolor="#00c1d4" style="font-family: Verdana, Geneva, Tahoma, sans-serif; font-size: 17px; color:#ffffff; padding: 12px 20px;">A new request has been marked for approval</td>
     	</tr>
     	<tr>
     	<td style="padding: 20px;">
     	<table width="100%" cellspacing="0" cellpadding="0" border="0" bgcolor="#ffffff">
     	<tr>
     	<td style="font-family: Verdana, Geneva, Tahoma, sans-serif; font-size: 15px; color:#3a3a3a; line-height: 22px;">
     	<span>Hi '.$admin->name.',</span><br /><br />

     	A new request from '.$result->email.' has been marked for approval on '.$c_date.'.<br /><br />
     	Please visit the <a href="'. env('APP_URL').'/admin/login"  style="white-space: nowrap; display: inline-block; color: #00c1d4;">admin section to review and approve it</a>.
     	</td>
     	</tr>
     	<tr>
     	<td height="70"></td>
     	</tr>                   
     	</table>
     	</td>
     	</tr>
     	</table>';
     	$data_mail = array('subject'=>$subject,'email'=>$Email,'html'=>$html);

     	Mail::send(array(), $data_mail, function($message) use ($data_mail) {
     		$message->to($data_mail['email'])->subject($data_mail['subject']);
		//$message->from(env('MAIL_FROM_ADDRESS'),env('MAIL_FROM_NAME'));
     		$message->setBody($data_mail['html'], 'text/html');
     	});
     	if($result->is_approved == 1){
     		return Redirect::to('home');
     		
     	}else{
     		return view('welcome_user');

     	}     	
     }	
     public function studentList(Request $request){
     	/*$student_fyear = User::where('is_admin',0)->where('year','1')->orderBy('name','asc')->orderBy('year','asc')->get()->toArray();
     	$student_syear = User::where('is_admin',0)->where('year',2)->orderBy('name','asc')->orderBy('year','asc')->get()->toArray();*/
     	/*$merged = $student_fyear->merge($student_syear);
     	$student = $merged->all();*/
     	//$student = array_merge($student_fyear, $student_syear);
        $id = $request->changeYear; 
        if($id != ''){
            $student = User::where('year',$id)->where('is_admin',0)->orderBy('name','asc')->orderBy('year','asc')->paginate(5)->setPath ( '' ); 
            $pagination = $student->appends ( array (
                'changeYear' => $id
            ) );

        }else{
        $student_fyear = User::where('is_admin',0)->where('year','1')->orderBy('name','asc')->orderBy('year','asc')->get();
        $student_syear = User::where('is_admin',0)->where('year',2)->orderBy('name','asc')->orderBy('year','asc')->get();
        $student = $student_fyear->merge($student_syear)->paginate(5);
        }
     	
     /*	$student_syear = User::where('is_admin',0)->orderBy('name','asc')->orderBy('year','asc')->get();*/
     	return view('studentList',['student'=>$student]); 

     }
     public function deleteStudent($id)
     {
     	$user = User::find($id)->delete();
     	return redirect('/studentList')->with('success','Student deleted successfully'); 
     }
     public function addSuggestion(Request $request)
     {
     	$user = Auth::user();
     	Suggestion::create([
     		'user_id' => $user->id,
     		'quiz_id' => $request->qId,
     		'suggestion' => $request->get('suggestion-text'),

     	]);
    	/*$qid = $request->qId;
    	$suggestion = $request->get('suggestion-text');
    	$result = Quiz::where('quizid',$qid)->first();
    	$result->suggestion = $suggestion;
    	$result->update();*/
    	return redirect('/home')->with('success','Suggestion Added successfully');	
    }
    public function createUser(Request $request)
    {
    	$this->validate($request, [
			'name' => 'required|string|max:255',
			'email' => 'required|string|email|max:255|unique:users',
			'password' => 'required|string|min:3|confirmed',
		]);
    	 
    	if($request['imA'] == 'teacher'){
    		$check_user = '1';
    		$enrollNo =  Null;
    	}else{
    		$check_user = '0';
    		$enrollNo = $request['eno']; 
    		$year = $request['year'];
    		$batch = $request['batch'];

    	}

    	User::create([
    		'name' => $request['name'],
    		'email' => $request['email'],
    		'enroll_no' => $enrollNo,
    		'is_admin' => $check_user,
    		'year' => $year, 
    		'batch' => $batch,      
    		'password' => Hash::make($request['password']),
    	]);
    	return redirect('/studentList')->with('success','Student Added successfully');	

    }
    public function detailPage(Request $request,$id)
    {	
    	$student = \DB::table('users')
    	->where('is_admin',1)
    	->whereRaw("find_in_set('".$id."',shared_quiz_id)")
    	->orderBy('name','Asc')
    	->paginate(5);
    	$suggestion = \DB::table('suggestion')
    	->select('name','title','quizid','suggestion.suggestion')
    	->join('quizzes', 'quizzes.quizid', '=', 'suggestion.quiz_id')
    	->join('users','users.id','=','suggestion.user_id')
    	->where('quizid',$id)      	
    	->get();    				
    	return view('detailPage',['student'=>$student,'suggestion'=>$suggestion,'id' => $id]);
    } 
    public function getName(Request $request,$id)
    {
    	$user = Auth::user();		
		/*$users = User::where('is_admin',1)
				->where('id','!=', $user->id)	
				->get();*/
		$result = \DB::table('users')
				->whereRaw('FIND_IN_SET("'.$id.'",users.shared_quiz_id)')	
				->get();				
		if(!$result->isEmpty()){			
			$uId = array();
			foreach($result as $results){
				$uId[] = $results->id;					
			}	
			foreach($uId as $uIds){						
			$admin_user_id = $uId;
			$users = User::where('is_admin',1)->where('id','!=', $user->id)->get();
			$teacherArray = $users->except($admin_user_id);			
			}
		}else{			
			$teacherArray = User::where('is_admin',1)
			->where('id','!=', $user->id)	
			->get();
		}
		return response()->json(['success' => 'success','teacherArray' => $teacherArray]);
	}
	public function suggestion(Request $request,$id,$qid)
	{
		$suggestion = \DB::table('suggestion')
    	->select('name','title','quizid','suggestion.suggestion')
    	->join('quizzes', 'quizzes.quizid', '=', 'suggestion.quiz_id')
    	->join('users','users.id','=','suggestion.user_id')
    	->where('quizid',$qid)
    	->where('users.id','=', $id)	
    	->orderBy('suggestion.created_at','Desc')
    	->get(); 
    	return view('suggestion',['suggestion'=>$suggestion]);
    }
    public function quizDetail(Request $request,$quiz )
	{
		$title = Quiz::where('quizid',$quiz)->first();		
		$questionsCount = Question::where('quiz_id', '=', $quiz)->count();
		
		$questions = Question::where('quiz_id', '=', $quiz)->get();

		return view('quizDetail', ['questionsCount' => $questionsCount,'title' => $title, 'questions' => $questions,'quiz' => $quiz]);
	}
	public function sharedQuiz(Request $request )
	{
		$user = Auth::user();        
        $id =  $user->id;  
		$result = User::where('id',$id)->first();
        $idsArr = explode(',',$result->shared_quiz_id);            
        $allQuiz = \DB::table('quizzes')
        ->select('title', 'no_of_questions', 'users.id' , 'users.name','quizid')
        ->join('users', 'users.id', '=', 'quizzes.user_id')
        ->where('user_id', '!=' , Auth::user()->id)
        ->where('permitted', '=', true)
        ->whereIn('quizid',$idsArr)       
        ->get(); 

		return view('SharedQuiz',['allQuiz'=> $allQuiz]);
	}
	
			
}
