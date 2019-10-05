<?php

namespace App\Http\Controllers\admin;
use Excel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use App\User;
use Session;
use DB;
use Auth;
use Carbon\Carbon;
use PDF;


session_start();
class AdminController extends Controller
{
    
    public function index()
    {
      checkLogin(isset($_SESSION['email']));
        return view('auth/adminLogin');
    }
    public function createLogin(Request $request)
    {
        $email = $request->email;
        $password = ($request->password);         
        $result = User::where('email','=',$email)->where('isadmin','1')->first(); 

    if(count((array)$result) > 0 && Hash::check($password, $result->password)){
          $_SESSION['email'] = $email;
          $_SESSION['id'] = $result->id;
          $_SESSION['username'] = $result->username;
          $resultValue = $result->user_number_of_logins;
          $num_of_login = $resultValue + 1;
          $user_last_login = Carbon::now();
          $result->user_number_of_logins = $num_of_login;
          $result->user_last_login = $user_last_login;
          $result->update();
          return redirect()->route('admindashboard');
        
        }else{        
        return redirect()->back()->withErrors("These credentials do not match our records.");
        } 
        
    }
    public function adminDashboard()
    {
      if(!empty($_SESSION['email']))
      {
        return view('admin/dashboard');
      }
      else
      {
        return view('auth/adminLogin');
      }
      
    }
    public function logout()
    {
        session_destroy();
        return redirect()->route('adminlogin');
    }
    public function admingreenhouse()
    {     
      //$greenhouse_list = DB::table('green_house')->get();
        $greenhouse_list = DB::table('green_house')->orderBy('GreenHouseId', 'desc')->get();

        /*$users = DB::table(DB::raw('('.
    DB::table('green_house')->orderBy('GreenHouseId', 'desc').') foo'))->orderBy('bar', 'asc')->get();*/
      if(!empty($_SESSION['email']))
      {
        return view('admin/greenhouse', ['greenhouse_list' => $greenhouse_list]);
      }
      else
      {
        return view('auth/adminLogin');
      }
    }
    public function greenhouse_export($type)
    {
       $csv_array = array();
       $data = DB::table('green_house')->select('Name', 'InitiativeName', 'EmailId','Telephone','CountryId','OtherReason')->orderBy('GreenHouseId', 'desc')->get();   
        
        foreach ($data as $key => $value) {
           $csv_array[] = (array) $value;
        }   
        $curr_date = date('d-m-Y');
        $curr_date = str_replace('-', '', $curr_date);
       
        $filename = 'greenhouse_reportlist'.$curr_date;


        return Excel::create($filename, function($excel) use ($csv_array) {
            $excel->sheet('Greenhouse List', function($sheet) use ($csv_array)
            {
                $sheet->cell('A1', function($cell) {$cell->setValue('Name'); });
                $sheet->cell('B1', function($cell) {$cell->setValue('Initiative name'); });
                $sheet->cell('C1', function($cell) {$cell->setValue('Email'); });
                $sheet->cell('D1', function($cell) {$cell->setValue('Phone No.'); });
                $sheet->cell('E1', function($cell) {$cell->setValue('Country'); });
                $sheet->cell('F1', function($cell) {$cell->setValue('Description'); });

                if (!empty($csv_array)) {
                    foreach ($csv_array as $key => $value) {
                        $i= $key+2;
                        // $greenhouse= DB::table('green_house')->where('GreenHouseId')->first();

                        $Name=$value['Name'];
                        $sheet->cell('A'.$i, $Name);

                        $IName=$value['InitiativeName'];
                        $sheet->cell('B'.$i, $IName); 

                        $EmailId=$value['EmailId'];
                        $sheet->cell('C'.$i, $EmailId);

                        $Telephone=$value['Telephone'];
                        $sheet->cell('D'.$i, $Telephone);                       

                        $CountryId  =$value['CountryId'] ;
                        $sheet->cell('E'.$i, $CountryId );

                        $OtherReason  =$value['OtherReason'] ;
                        $sheet->cell('F'.$i, $OtherReason );
                    }
                }
            });
        })->download($type);

    }

