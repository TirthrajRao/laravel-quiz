<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Session;
use App\User;
use App\Quiz;
use App\Question;
use App\LessionPlan;
use App\QuizAppear;
use Charts;
use Hash;
use Mail;

session_start();

class AdminController extends Controller
{
    public function home(Request $request){      
		  return view('admin/adminLogin');
	}
	/**
     * create admin login
     */
	public function adminLogin(Request $request){
		    $email = $request->email;
        $password = ($request->password);         
        $result = User::where('email','=',$email)->where('is_admin','2')->first(); 
        if(count((array)$result) > 0 && Hash::check($password, $result->password)){
          $_SESSION['email'] = $email;
          $_SESSION['id'] = $result->id;
          $_SESSION['name'] = $result->name;
          $_SESSION['is_admin'] = $result->is_admin;
          
          return redirect()->route('teacherList');
        
        }else{        
        return redirect()->back()->withErrors("These credentials do not match our records.");
        } 		  
	}
	public function admindashboard(Request $request){
		return view('admin/admindashboard');
	}
  public function teacherList(Request $request){
    $teacher = User::where('is_admin',1)->orderBy('created_at','Desc')->paginate(5);
    return view('admin/teacherList',['teacher' => $teacher]);
  }
  public function approveTeacher(Request $request,$id){
    $teacher = User::where('id',$id)->first();
    $teacher->is_approved = 1;
    $teacher->update();
    /* send mail to teacher */
      $subject = 'Approve Email';
      $Email = $teacher->email; 
      $c_date =  date('d/m/Y');
      $html = '<table width="650" align="center" cellspacing="0" cellpadding="0" border="0" bgcolor="#ffffff">

      <tr>
      <td bgcolor="#00c1d4" style="font-family: Verdana, Geneva, Tahoma, sans-serif; font-size: 17px; color:#ffffff; padding: 12px 20px;">Your account has been successfully approved</td>
      </tr>
      <tr>
      <td style="padding: 20px;">
      <table width="100%" cellspacing="0" cellpadding="0" border="0" bgcolor="#ffffff">
      <tr>
      <td style="font-family: Verdana, Geneva, Tahoma, sans-serif; font-size: 15px; color:#3a3a3a; line-height: 22px;">
      <span>Hi '.$teacher->name.',</span><br /><br />

      Your request has been approved on '.$c_date.'.<br /><br />
      Please visit the <a href="'. env('APP_URL').'/login"  style="white-space: nowrap; display: inline-block; color: #00c1d4;">You can login here</a>.
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
    return redirect()->route('teacherList');
  }
  public function denyTeacher(Request $request,$id){
    $teacher = User::where('id',$id)->first();
    $teacher->is_approved = 0;
    $teacher->update();
     /* send mail to teacher */
      $subject = 'Deny Email';
      $Email = $teacher->email; 
      $c_date =  date('d/m/Y');
      $html = '<table width="650" align="center" cellspacing="0" cellpadding="0" border="0" bgcolor="#ffffff">

      <tr>
      <td bgcolor="#00c1d4" style="font-family: Verdana, Geneva, Tahoma, sans-serif; font-size: 17px; color:#ffffff; padding: 12px 20px;">Your account is deny by admin</td>
      </tr>
      <tr>
      <td style="padding: 20px;">
      <table width="100%" cellspacing="0" cellpadding="0" border="0" bgcolor="#ffffff">
      <tr>
      <td style="font-family: Verdana, Geneva, Tahoma, sans-serif; font-size: 15px; color:#3a3a3a; line-height: 22px;">
      <span>Hi '.$teacher->name.',</span><br /><br />

      Your account has been deny on '.$c_date.' Please contact the admin.<br /><br />
      
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
    return redirect()->route('teacherList');
  }
  public function deleteTeacher(Request $request,$id){  
    User::where('id',$id)->delete();    
  }
  public function adminLogout(){  
        session_destroy();
        return redirect()->route('admin/login');
  }
  public function QuizList(Request $request,$id){
    $user = User::find($id);
    $quizList = Quiz::where('user_id',$id)->paginate(12);    
    return view('admin/quizList', ['quizList' => $quizList,'user' => $user]);   
  }
  public function viewQuiz(Request $request,$id){
    $title = Quiz::where('quizid',$id)->first();
    $questions = Question::where('quiz_id', '=', $id)->get();
    $questionsCount = Question::where('quiz_id', '=', $id)->count();
    return view('admin/viewQuiz', ['questions' => $questions,'test' => $title,'questionsCount' => $questionsCount]);   
  }
  public function viewSuggestion(Request $request,$id,$uid){
    $title = Quiz::where('quizid',$id)->first();
    $suggestion = \DB::table('suggestion')        
      ->where('quiz_id',$id)     
      ->orderBy('suggestion.created_at','Desc')
      ->get();      
      return view('admin/suggestion',['suggestion'=>$suggestion,'title' => $title]);
  }
  public function searchTeacher(Request $request){
    $query = $request->searchTeacher;
    $teacher = User::where('is_admin',1)->where('name','LIKE', '%'.$query.'%')->orderBy('name','asc')->paginate(5)->setPath ( '' ); 
            $pagination = $teacher->appends ( array (
                'searchTeacher' => $query
            ) );
    return view('admin/teacherList',['teacher'=>$teacher]);
   }
   public function studentListAdmin(Request $request){
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
      return view('admin/studentList',['student'=>$student]); 
   }
  public function searchStudentadmin(Request $request){
    $query = $request->searchStudent;
    $student = User::where('name','LIKE', '%'.$query.'%')->orwhere('enroll_no','LIKE', '%'.$query.'%')->orderBy('name','asc')->paginate(5)->setPath ( '' ); 
            $pagination = $student->appends ( array (
                'searchStudent' => $query
            ) );
    return view('admin/studentList',['student'=>$student]); 
  }
  public function getLessonPlanAdmin(Request $request,$id){
    $lesson_complete =  LessionPlan::where('user_id',$id)->where('draft_page',3)->orderBy('created_at','Desc')->paginate(5); 
    return view('admin/lessionList',['lesson_complete' => $lesson_complete,'id' => $id]);
  }
  public function viewLessionadmin(Request $request,$id,$uid){  
    $user = User::find($uid);
      $lession_result = LessionPlan::where('id',$id)->first();  
        return view('admin/lessionPlansEdit',['lession_result'=>$lession_result,'user' => $user]);
  }
  public function viewLession2admin(Request $request,$id,$uid){    
    $lession_result = LessionPlan::where('id',$id)->first();  
        return view('admin/lessionPlan2Edit',['lession_result'=>$lession_result,'uid' => $uid]);
  }
  public function viewLession3admin(Request $request,$id,$uid){
    $lession_result = LessionPlan::where('id',$id)->first();  
      return view('admin/lessionPlan3Edit',['id'=>$id,'lession_result' => $lession_result,'uid' => $uid]);
  } 
  public function userReportadmin($id){
    $userId  = $id;
    $username =  User::find($userId);

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

    return view('admin/userResults', ['quizAppeared' => $quizAppeared,'username' => $username]);
  }
   public function singleResultadmin(Request $request, QuizAppear $quizappearid,$uid){

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

    return view('admin/viewSingleResult', ['question' => $allQuestions, 'chart' => $chart, 'countTrue' => $countTrue, 'totalQuestion' =>$totalQuestion,'uid' => $uid]);
  }
  public function viewLeaderboardadmin(Request $request, Quiz $quiz,$uid){
    $topScorer = \DB::table('average_scores')
    ->join('quizzes', 'quizzes.quizid', '=' , 'average_scores.quiz_id')
    ->join('users', 'users.id', '=', 'average_scores.user_id')
    ->where('quiz_id', $quiz->quizid)
    ->orderBy('avg_score', 'desc')
    ->limit(10)
    ->get(array('users.name', 'quizzes.title', 'quizzes.total_questions', 'average_scores.*'));
    return view('admin/quizLeaderboard', ['leaderboard' => $topScorer,'uid'=> $uid]);
  }
}
