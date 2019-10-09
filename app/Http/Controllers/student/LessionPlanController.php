<?php

namespace App\Http\Controllers\student;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Redirect;
use Auth;
use App\LessionPlan;
use DB;
use Response;
use PDF;

class LessionPlanController extends Controller
{
    public function lessionPlan()
    {
    	$user = Auth::user();
    	return view('student/lessionPlan',['user'=>$user]);
    }
    public function lessionList()
    {
    	$user = Auth::user();
    	$lesson_complete =	LessionPlan::where('user_id',$user->id)->where('draft_page',3)->orderBy('created_at','Desc')->count();
        $lesson_complete =  LessionPlan::where('user_id',$user->id)->where('draft_page',3)->orderBy('created_at','Desc')->paginate(5, ['*'], 'published'); 
        $lession_draft = LessionPlan::orwhere('draft_page',null)->orderBy('created_at','Desc')->where('user_id',$user->id)->paginate(5, ['*'], 'unpublished'); 
        $lession = LessionPlan::where('user_id',$user->id)->paginate(5);
      /* if($lesson_complete >= 5){    
        $lesson_complete =  LessionPlan::where('user_id',$user->id)->where('draft_page',3)->orderBy('created_at','Desc')->paginate(5, ['*'], 'published');
       }else{
           
        $lesson_complete =  LessionPlan::where('user_id',$user->id)->where('draft_page',3)->orderBy('created_at','Desc')->get();
       }

    	$lession = LessionPlan::where('user_id',$user->id)->paginate(5);

    	$lession_draft = LessionPlan::orwhere('draft_page',null)->orderBy('created_at','Desc')->where('user_id',$user->id)->count(); 
        if($lession_draft >= 5){
           
            $lession_draft = LessionPlan::orwhere('draft_page',null)->orderBy('created_at','Desc')->where('user_id',$user->id)->paginate(5, ['*'], 'unpublished'); 
        }else{
           
            $lession_draft = LessionPlan::orwhere('draft_page',null)->orderBy('created_at','Desc')->where('user_id',$user->id)->get(); 
        }*/
       
       // $lession_draft->setPageName('other_page');
    	
    	return view('student/lessionList',['lesson_complete' => $lesson_complete, 'user'=>$user,'lession' => $lession,'lession_draft' => $lession_draft]);
    }
    public function deleteLession($id)
    {
    	$user = Auth::user();
    	$lession = LessionPlan::find($id)->delete();    	
        return redirect()->route('lessionList')->with('success','Lesson deleted successfully');
    }
    public function editLession($id)
    {
    	$user = Auth::user();
    	$lession_result = LessionPlan::where('id',$id)->first();  
        return view('student/lessionPlansEdit',['lession_result'=>$lession_result,'user' => $user]);
    }    
    
    public function createLession(Request $request,$id=0)
    { 

    	if(!empty($id)){
    		/* For Update */
    		$result = LessionPlan::find($id);
    		$result->lession_no = $request->lesson_no;
    		$result->school_name = $request->school_name;
    		$result->standard = $request->standard;
    		$result->subject = $request->subject;
    		$result->topic = $request->topic;
    		$result->date_lession = $request->datepicker1;
    		$result->period_no = $request->period_no;
    		$result->time = $request->time;
    		$result->time_to = $request->time_to;
    		$result->general_objectives = $request->general_objectives;
    		$result->approach_technique = $request->approach_technique;
    		$result->teaching_aids = $request->teaching_aids;
    		$result->text_book = $request->text_book;
    		$result->refernce_books = $request->refernce_books;
    		$result->author_book = $request->author_book;
    		$result->author_ref_book = $request->author_ref_book;
    		$result->pageno_refbook = $request->page_refbook;
    		$result->pageno_textbook = $request->page_textbook;
    		$result->update();

    	$lession_result = LessionPlan::where('id',$id)->first();  
        return view('student/lessionPlan2Edit',['lession_result'=>$lession_result]);

    	}else{
    		/* For Add */

    	
    	$user = Auth::user();
    	$obj = $request->specific_objectives;
       	$parts = explode("/\s/", $obj);   

    	$id = LessionPlan::insertGetId([
    		'user_id' => $user->id,
            'lession_no' => $request->lesson_no,
            'school_name' => $request->school_name,
            'standard' => $request->standard,
            'subject' => $request->subject,
            'topic' => $request->topic,
            'date_lession' => $request->datepicker1,

            'period_no' => $request->period_no,      
            'time' => $request->time,
			'time_to' => $request->time_to,
            'general_objectives' => $request->general_objectives,
            'approach_technique' => $request->approach_technique,
            'teaching_aids' => $request->teaching_aids,
            'text_book' => $request->text_book,
            'refernce_books' => $request->refernce_books,
            'author_book' => $request->author_book,
            'author_ref_book' => $request->author_ref_book,         
            'pageno_refbook' => $request->page_refbook,
            'pageno_textbook' => $request->page_textbook
        ]); 
       	return redirect()->route('lessionPlan2',$id);   
		}
    } 
    public function  lessionPlan2Edit(Request $request,$id)
    {
    	$lession_result = LessionPlan::where('id',$id)->first();
    	return view('student/lessionPlan2Edit',['lession_result' => $lession_result]);
    }
    