    public function greenhouse_pdf_export()
    {       
          $data = DB::table('green_house')->select('Name', 'InitiativeName', 'EmailId','Telephone','CountryId','OtherReason')->orderBy('GreenHouseId', 'desc')->get()->toArray(); 

          $title_caption = "Greenhouse List";    
            $curr_date = date('d-m-Y');
            $curr_date = str_replace('-', '', $curr_date);
            
              $filename = 'greenhouse_list'.$curr_date.".pdf";
            

            $pdf = PDF::loadview('admin/greenhouse_export_pdf',[
                            "data"=>$data,
                             ])->setPaper('a4', 'portrait');
            return $pdf->download($filename);  
                        /*End PDF download code*/

    }
    public function usermanagement()
    {
          if(!empty($_SESSION['email']))
          {
            $user_id = $_SESSION['id'];
            //$users_approved = DB::table('users')->orderBy('id', 'desc')->get();
            $users_approved = DB::table('users')->where([['is_approved','=', '1'],['isadmin','!=', '1']])->orderBy('id', 'desc')->get();
            $users_unapproved = DB::table('users')->where([['is_approved','=', '0'],['isadmin','!=', '1']])->orderBy('id', 'desc')->get();
            
            return view('admin/usermanagement',['users_approved' => $users_approved,'users_unapproved'=>$users_unapproved]);  
          }
          else
          {
            return view('auth/adminLogin');
          }
    }
    public function adduser()
    {
        
        return view('admin/adduser');
    }
    public function edituser(Request $request)
    {
        $user_id=$request['user_id'];
        $user_detail = DB::table('users')->where([['id',$user_id]])->first();
        $initiativedetail = DB::table('initiativedetail')->where('user_id', $user_id)->first();
        $initiative_activity_source = DB::table('initiative_activity_source')->where('user_id', $user_id)->first();
        $sharing_methods = DB::table('sharing_methods')->where('user_id', $user_id)->first();
        
        $initiative_sharing_source = DB::table('initiative_sharing_source')->where('user_id', $user_id)->first();
        
        $food_spaces_type = DB::table('food_spaces_type')->where('user_id', $user_id)->first();

        $food_skills = DB::table('food_skills')->where('user_id', $user_id)->first();
        $food_stuff_type = DB::table('food_stuff_type')->where('user_id', $user_id)->first();
        $users_activity = DB::table('users_activity')->where('user_id', $user_id)->first();
        $talent_garden_story = DB::table('talent_garden_story')->where('user_id', $user_id)->first();

        $initiative_logs = DB::table('initiative_logs')->where('user_id', $user_id)->orderBy('id', 'desc')->get();

        $impact_report= DB::table('impact_report')->where([['is_finished','=',1],['user_id','=',$user_id],['is_shared','=',1]])->orderBy('date_completed', 'DESC')->get();
        $talentGarden = DB::table('talent_garden_story')->where('user_id',$user_id)->get();


        return view('admin/edituser',['user_detail'=>$user_detail,'initiativedetail'=>$initiativedetail,'initiative_activity_source'=>$initiative_activity_source,'sharing_methods'=>$sharing_methods,'initiative_sharing_source'=>$initiative_sharing_source,'food_spaces_type'=>$food_spaces_type,'food_skills'=>$food_skills,'food_stuff_type'=>$food_stuff_type,'users_activity'=>$users_activity,'talent_garden_story'=>$talent_garden_story,'initiative_logs'=>$initiative_logs,'impact_report'=>$impact_report,'talentGarden'=>$talentGarden]);
    }
    public function adminupdateuser(Request $request)
    {
        $country = $request['country'];
              $country_array = $request['country_bind'];  
              $state = $request['state']; 
              $state_array = $request['state_bind'];

              $city = $request['city']; 
              $city_array = $request['city_bind'];
              
              if(!empty($country_array))
              {
                $extra_country=implode(',', $country_array);
              }
              else
              {
               $extra_country='';
              }


              if(!empty($state_array))
              {
                $extra_state=implode(',', $state_array);
              }
              else
              {
               $extra_state='';
              }

              if(!empty($city_array))
              {
                $extra_city=implode(',', $city_array);
              }
              else
              {
               $extra_city='';
              }

        /* if multiple country not selected */
      if($extra_country != ''){
        $country = $country.",".$extra_country;
        $state = $state.",".$extra_state;
        $city = $city.",".$extra_city;
      }else{
        $country = $country;
        $state = $state;
        $city = $city;
      }

        $telephone = $request['coutrycode'].$request['telephone']; 

        $user_id=$request['user_id'];
        $user = User::findOrFail($user_id);
        $user->first_name = request()->input('first_name');
        $user->email = request()->input('email');
        $user->last_name = request()->input('last_name');
        $user->name = request()->input('int_name');
        $user->telephone = $telephone;
        $user->country=$country;
        $user->state=$state;
        $user->city=$city;
        $user->save();

        $initiativedetail=DB::table('initiativedetail')->where('user_id', $user_id)->update([
        'key_goals' => request()->input('key_goals'),
        'activity_description' => request()->input('activity_description')
        ]);
        
        //users_activity
        $activity_id="";
       
        foreach($request->activity_id as $activity_id_temp){
            $activity_id.= $activity_id_temp.",";
        }
        $activity_id=rtrim($activity_id,',');
        $users_activity=DB::table('users_activity')->where('user_id', $user_id)->first();
         if($users_activity===null)
         {
            //echo "not found";
            DB::table('users_activity')->insert([
            'user_id'=>$user_id,
            'activity_id'=>$activity_id,
          ]);
         }
         else
         {
            //echo "fonud";
            $users_activity=DB::table('users_activity')->where('user_id', $user_id)->update([
            'activity_id' => $activity_id
            ]);
         }


        //pass values for toster
        $notification = array(
                    'message' => 'Record saved successfully',
                    'alert-type' => 'success'
                );
        return redirect()->route('edituser', ['user_id'=>$user_id])->with($notification);
    }
    public function adminsaveuser(Request $request)
    {
            // dd($request);
            ///start
                $request->validate([
                /*'name' => 'required|string|max:255',*/
                'email' => 'required|string|email|max:255|unique:users'
                // 'password' => 'required|string|min:6|confirmed|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[~!@#$%^&*()_+])[A-Za-z\d~!@#$%^&*()_+]{6,}$/',
                ]);      
              $fullname=explode(' ',$request['int_name']);
              $first_name=$request['first_name'];
              $last_name=$request['last_name'];
              $name = strtolower($request['int_name']); 
              $name = str_replace(' ','',$name);
              $checkUser = User::where('username','like',"%{$name}%")->max('uid');
              
              if($checkUser != 0){
               $userName = $name.'_'.$checkUser;
               $checkUser++;
              }else{      
                $userName = $name;
                $checkUser = 1;
              }
              
              $country = $request['country'];
              $country_array = $request['country_bind'];
              
              
              $state = $request['state']; 
              $state_array = $request['state_bind'];

              $city = $request['city']; 
              $city_array = $request['city_bind'];
              
              if(!empty($country_array))
              {
                $extra_country=implode(',', $country_array);
              }
              else
              {
               $extra_country='';
              }


              if(!empty($state_array))
              {
                $extra_state=implode(',', $state_array);
              }
              else
              {
               $extra_state='';
              }

              if(!empty($city_array))
              {
                $extra_city=implode(',', $city_array);
              }
              else
              {
               $extra_city='';
              }
              /* if multiple country not selected */
              if($extra_country != ''){
                $country = $country.",".$extra_country;
                $state = $state.",".$extra_state;
                $city = $city.",".$extra_city;
              }else{
                $country = $country;
                $state = $state;
                $city = $city;
              }

              $telephone = $request['coutrycode'].$request['telephone'];
              $admin_approve_date=date('Y-m-d H:m:s');

        

              $data=User::create([
                    'name' => $request['int_name'],
                    'email' => $request['email'],
                    'password' => Hash::make('User@#123'),
                    'isadmin'=>'0',
                    'username'=>$userName,
                    'first_name'=>$first_name,
                    'last_name'=>$last_name,
                    'telephone'=>$telephone,
                    'is_admin_created'=>'1',
                    'is_approved'=>'1',
                    'approve_date' => $admin_approve_date,
                    'status'=>'1',
                    'wizard_completed'=>'0',
                    'uId' => $checkUser,
                    'country' => $country,
                    'state' => $state,
                    'city' => $city,

                ]);
              
              DB::table('initiativedetail')->insert([
                'user_id'=>$data->id,
                'key_goals'=>$request['key_goals'],
                'activity_description'=>$request['activity_description']
              ]);
              //users_activity
                $activity_id="";
               
                foreach($request->activity_id as $activity_id_temp){
                    $activity_id.= $activity_id_temp.",";
                }
                $activity_id=rtrim($activity_id,',');
                $users_activity=DB::table('users_activity')->where('user_id',$data->id)->first();
                 if($users_activity===null)
                 {
                    //echo "not found";
                    DB::table('users_activity')->insert([
                    'user_id'=>$data->id,
                    'activity_id'=>$activity_id,
                  ]);
                 }
                 else
                 {
                    //echo "fonud";
                    $users_activity=DB::table('users_activity')->where('user_id', auth()->user()->id)->update([
                    'activity_id' => $activity_id
                    ]);
                 }

                 DB::table('initiative_logs')->insert([
                'user_id'=>$data->id,
                'log_time'=>Carbon::now(),
                'action_type'=>'User Registers',
                'detail'=>'User Registers']);
            ///end
          //pass values for toster
          $notification = array(
                    'message' => 'Record Inserted Successfully.',
                    'alert-type' => 'success'
                );
        if(!empty($request['is_send_email']))
        {
            $result = User::where('email','=',$request['email'])->first();
            $id = encrypted($result->id);
            $c_date = encrypted(date('Y-m-d H:i:s'));
            $date = str_replace('/','-', $c_date);
            $id = str_replace('/','-', $id);
            $subject = 'Your Account is Ready.';
            $admin_html = '<table width="650" align="center" cellspacing="0" cellpadding="0" border="0" bgcolor="#ffffff">
            <tr>
                <td style="padding:20px;">
                    <img src="logo.png" alt="">
                </td>
            </tr>
            <tr>
                <td bgcolor="#00c1d4" style="font-family: Verdana, Geneva, Tahoma, sans-serif; font-size: 17px; color:#ffffff; padding: 12px 20px;">Your registration has been approved</td>
            </tr>
            <tr>
                <td style="padding: 20px;">
                    <table width="100%" cellspacing="0" cellpadding="0" border="0" bgcolor="#ffffff">
                        <tr>
                            <td style="font-family: Verdana, Geneva, Tahoma, sans-serif; font-size: 15px; color:#3a3a3a; line-height: 22px;">
                                <span>Hello '.$userName.',</span><br /><br />Your account for Sharecity Toolkit has been created by admin. Your username is ‘'.$userName.'’.
                                <br>Please click on below link to reset the password <br />
                                 <a href="'.config('constants.INSTANCESURL').config('constants.laravel_folder').'resetpass/'.$id.'/'.$date.'" style="font-family: Verdana, Geneva, Tahoma, sans-serif; font-size: 14px; color:#ffffff; display:inline-block; padding:12px 20px; background-color:#00c1d4; border-radius: 3px; text-decoration: none;">Reset Password</a>
                            </td>
                        </tr>
                        <tr>
                            <td height="70"></td>
                        </tr>
                        <tr>
                            <td>
                                <span style="font-family: Verdana, Geneva, Tahoma, sans-serif; font-size: 15px; color:#3a3a3a;">Thanks,</span><br /><br />
                                <span style="font-family: Verdana, Geneva, Tahoma, sans-serif; font-size: 15px; font-weight: 700; color:#00c1d4;">ShareCity Team</span>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            </table>';
            SendEmail($subject,$admin_html,$request['email']);

        }
        return redirect()->route('usermanagement')->with($notification);
    }
    public function userapproved(Request $request)
    {
        $approve_date=date('Y-m-d H:m:s');
        $user_id=$request['user_id'];
        $user_detail = DB::table('users')->where([['id','=',$user_id]])->first();
        
        
        $user = User::findOrFail($user_id);
        $user->status = request()->input('status');
        $user->is_approved = request()->input('is_approved');
        $user->approve_date = $approve_date;
        $user->save();
        


        $approved_status="";
        if($request['is_approved']==1)
        {
            $approved_status="approved";
        }
        else
        {
            $approved_status="unapproved";

        }

        if($request['is_approved']==1 && $user_detail->is_approved==0)
        {
          $subject = 'Your registration has been '.$approved_status;
            $admin_html = '<table width="650" align="center" cellspacing="0" cellpadding="0" border="0" bgcolor="#ffffff">
            <tr>
                <td style="padding:20px;">
                    <img src="logo.png" alt="">
                </td>
            </tr>
            <tr>
                <td bgcolor="#00c1d4" style="font-family: Verdana, Geneva, Tahoma, sans-serif; font-size: 17px; color:#ffffff; padding: 12px 20px;">Your registration has been '.$approved_status.'</td>
            </tr>
            <tr>
                <td style="padding: 20px;">
                    <table width="100%" cellspacing="0" cellpadding="0" border="0" bgcolor="#ffffff">
                        <tr>
                            <td style="font-family: Verdana, Geneva, Tahoma, sans-serif; font-size: 15px; color:#3a3a3a; line-height: 22px;">
                                <span>Hello '.$user_detail->username.',</span><br /><br />Thank you for registering to the ShareCity Toolkit. The administrator has '.$approved_status.' your account and you can now use the <a href="'.config('constants.INSTANCESURL').config('constants.laravel_folder').'user/login/'.'" style="white-space: nowrap; display: inline-block; color: #00c1d4;">login page</a> to access the system.Your Username is :'.$user_detail->username.'
                                
                                
                            </td>
                        </tr>
                        <tr>
                            <td height="70"></td>
                        </tr>
                        <tr>
                            <td>
                                <span style="font-family: Verdana, Geneva, Tahoma, sans-serif; font-size: 15px; color:#3a3a3a;">Thanks,</span><br /><br />
                                <span style="font-family: Verdana, Geneva, Tahoma, sans-serif; font-size: 15px; font-weight: 700; color:#00c1d4;">ShareCity Team</span>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            </table>';
            SendEmail($subject,$admin_html,$request['email']);
          }

        //pass values for toster
        $notification = array(
                    'message' => 'User '.$approved_status.' successfully',
                    'alert-type' => 'success'
                );
        return redirect()->route('edituser', ['user_id'=>$user_id])->with($notification);
    }
    public function adminProfile()
    {

        
        if(!empty($_SESSION['email']))
          {
            $email =  $_SESSION['email'];
            $result = User::where('email','=',$email)->where('isadmin',1)->first();
            return view('admin/profile',['result' => $result]);
          }
          else
          {
            return view('auth/adminLogin');
          }
         
        
    }
    public function updateDetail(Request $request)
    {
        $email =  $_SESSION['email'];
        $telephone = $request['coutrycode'].$request['telephone'];  
        $result = User::where('email','=',$email)->where('isadmin',1)->first();

        $result->first_name = $request->fname;
        $result->last_name = $request->lname;
        //$result->email = $request->email;
        $result->telephone = $telephone;
        $result->update();
        return redirect()->route('adminprofile')->with('success', 'Your profile has been updated successfully.');
    }
    public function adminChangePass(Request $request)
    {
        $resetEmail = $request->ResetPasswordEmail;
        $password = $request->Password;
        $ConfirmPassword = $request->ConfirmPassword;
        if($password == $ConfirmPassword){
        $email =  $_SESSION['email'];
        $id =  $_SESSION['id'];
        $result = User::where('id', $id)->where('email',$email)->first();
        $result->password = Hash::make($ConfirmPassword);
        $result->update();
        }else{
        return Redirect::back()->with('errors','The password and Confirm Password do not match.');
      } 
    return redirect()->route('adminprofile')->with('success', 'Your password has been changed successfully.');
    }
    public function passChange_admin(Request $request)
    {
        $email = $request->email; 
        $result = User::where('email','=',$email)->where('isadmin','1')->first();
        if(!empty($result)){
         $id = encrypted($result->id);
         $c_date = encrypted(date('Y-m-d H:i:s'));
         $date = str_replace('/','-', $c_date);
         $id = str_replace('/','-', $id);
         $subject = 'Reset Password';
         $html = ' <table width="650" align="center" cellspacing="0" cellpadding="0" border="0" bgcolor="#ffffff">
        <tr>
            <td style="padding:20px;" align="center">
                <img src="'.config('constants.INSTANCESURL').config('constants.laravel_folder').'public/images/login-logo.png" alt="logo" >
            </td>
        </tr>
        <tr>
            <td bgcolor="#00c1d4" style="font-family: Verdana, Geneva, Tahoma, sans-serif; font-size: 17px; color:#ffffff; padding: 12px 20px;">Password Reset</td>
        </tr>
        <tr>
            <td style="padding: 20px;">
                <table width="100%" cellspacing="0" cellpadding="0" border="0" bgcolor="#ffffff">
                    <tr>
                        <td style="font-family: Verdana, Geneva, Tahoma, sans-serif; font-size: 15px; color:#3a3a3a; line-height: 22px;">
                            <span>Hello '.$result->username.',</span><br /><br />
                            You are receiving this email because a request was made to reset your password. If this was not you, you may discard this email. If this was you, click the link below to continue with the password reset process.<br /><br />
                        </td>
                    </tr>
                    <tr>
                        <td height="20"></td>
                    </tr>
                    <tr>
                        <td align="center">
                            <a href="'.config('constants.INSTANCESURL').config('constants.laravel_folder').'resetpass/'.$id.'/'.$date.'" style="font-family: Verdana, Geneva, Tahoma, sans-serif; font-size: 14px; color:#ffffff; display:inline-block; padding:12px 20px; background-color:#00c1d4; border-radius: 3px; text-decoration: none;">Reset Password</a>
                        </td>
                    </tr>
                    <tr>
                        <td height="70"></td>
                    </tr>
                    <tr>
                        <td>
                            <span style="font-family: Verdana, Geneva, Tahoma, sans-serif; font-size: 15px; color:#3a3a3a;">Thanks,</span><br /><br />
                            <span style="font-family: Verdana, Geneva, Tahoma, sans-serif; font-size: 15px; font-weight: 700; color:#00c1d4;">ShareCity Team</span>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>';
         SendEmail($subject,$html,$email);
         return redirect()->route('adminprofile')->with('success', 'Your reset password link has been send successfully.');
        }else{
        return Redirect::back()->with('errors','Email must be a valid email address OR That email does not exist in our database.');
         }
    }
    public function forget_Mailsend_admin(Request $request)
    {

        $email = $request->email;
      $result = User::where('email','=',$email)->where('id',$request->user_id)->first();
      if(!empty($result))
      {
        DB::table('initiative_logs')->insert([
                'user_id'=>$request->user_id,
                'log_time'=>Carbon::now(),
                'action_type'=>'User Request Reset Password',
                'detail'=>'User Request Reset Password']);

         $id = encrypted($result->id);
         $c_date = encrypted(date('Y-m-d H:i:s'));
         $date = str_replace('/','-', $c_date);
         $id = str_replace('/','-', $id);
         $subject = 'Reset Password';
         $html = ' <table width="650" align="center" cellspacing="0" cellpadding="0" border="0" bgcolor="#ffffff">
                <tr>
                    <td style="padding:20px;" align="center">
                        <img src="'.config('constants.INSTANCESURL').config('constants.laravel_folder').'public/images/login-logo.png" alt="logo" >
                    </td>
                </tr>
                <tr>
                    <td bgcolor="#00c1d4" style="font-family: Verdana, Geneva, Tahoma, sans-serif; font-size: 17px; color:#ffffff; padding: 12px 20px;">Password Reset</td>
                </tr>
                <tr>
                    <td style="padding: 20px;">
                        <table width="100%" cellspacing="0" cellpadding="0" border="0" bgcolor="#ffffff">
                            <tr>
                                <td style="font-family: Verdana, Geneva, Tahoma, sans-serif; font-size: 15px; color:#3a3a3a; line-height: 22px;">
                                    <span>Hello '.$result->username.',</span><br /><br />
                                    You are receiving this email because a request was made to reset your password. If this was not you, you may discard this email. If this was you, click the link below to continue with the password reset process.<br /><br />
                                </td>
                            </tr>
                            <tr>
                                <td height="20"></td>
                            </tr>
                            <tr>
                                <td align="center">
                                    <a href="'.config('constants.INSTANCESURL').config('constants.laravel_folder').'resetpass/'.$id.'/'.$date.'" style="font-family: Verdana, Geneva, Tahoma, sans-serif; font-size: 14px; color:#ffffff; display:inline-block; padding:12px 20px; background-color:#00c1d4; border-radius: 3px; text-decoration: none;">Reset Password</a>
                                </td>
                            </tr>
                            <tr>
                                <td height="70"></td>
                            </tr>
                            <tr>
                                <td>
                                    <span style="font-family: Verdana, Geneva, Tahoma, sans-serif; font-size: 15px; color:#3a3a3a;">Thanks,</span><br /><br />
                                    <span style="font-family: Verdana, Geneva, Tahoma, sans-serif; font-size: 15px; font-weight: 700; color:#00c1d4;">ShareCity Team</span>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>';
         SendEmail($subject,$html,$email);
      }
      else
      {
        return Redirect::back()->with('errors','Email must be a valid email address OR That email does not exist in our database.');
      }
      $notification = array(
                    'message' => 'Reset password link has been sent',
                    'alert-type' => 'success'
                );
        return redirect()->route('usermanagement')->with($notification);
      //return view('admin/usermanagement');
    }
    public function deleteUser(Request $request)
    {
        $user_id=$request['id'];
        //echo $user_id;die;
        if(!empty($user_id))
        { 
            DB::table('users')->where('id', '=', $user_id)->delete();
            DB::table('initiativedetail')->where('user_id', '=', $user_id)->delete();
            DB::table('initiative_sharing_source')->where('user_id', '=', $user_id)->delete();
            DB::table('initiative_logs')->where('user_id', '=', $user_id)->delete();
            DB::table('initiative_location')->where('user_id', '=', $user_id)->delete();
            DB::table('initiative_activity_source')->where('user_id', '=', $user_id)->delete();
            DB::table('food_stuff_type')->where('user_id', '=', $user_id)->delete();
            DB::table('food_spaces_type')->where('user_id', '=', $user_id)->delete();
            DB::table('food_skills')->where('user_id', '=', $user_id)->delete();

            $notification = array(
                    'message' => 'User has been deleted successfully',
                    'alert-type' => 'success'
                );
        return redirect()->route('usermanagement')->with($notification);
            //DB::table('users')->where('id', '=', $user_id)->delete();
        }
    }
    public function get_log_action(Request $request)
    {
        $user_id=$request['user_id'];
        $log_action=$request['log_action'];
        $log_time=$request['log_time'];
        $date="";
        if($log_time=="w")
        {
            $date = Carbon::today()->subDays(7);
        }
        if($log_time=="m")
        {
            $date = Carbon::today()->subDays(30);
        }
        if($log_time=="y")
        {
            $date = Carbon::today()->subDays(365);
        }

        //echo $date;

        
        if(!empty($log_action) && !empty($log_time))
        {

            $initiative_logs = DB::table('initiative_logs')->where([['log_time','>=',$date],['action_type','=',$log_action],['user_id','=',$user_id]])->orderBy('id', 'desc')->get();
        }
        else if(!empty($log_action) && empty($log_time))
        {
            $initiative_logs = DB::table('initiative_logs')->where([['action_type','=',$log_action],['user_id','=',$user_id]])->orderBy('id', 'desc')->get();
        }
        else if(!empty($log_time) && empty($log_action))
        {
            $initiative_logs = DB::table('initiative_logs')->where([['log_time','>=',$date],['user_id','=',$user_id]])->orderBy('id', 'desc')->get();
        }
        else
        {
            $initiative_logs = DB::table('initiative_logs')->where([['user_id','=',$user_id]])->orderBy('id', 'desc')->get();
        }

        //return true; 
        return response()->json(array('initiative_logs'=> $initiative_logs));
    }

