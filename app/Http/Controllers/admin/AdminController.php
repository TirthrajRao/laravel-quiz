<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Session;
use App\User;
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
          
          return redirect()->route('admindashboard');
        
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
}