    public function  lessionPlan2(Request $request,$id)
    {
    	return view('student/lessionPlan2',['id' => $id]);
    }
    public function  addReference(Request $request)
    { 		
    	 $uniqueFileName = uniqid() . $request->file('reference')->getClientOriginalName();
    
        $request->file('reference')->move(base_path() . '/public/files', $uniqueFileName
 			);
    	return response()->json(['success' => 'success']);
    } 
    public function  createLession2(Request $request,$id)
    {    	
    	$result = LessionPlan::find($id);
    	 /* Second Page */      
			$files = $request->file('reference');
			if($files != ''){
			$asa = array();
			foreach($files as $file){

				$filename = $file->getClientOriginalName();			
				$extension = $file->getClientOriginalExtension();				
				$file->move(base_path() . '/public/files', $filename);
				$asa[] = $filename;			   
			}
			$comma_separated = implode(",", $asa);
			}else{
				$comma_separated = $result->reference;

			}
			$result->steps = $request->steps;
			$result->specific_objectives = $request->specific_objectives;
			$result->teaching_points = $request->teaching_points;
			$result->teacher_activity = $request->teacher_activity;
			$result->student_activity = $request->student_activity;
			$result->steps = $request->steps;
			$result->reference = $comma_separated;
            $result->reference_manual = $request->reference_manual;
			$result->evaluation = $request->evaluation;
			$result->draft_page = 2;
			$result->update();
			return redirect()->route('lessionPlan3',$id);
    }
    public function  lessionPlan3(Request $request,$id)
    {
    	$result = LessionPlan::where('id',$id)->select('subject','topic','standard','date_lession')->first();
    	return view('student/lessionPlan3',['id' => $id,'result'=>$result]);

    }
    public function  createLession3(Request $request,$id)
    {    	
    	$result = LessionPlan::find($id);

        $baseFromJavascript =  $request->base64;        
        $base_to_php = explode(',', $baseFromJavascript);
        $data = base64_decode($base_to_php[1]);
        $filename = /*rand(100,1000)*/$id.'.png';
        $filepath = base_path()."/public/canvas/".$filename; // or image.jpg
        file_put_contents($filepath,$data);

    	$result->assignment = $request->assignment;
    	$result->draft_page = 3;
        $result->diagram = $filename;
    	$result->update();
    	return redirect()->route('lessionList');

    } 
    public function  updateLesson2(Request $request,$id)
    {    	
    	$result = LessionPlan::find($id);

    	 /* Second Page */      
			$files = $request->file('reference');
			if($files != ''){
			$asa = array();
			foreach($files as $file){

				$filename = $file->getClientOriginalName();			
				$extension = $file->getClientOriginalExtension();				
				$file->move(base_path() . '/public/files', $filename);
				$asa[] = $filename;			   
			}
			$comma_separated = implode(",", $asa);
			}else{
				$comma_separated = $result->reference;

			}
			$result->steps = $request->steps;
			$result->specific_objectives = $request->specific_objectives;
			$result->teaching_points = $request->teaching_points;
			$result->teacher_activity = $request->teacher_activity;
			$result->student_activity = $request->student_activity;
			$result->steps = $request->steps;
			$result->reference = $comma_separated;
            $result->reference_manual = $request->reference_manual;
			$result->evaluation = $request->evaluation;
			$result->update();

			$lession_result = LessionPlan::where('id',$id)->first();  
   			return view('student/lessionPlan3Edit',['id'=>$id,'lession_result' => $lession_result]);

    }
    public function  updateLession3(Request $request,$id)
    {
    	$result = LessionPlan::find($id);

        $baseFromJavascript =  $request->base64;      
        $base_to_php = explode(',', $baseFromJavascript);
        $data = base64_decode($base_to_php[1]);       
        $filename = $id.'.png';
        $filepath =  base_path()."/public/canvas/".$filename; // or image.jpg

        if(file_exists($filename)){
           
        
           unlink(base_path() .  '/public/canvas/' . $filename);
       }

        file_put_contents($filepath,$data);

    	$result->assignment = $request->assignment;
    	$result->draft_page = 3;
        $result->diagram = $filename;
    	$result->update();
    	return redirect()->route('lessionList');
    }
    public function  openPdf(Request $request,$docFile)
    { 	
        $file = base_path()."/public/files/".$docFile;
       // $file='/var/www/html/shraddha/laravelQuiz/public/files/'.$docFile;
         $extension = explode(".",$docFile);

         foreach($extension as $extensions){
            if($extensions == 'pdf'){
               $content_types =  'application/pdf';
            }elseif($extensions == 'doc'){
               $content_types =  'application/msword';
            }elseif($extensions == 'txt'){
                $content_types =   'application/octet-stream';
            }elseif($extensions == 'docx'){
                $content_types =     'application/vnd.openxmlformats-officedocument.wordprocessingml.document';
            }elseif($extensions == 'ppt'){
                $content_types = 'application/vnd.ms-powerpoint';
            }elseif($extensions == 'odt'){
                $content_types = 'application/vnd.ms-powerpoint';
            }elseif($extensions == 'txt'){
                $content_types = 'text/plain';
            }elseif($extensions == 'rtf'){
                $content_types = 'text/plain';
            }
            elseif($extensions == 'png'){
                $content_types = 'text/plain';
            }
            elseif($extensions == 'jpg'){
                $content_types = 'text/plain';
            }
            elseif($extensions == 'jpeg'){
                $content_types = 'text/plain';
            }
            elseif($extensions == 'gif'){
                $content_types = 'text/plain';
            }
         }
         $content = file_get_contents($file);               
         return Response::make($content, 200, array('content-type'=>$content_types));

    }
    public function  downloadLesson(Request $request,$id)
    {    
        
        $lession_result = LessionPlan::find($id);
        $user = Auth::user();
        $pdf = PDF::loadView('student/lessonform', ['user' =>$user,'lession_result' => $lession_result]);
        return $pdf->download('Lesson Plan.pdf');
    } 
}