    public function UsersExport($type, $is_approved) {
        $csv_array = array();
        if($is_approved == 1) {
          $data = DB::table('users')->select('username', 'name', 'email', 'user_last_login', 'status')->where([['is_approved','=', '1']])->orderBy('id', 'desc')->get()->toArray();
        } else {
          $data = DB::table('users')->select('username', 'name', 'email', 'user_last_login', 'status')->where([['is_approved','=', '0']])->orderBy('id', 'desc')->get()->toArray();
        }
        foreach ($data as $key => $value) {
           $csv_array[] = (array) $value;
        }   
        $curr_date = date('d-m-Y');
        $curr_date = str_replace('-', '', $curr_date);
        if($is_approved == 1) {
          $filename = 'approved_userlist'.$curr_date;
        } else {
          $filename = 'unapproved_userlist'.$curr_date;
        }

        return Excel::create($filename, function($excel) use ($csv_array) {
            $excel->sheet('User List', function($sheet) use ($csv_array)
            {
                $sheet->cell('A1', function($cell) {$cell->setValue('User Name'); });
                $sheet->cell('B1', function($cell) {$cell->setValue('Initiative Name'); });
                $sheet->cell('C1', function($cell) {$cell->setValue('Email'); });
                $sheet->cell('D1', function($cell) {$cell->setValue('Last Sign in'); });
                $sheet->cell('E1', function($cell) {$cell->setValue('Status'); });
                if (!empty($csv_array)) {
                    foreach ($csv_array as $key => $value) {
                        $i= $key+2;
                        $sheet->cell('A'.$i, $value['username']); 
                        $sheet->cell('B'.$i, $value['name']); 
                        $sheet->cell('C'.$i, $value['email']);
                        if(!empty($value['user_last_login'])) {
                          $user_last_login =  date('d-m-Y H:m:s',strtotime($value['user_last_login'])); 
                        } else {
                         $user_last_login = "";
                       }
                        $sheet->cell('D'.$i, $user_last_login);
                        if($value['status'] == 1) {
                          $status = "Active";
                        } else {
                          $status = "In Active";
                        }
                        $sheet->cell('E'.$i, $status); 
                    }
                }
            });
        })->download($type);
    }

    public function UsersPDFExport($is_approved) {
      /*if($is_approved == 1) {
          $data = DB::table('users')->select('username', 'name', 'email', 'user_last_login', 'status')->where([['is_approved','=', '1']])->orderBy('id', 'desc')->get()->toArray();
          $is_approved = 1;
          $title_caption = "Approved Users List";
        } else {
          $data = DB::table('users')->select('username', 'name', 'email', 'user_last_login', 'status')->where([['is_approved','=', '0']])->orderBy('id', 'desc')->get()->toArray();
          $is_approved = 0;
          $title_caption = "Unapproved Users List";
        }
          $view = view('admin/users_export_pdf')
                        ->with(
                            array(
                                  'data' => $data,
                                  'is_approved' => $is_approved,               
                            )
                        );
           $curr_date = date('d-m-Y');
            $curr_date = str_replace('-', '', $curr_date);
            if($is_approved == 1) {
              $filename = 'approved_userlist'.$curr_date;
            } else {
              $filename = 'unapproved_userlist'.$curr_date;
            }

           $html_content = $view->render();
            PDF::SetTitle($title_caption);
            PDF::AddPage();
            PDF::writeHTML($html_content, true, false, true, false, '');
            // D is the change of these two functions. Including D parameter will avoid 
            // loading PDF in browser and allows downloading directly
            // Clean any content of the output buffer
            ob_end_clean();
            PDF::Output($filename.'.pdf', 'D');*/   
            /*End PDF download code*/
    }
    public static function getUserCounter()
    {
      $users_approved = DB::table('users')->where([['is_approved','=', '1'],['isadmin','!=', '1']])->count();
      $users_unapproved = DB::table('users')->where([['is_approved','=', '0'],['isadmin','!=', '1']])->count();
      $total_user=$users_approved+$users_unapproved;
       $data=array('total_user'=>$total_user,"users_unapproved"=>$users_unapproved);

      return $data;     
    }
    public static function getSharedCounter()
    {
      $report_shared = DB::table('impact_report')->where([['is_shared','=', '1'],['is_finished','=', '1']])->count();
      $report_unapproved = DB::table('impact_report')->where([['is_shared','=', '1'],['is_finished','=', '1'],['is_approved','=', '0']])->count();
       
      $data=array('report_shared'=>$report_shared,"report_unapproved"=>$report_unapproved);

      return $data;     
    }
    public static function getSharedStoryCounter()
    {
      $story_shared = DB::table('talent_garden_story')->count();
      $story_unapproved = DB::table('talent_garden_story')->where([['IsApproved','=', '0']])->count();
       
      $data=array('story_shared'=>$story_shared,"story_unapproved"=>$story_unapproved);

      return $data;   
    }

}
