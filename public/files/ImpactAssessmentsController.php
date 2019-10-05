<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use App\User;
use App\Impact_Assessment;
use App\Assessment_Pillar;
use Session;
use DB;
use Auth;
use Carbon\Carbon;
use Excel;
use PDF;

session_start();
class ImpactAssessmentsController extends Controller
{
    // public function __construct()
    // {
    //     if(empty($_SESSION['email']))
    //     {
    //        Redirect::to('admin/login')->send();
    //       //return redirect('auth/adminLogin');
    //     }
    // }
    public function index()
    {
        checkLogin(isset($_SESSION['email']));
    }
    public function impact_assessments_list()
    {
       $impact_report= DB::table('impact_report')->where([['is_finished','=',1]])->orderBy('date_completed', 'DESC')->get();

        return view('admin/impact_assessments_list',['impact_report'=>$impact_report]);
    }
    public function impact_assessments_list_search(Request $request)
    {
        $is_approved=$request->is_approved;
       $impact_report= DB::table('impact_report')->where([['is_finished','=',1],['is_approved','=',$is_approved]])->orderBy('date_completed', 'DESC')->get();

        //return view('admin/impact_assessments_list',['impact_report'=>$impact_report,'is_approved'=>$is_approved]);
       $data="";
       foreach ($impact_report as $value_impact_report)
        {
            
            $name=ImpactAssessmentsController::impact_assesment_name($value_impact_report->impact_assessment_id);

            if($value_impact_report->is_shared==1){ $is_shared="Yes";}else{$is_shared="No";}
            if($value_impact_report->is_approved==1){ $is_approved="Yes";}else{$is_approved="No";}
            $date_completed=date("d/m/Y", strtotime($value_impact_report->date_completed));
            if(!empty($value_impact_report->is_approved)){ $is_approved_date= date("d/m/Y", strtotime($value_impact_report->date_approved));} else { $is_approved_date= "n/a";}
            $url="edit_approved_impact_assessment_report?impact_report_id=".$value_impact_report->impact_report_id;
                $data.='<tr>
                    <td>'.$name.'</td>
                    <td>'.$is_shared.'</td>
                    <td>'.$is_approved.'</td>
                    <td>'.$date_completed.'</td>
                    <td>'.$is_approved_date.'</td>
                    <td><a href="genrate_summary_pdf?id='.$value_impact_report->impact_report_id.'">Summary</a></td>
                    <td><a href="genrate_summary_view_pdf/'.$value_impact_report->impact_report_id.'" target="_blank">View PDF</a></td>
                    <td><a href="full_pdf_export?impact_report_id='.$value_impact_report->impact_report_id.'">Full Report</a></td>
                    <td><a href="summary_xls_export/xls/'.$value_impact_report->impact_report_id.'"><img src="'.config('constants.INSTANCESURL').config('constants.laravel_folder').'public/images/user/xls-ic.png" alt=""></a></td>
                    <td>
                        <a href="'.$url.'">
                            <svg x="0" y="0" viewBox="0 0 18 19" class="svg-ic gray-ic">
                                <path
                                    d="M11.193,3.972 L14.854,7.659 L5.586,16.993 L1.926,13.306 L11.193,3.972 ZM17.633,3.083 L16.000,1.438 C15.369,0.803 14.344,0.803 13.711,1.438 L12.147,3.014 L15.808,6.701 L17.633,4.863 C18.122,4.371 18.122,3.576 17.633,3.083 ZM0.010,18.488 C-0.056,18.790 0.214,19.061 0.514,18.987 L4.594,17.991 L0.935,14.304 L0.010,18.488 Z" />
                            </svg>
                        </a>
                    </td>
                </tr>';
            
        }
        //echo $data;die;
        return response()->json(array('data'=> $data,'is_approved'=>$is_approved)); 
    }
    public static function impact_assesment_name($id)
    {
        $impact_assessment= DB::table('impact_assessment')->where([['impact_assessment_id','=',$id]])->first();
        return $impact_assessment->title;
        
    }
    public function edit_approved_impact_assessment_report(Request $request)
    {
        
        $impact_report= DB::table('impact_report')->where([['impact_report_id','=',$request->impact_report_id]])->first();
        



        return view('admin/edit_approved_impact_assessment_report',['impact_report'=>$impact_report]);
    }
    public function approve_report(Request $request)
    {
        
        $impact_report_id=$request->impact_report_id;
        $fb_handle=$request->fb_handle;
        $twitter_handle=$request->twitter_handle;
        $is_visible=(int)$request->is_visible;
        $is_approved=(int)$request->customRadio;
        $date=null;
        if($is_approved==1)
        {
            $date=Carbon::now();
        }
        $is_shared=0;
        if($twitter_handle!="" || $fb_handle!="" )
        {
            $is_shared=1;
        }

        
        DB::table('impact_report')->where('impact_report_id', $impact_report_id)->update([
                'fb_handle'=>$fb_handle,
                'twitter_handle'=>$twitter_handle,
                'is_approved'=>$is_approved,
                'status'=>$is_visible,
                'is_shared'=>$is_shared,
                'date_approved'=>$date,
              ]);
        $impact_report= DB::table('impact_report')->where([['impact_report_id','=',$impact_report_id]])->first();

        $user_id =$impact_report->user_id;
        $user_detail= DB::table('users')->where([['id','=',$user_id]])->first();
        $user_email=$user_detail->email;
        $impact_assessment= DB::table('impact_assessment')->where([['impact_assessment_id','=',$impact_report->impact_assessment_id]])->first();
        $impact_assesment_name=$impact_assessment->title;
        /*start email*/
        $subject = 'Report Approved';
       $user_html = '<table width="650" align="center" cellspacing="0" cellpadding="0" border="0" bgcolor="#ffffff">
       <tr>
            <td style="padding:20px;" align="center">
                <img src="'.config('constants.INSTANCESURL').config('constants.laravel_folder').'public/images/login-logo.png" alt="logo" >
            </td>
        </tr>
        <tr>
            <td bgcolor="#00c1d4" style="font-family: Verdana, Geneva, Tahoma, sans-serif; font-size: 17px; color:#ffffff; padding: 12px 20px;">Report Approved</td>
        </tr>
        <tr>
            <td style="padding: 20px;">
                <table width="100%" cellspacing="0" cellpadding="0" border="0" bgcolor="#ffffff">
                    <tr>
                        <td style="font-family: Verdana, Geneva, Tahoma, sans-serif; font-size: 15px; color:#3a3a3a; line-height: 22px;">
                            <span>Hello '.$user_detail->username.',</span><br /><br />
                            Your impact assessment report "'.$impact_assesment_name.'"has been approved by admin.<br /><br />
                        </td>
                    </tr>
                    <tr>
                        <td height="50"></td>
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
    if($is_approved==1)
    {
        SendEmail($subject,$user_html,$user_email); 
    }
    if(isset($_REQUEST['mode']) && $_REQUEST['mode']=='Shared')
    {
        return redirect('admin/talent_garden');
    }
    else
    {
        return redirect('admin/impact_assessments_list');
    }
        /*Stop Email*/
        
    }
    public function genrateSummaryPDF($impact_report_id) {
        // $impact_report_id       =   $request->id;

        $impact_report          =   DB::table("impact_report")->select("impact_report_id", "user_id","summary_img_1")->where("impact_report_id",$impact_report_id)->first();

        if($impact_report){

            /* Fetche login user details (start) */
             $user_id          =   $impact_report->user_id;
             $user          =   DB::table("users")->select("*")->where("id",$user_id)->first();
             
            // $user                   =   auth()->user();

            $userDetails            =   array();
            $userDetails['name']    =   $user->name;
            $userDetails['city']    =   $user->city;

            $userInitDetails        =   $this->getInitUserData($user->id);

            foreach ($userInitDetails as $key => $value) {
                $userDetails[$key] = $value;
            }

            /* Fetche login user details (End) */

            // Fetched Core Indicators Objectives
            $coreIndicators         = $this->getCoreIndicators($impact_report_id);


            //Fetched Impact assessment description
            $impactAssessmentDes     = $this->getImpactAssessmentDescription($impact_report_id);


            //Fetch Answers of Quantitative questions selected by user.
            $quantitativeAnsDetails  = $this->getQuantitativeQuestionAnswers($impact_report_id);

            // Cause of share food
            $causeOfShareFood        = $this->getCauseOfShareFood($impact_report_id);

            //Fetched Impact assessment intro description
            $impactAssessmentDes     = $this->getImpactAssessmentIntroDescription($impact_report_id);

            //Fetch Answers of Quantitative questions selected by user.
            $qualitativeAnsDetails  = $this->getQualitativeQuestionAnswers($impact_report_id);

            //Fetch sdgs Indicators
            $sdgsData               = $this->getSDGs($impact_report_id);

            //Prepare Share Star Chat
            //$shareStarChatHtml      = $this->makeShareStarChart($impact_report_id);
          
            $sharechartimg    =   url('public/report_images/'.$impact_report->summary_img_1);
            //dd($sdgsData);
             
       
            $pdf      = PDF::loadview('admin/impact_assessments_pdf',[
                            "impact_report_id"=>$impact_report_id,
                            "user_details"=>$userDetails,
                            "core_indicators"=>$coreIndicators,
                            "impact_assessment_description" => $impactAssessmentDes,
                             "quantitative_ans_details" => $quantitativeAnsDetails,
                             "cause_of_share_food" => $causeOfShareFood,
                            "impact_assessment_desc" => $impactAssessmentDes,
                             "qualitative_ans_details" => $qualitativeAnsDetails,
                            "sdgs_data" => $sdgsData,
                            "sharechartimg" => $sharechartimg
                        ])->setPaper('a2', 'portrait');
                        
                        // $pdf      = PDF::loadview('admin/impact_assessments_pdf')->setPaper('a2', 'portrait');
            
            // return view('admin/impact_assessments_pdf',[
            //                 "impact_report_id"=>$impact_report_id,
            //                 "user_details"=>$userDetails,
            //                 "core_indicators"=>$coreIndicators,
            //                 "impact_assessment_description" => $impactAssessmentDes,
            //                 "quantitative_ans_details" => $quantitativeAnsDetails,
            //                 "cause_of_share_food" => $causeOfShareFood,
            //                 "impact_assessment_desc" => $impactAssessmentDes,
            //                 "qualitative_ans_details" => $qualitativeAnsDetails,
            //                 "sdgs_data" => $sdgsData
            //             ]);
            
            // $pdf      = PDF::loadview('admin/demo_pdf')->setPaper('a2', 'portrait');

             return $pdf->download('campaigns.pdf');
            

        } else {
            $notification = array(
                'message' => 'No such impact report found !',
                'alert-type' => 'error'
            );
            return redirect()->route('dashboard')->with($notification);
            //return view('user/sustainability_impact_summary')->with($notification);
        }
    }

    public function genrateSummaryViewPDF($impact_report_id) {
        // $impact_report_id       =   $request->id;

        $impact_report          =   DB::table("impact_report")->select("impact_report_id", "user_id","summary_img_1")->where("impact_report_id",$impact_report_id)->first();

        if($impact_report){

            /* Fetche login user details (start) */
             $user_id          =   $impact_report->user_id;
             $user          =   DB::table("users")->select("*")->where("id",$user_id)->first();
             
            // $user                   =   auth()->user();

            $userDetails            =   array();
            $userDetails['name']    =   $user->name;
            $userDetails['city']    =   $user->city;

            $userInitDetails        =   $this->getInitUserData($user->id);

            foreach ($userInitDetails as $key => $value) {
                $userDetails[$key] = $value;
            }

            /* Fetche login user details (End) */

            // Fetched Core Indicators Objectives
            $coreIndicators         = $this->getCoreIndicators($impact_report_id);


            //Fetched Impact assessment description
            $impactAssessmentDes     = $this->getImpactAssessmentDescription($impact_report_id);


            //Fetch Answers of Quantitative questions selected by user.
            $quantitativeAnsDetails  = $this->getQuantitativeQuestionAnswers($impact_report_id);

            // Cause of share food
            $causeOfShareFood        = $this->getCauseOfShareFood($impact_report_id);

            //Fetched Impact assessment intro description
            $impactAssessmentDes     = $this->getImpactAssessmentIntroDescription($impact_report_id);

            //Fetch Answers of Quantitative questions selected by user.
            $qualitativeAnsDetails  = $this->getQualitativeQuestionAnswers($impact_report_id);

            //Fetch sdgs Indicators
            $sdgsData               = $this->getSDGs($impact_report_id);

            //Prepare Share Star Chat
            //$shareStarChatHtml      = $this->makeShareStarChart($impact_report_id);
          
            $sharechartimg    =   url('public/report_images/'.$impact_report->summary_img_1);
            //dd($sdgsData);
             
       
            $pdf      = PDF::loadview('admin/impact_assessments_pdf',[
                            "impact_report_id"=>$impact_report_id,
                            "user_details"=>$userDetails,
                            "core_indicators"=>$coreIndicators,
                            "impact_assessment_description" => $impactAssessmentDes,
                             "quantitative_ans_details" => $quantitativeAnsDetails,
                             "cause_of_share_food" => $causeOfShareFood,
                            "impact_assessment_desc" => $impactAssessmentDes,
                             "qualitative_ans_details" => $qualitativeAnsDetails,
                            "sdgs_data" => $sdgsData,
                            "sharechartimg" => $sharechartimg
                        ])->setPaper('a2', 'portrait');
                        
                        // $pdf      = PDF::loadview('admin/impact_assessments_pdf')->setPaper('a2', 'portrait');
            
            return view('admin/impact_assessments_pdf',[
                            "impact_report_id"=>$impact_report_id,
                            "user_details"=>$userDetails,
                            "core_indicators"=>$coreIndicators,
                            "impact_assessment_description" => $impactAssessmentDes,
                            "quantitative_ans_details" => $quantitativeAnsDetails,
                            "cause_of_share_food" => $causeOfShareFood,
                            "impact_assessment_desc" => $impactAssessmentDes,
                            "qualitative_ans_details" => $qualitativeAnsDetails,
                            "sdgs_data" => $sdgsData
                        ]);
            
            $pdf      = PDF::loadview('admin/demo_pdf')->setPaper('a2', 'portrait');

             // return $pdf->download('campaigns.pdf');
            

        } else {
            $notification = array(
                'message' => 'No such impact report found !',
                'alert-type' => 'error'
            );
            return redirect()->route('dashboard')->with($notification);
            //return view('user/sustainability_impact_summary')->with($notification);
        }
    }
    
    
    /*
    *   Purpose     : Make xls for according to impact report.
    *   @params     : type as string and impact_report_id as int
    *   @returns    : download xls of impact report
    *   Date        : 24/06/2018
    *   Author      : Kuldeep Raval
    */
    public function summaryXLSExport($type, $impact_report_id)
    {
      $csv_array = array();
      $impact_report = DB::table('impact_report')->where('impact_report_id', $impact_report_id)->first();
      $impact_assessment_id = $impact_report->impact_assessment_id;

      $arr_pillars = DB::table('assessment_pillar')->where('impact_assessment_id', $impact_assessment_id)->get();

      $assessment_indicator = DB::table('assessment_indicator')->where('impact_assessment_id', $impact_assessment_id)->get();

      $finalArray = array();
      foreach ($arr_pillars as $key_pillar => $value_pillar) {
        $arr_impact_area = DB::table('assessment_Impact_area')->where('assessment_pillar_id', $value_pillar->assessment_pillar_id)->get();
        foreach ($arr_impact_area as $key_impact_area => $value_impact_area) {
            foreach ($assessment_indicator as $key_ind => $value_ind) {
                 $impact_report_ans = DB::table('impact_report_ans')->where([['assessment_indicator_id','=',$value_ind->assessment_indicator_id],['impact_report_id','=',$impact_report_id]])->get();
                if(!empty($impact_report_ans)){
                 foreach ($impact_report_ans as $key_report_ans => $value_report_ans) {
                      $impact_report_ans_choice = DB::table('impact_report_ans_choice')->where('impact_report_ans_id', $value_report_ans->impact_report_ans_id)->first();
                      if(!empty($impact_report_ans_choice))
                      {
                        $indicator_questions = DB::table('indicator_questions')->where('indicator_questions_id', $value_report_ans->indicator_questions_id)->first();
                        if(!empty($indicator_questions))
                        {
                            if($impact_report_ans_choice->ans!="")
                            {
                                $finalArray[$value_pillar->assessment_pillar_id][$value_impact_area->assessment_impact_area_id][$value_ind->assessment_indicator_id][] = array("que"=> $indicator_questions->question,"ans"=>$impact_report_ans_choice->ans);     
                            }
                            else
                            {
                                
                                $questions_choices_id=explode(',', $impact_report_ans_choice->questions_choices_id);
                                $c=0;
                                $questions_choices_data="";
                                foreach ($questions_choices_id as $key_que_cho => $value_que_cho) 
                                {
                                    $c++;
                                    $questions_choices=DB::table('questions_choices')->where([['questions_choices_id','=',$value_que_cho]])->first();
                                    $questions_choices_data.=$c.". ".$questions_choices->text_str.", ";
                                }
                                $finalArray[$value_pillar->assessment_pillar_id][$value_impact_area->assessment_impact_area_id][$value_ind->assessment_indicator_id][] = array("que"=> $indicator_questions->question,"ans"=>$questions_choices_data); 
                            }
                        }
                      }
                 }
               }
            }
         }
      }

      /*echo "<pre>";
      dd($finalArray);*/
        $curr_date = date('d-m-Y');
        $curr_date = str_replace('-', '', $curr_date);
        $filename = 'summary_report'.$curr_date;

        return Excel::create($filename, function($excel) use ($finalArray) {
            $excel->sheet('Summary Report', function($sheet) use ($finalArray)
            {
                $c = 1;
                foreach ($finalArray as $pillar_key => $in_pillar) {
                    $sheet->mergeCells('A'.$c.':B'.$c, function ($cells) {
                            $cells->setBackground('#ED7D31');
                            $cells->setAlignment('center');
                            $cells->setValignment('middle');
                    });
                    $c++;
                    foreach ($in_pillar as $impact_key => $in_impact) {
                       $sheet->mergeCells('A'.$c.':B'.$c, function ($cells) {
                            $cell->setBackground('#3399FF');
                            $cell->setAlignment('center');
                            $cell->setValignment('middle');
                       });
                       $c++;
                       foreach ($in_impact as $indicator_key => $in_indicator) {
                            $sheet->mergeCells('A'.$c.':B'.$c, function ($cells) {});
                            $c++;
                            $qa = 4;
                            foreach ($in_indicator as $question_key => $question_value) {
                                $sheet->cell('A'.$qa, function ($cells) {});
                                $sheet->cell('B'.$qa, function ($cells) {});
                                $c++;
                            }
                       }
                    }
                }

                if (!empty($finalArray)) {
                    $c = 1;
                    foreach ($finalArray as $assessment_pillar_id => $in_pillar) {
                        $sheet->setCellValue('A'.$c, $this->getPillarNameById($assessment_pillar_id));
                        $sheet->cell('A'.$c, function($cell) {
                            $cell->setBackground('#ED7D31');
                            $cell->setAlignment('center');
                            $cell->setValignment('middle');
                        });
                        $c++;
                        foreach ($in_pillar as $assessment_impact_area_id => $in_impact) {
                            $sheet->setCellValue('A'.$c, $this->getImpactAreaNameById($assessment_impact_area_id));
                            $sheet->cell('A'.$c, function($cell) {
                                $cell->setBackground('#3399FF');
                                $cell->setAlignment('center');
                                $cell->setValignment('middle');
                            });
                           $c++;
                           foreach ($in_impact as $assessment_indicator_id => $in_indicator) {
                                $sheet->setCellValue('A'.$c, $this->getIndicatorNameById($assessment_indicator_id));
                                $sheet->cell('A'.$c, function($cell) {
                                    $cell->setBackground('#70AD47');
                                    $cell->setAlignment('center');
                                    $cell->setValignment('middle');
                                });
                                $c++;
                                foreach ($in_indicator as $question_key => $question_value) {
                                    $sheet->setCellValue('A'.$c, $question_value['que']);
                                    $sheet->setCellValue('B'.$c, $question_value['ans']);
                                    $c++;
                                }
                           }
                        }
                    }
                }
            });
        })->download($type);
    }
    public function getPillarNameById($assessment_pillar_id) {
        $data = DB::table('assessment_pillar')->where('assessment_pillar_id', $assessment_pillar_id)->first();
        return $data->name;
    }
    public function getImpactAreaNameById($assessment_impact_area_id) {
        $data = DB::table('assessment_Impact_area')->where('assessment_impact_area_id', $assessment_impact_area_id)->first();
        return $data->name;
    }
    public function getIndicatorNameById($assessment_indicator_id) {
        $data = DB::table('assessment_indicator')->where('assessment_indicator_id', $assessment_indicator_id)->first();
        return $data->name;
    }

    /*
    *   Purpose     : Fetch Initial Details of specified user.
    *   @params     : userid as string
    *   @returns    : reponse as array
    *   Date        : 04/06/2018
    *   Author      : Kartik  Shah
    */
    public function getInitUserData($userId)
    {
        $userDetails = array();
        //fetch initiative details of login user.
        $userInitDetails        = DB::table('initiativedetail')->where('user_id', $userId)->first();

        if($userInitDetails)
        {
            if($userInitDetails->key_goals != NULL && $userInitDetails->key_goals != '')
            {
                $userDetails['goals']  = $userInitDetails->key_goals;
            } else {
                $userDetails['goals']  = '';
            }

            if(($userInitDetails->logo_url != NULL && $userInitDetails->logo_url != '')  && file_exists(public_path('/userlogoimages/'.$userInitDetails->logo_url)))
            {
                $userDetails['logo_url']    =   url('public/userlogoimages/'.$userInitDetails->logo_url);
            } else {
                $userDetails['logo_url']    =   '';
            }
        } else {

            $userDetails['goals']       = '';
            $userDetails['logo_url']    =   '';
        }

        $userInitActDetails = DB::table('users_activity')->where('user_id', $userId)->first();

        $userDetails['activities'] = '';
        if($userInitActDetails)
        {
            $userActivities = explode(",",$userInitActDetails->activity_id);
            if(in_array('0',$userActivities)){
                $userDetails['activities'] .= ($userDetails['activities'] != '') ? ', ':'';
                $userDetails['activities'] .= 'Growing Food';
            }
            if(in_array('1',$userActivities)){
                $userDetails['activities'] .= ($userDetails['activities'] != '') ? ', ':'';
                $userDetails['activities'] .= 'Shared Cooking/Eating';
            }
            if(in_array('2',$userActivities)){
                $userDetails['activities'] .= ($userDetails['activities'] != '') ? ', ':'';
                $userDetails['activities'] .= 'Redistribution';
            }
            if(in_array('3',$userActivities)){
                $userDetails['activities'] .= ($userDetails['activities'] != '') ? ', ':'';
                $userDetails['activities'] .= 'Educational';
            }
        }

        return $userDetails;
    }

    /*
    *   Purpose     : Fetch Core Indicators of Impact Report.
    *   @params     : impact report id as string
    *   @returns    : core assessment indicator list as array
    *   Date        : 04/06/2018
    *   Author      : Kartik  Shah
    */
    public function getCoreIndicators($impactReportId)
    {
        $coreIndicators     = DB::table('impact_report_detail')
                                ->join("assessment_indicator",'impact_report_detail.assessment_indicator_id','=','assessment_indicator.assessment_indicator_id')
                                ->select('assessment_indicator.assessment_indicator_id','assessment_indicator.name')
                                ->where('impact_report_detail.impact_report_id', $impactReportId)
                                ->where('impact_report_detail.is_core', 1)
                                ->get()->toArray();
        return $coreIndicators;
    }

    /*
    *   Purpose     : Fetch Imapct Assessment Description.
    *   @params     : impact report id as string
    *   @returns    : Imapct Assessment Description as string
    *   Date        : 05/06/2018
    *   Author      : Kartik  Shah
    */
    public function getImpactAssessmentDescription($impactReportId)
    {
        $impactAssessmentDesc    = '';
        $impactAssessmentData    = DB::table("impact_report")
                                    ->join('impact_assessment', 'impact_report.impact_assessment_id', '=', 'impact_assessment.impact_assessment_id')
                                    ->select("impact_assessment.impact_text")
                                    ->where("impact_report.impact_report_id",$impactReportId)
                                    ->first();

        if($impactAssessmentData){
            $impactAssessmentDesc = $impactAssessmentData->impact_text;
        }

        return $impactAssessmentDesc;
    }

    /*
    *   Purpose     : Fetch Answers of Quantitative questions selected by user.
    *   @params     : impact report id as string
    *   @returns    : answer list as array
    *   Date        : 05/06/2018
    *   Author      : Kartik  Shah
    */
    public function getQuantitativeQuestionAnswers($impactReportId)
    {
        $quantitativeAnsDetails  = DB::table("impact_report_ans_choice")
                                    ->join("impact_report_ans",'impact_report_ans_choice.impact_report_ans_id','=','impact_report_ans.impact_report_ans_id')
                                    ->join("indicator_questions","impact_report_ans.indicator_questions_id",'=',"indicator_questions.indicator_questions_id")
                                    ->select("impact_report_ans_choice.ans", "indicator_questions.ans_icon_id", "indicator_questions.impact_re_text")
                                    ->where("impact_report_ans.impact_report_id",$impactReportId)
                                    ->where("indicator_questions.question_type_id",1)->get()->toArray();

        return $quantitativeAnsDetails;
    }

    /*
    *   Purpose     : Fetch Answers of Qualitative questions selected by user.
    *   @params     : impact report id as string
    *   @returns    : answer list as array
    *   Date        : 05/06/2018
    *   Author      : Kartik  Shah
    */
    public function getQualitativeQuestionAnswers($impactReportId)
    {
        $quantitativeAnsDetails  = DB::table("impact_report_ans_choice")
                                    ->join("impact_report_ans",'impact_report_ans_choice.impact_report_ans_id','=','impact_report_ans.impact_report_ans_id')
                                    ->join("indicator_questions","impact_report_ans.indicator_questions_id",'=',"indicator_questions.indicator_questions_id")
                                    ->select("impact_report_ans_choice.ans")
                                    ->where("impact_report_ans.impact_report_id",$impactReportId)
                                    ->where("indicator_questions.question_type_id",0)->get()->toArray();

        return $quantitativeAnsDetails;
    }

    /*
    *   Purpose     : Fetch Cause of share food.
    *   @params     : impact report id as string
    *   @returns    : Cause of share food as array
    *   Date        : 05/06/2018
    *   Author      : Kartik  Shah
    */
    public function getCauseOfShareFood($impactReportId)
    {
        $causeOfShareFood        = DB::table("impact_report")
                                    ->select("context1", "context2","context3")
                                    ->where("impact_report.impact_report_id",$impactReportId)
                                    ->first();

        return $causeOfShareFood;
    }

    /*
    *   Purpose     : Fetch Imapct Assessment Intro Description.
    *   @params     : impact report id as string
    *   @returns    : Imapct Assessment Description as string
    *   Date        : 05/06/2018
    *   Author      : Kartik  Shah
    */
    public function getImpactAssessmentIntroDescription($impactReportId)
    {
        $impactAssessmentDesc    = '';
        $impactAssessmentData    = DB::table("impact_report")
                                    ->join('impact_assessment', 'impact_report.impact_assessment_id', '=', 'impact_assessment.impact_assessment_id')
                                    ->select("impact_assessment.introduction_desc")
                                    ->where("impact_report.impact_report_id",$impactReportId)
                                    ->first();

        if($impactAssessmentData){
            $impactAssessmentDesc = $impactAssessmentData->introduction_desc;
        }

        return $impactAssessmentDesc;
    }

    /*
    *   Purpose     : Fetch SDGs data.
    *   @params     : impact report id as string
    *   @returns    : SDGs dat as array
    *   Date        : 05/06/2018
    *   Author      : Kartik  Shah
    */
    public function getSDGs($impactReportId)
    {
       $SDGsData = DB::table("impact_report_ans")
                    ->join("indicator_sdgs",'impact_report_ans.assessment_indicator_id','=','indicator_sdgs.assessment_indicator_id')
                    ->join("sdgs",'indicator_sdgs.sdgs_id','=','sdgs.id')
                    ->select("sdgs.name", "sdgs.unique_no", "sdgs.icon_url")
                    ->where("impact_report_ans.impact_report_id",$impactReportId)
                    ->groupBy('sdgs.id')
                    ->orderBy('sdgs.unique_no')
                    ->get()->toArray();



        return $SDGsData;
    }

    /*
    *   Purpose     : Make Share Star Chart.
    *   @params     : impact report id as string
    *   @returns    : chat html as string
    *   Date        : 10/06/2018
    *   Author      : Kartik Shah
    */
    public function makeShareStarChart($impactReportId)
    {
        $impactReportInfo   = DB::table("impact_report")->where(
            "impact_report_id",$impactReportId)->first();

        $impactAssessmentId = $impactReportInfo->impact_assessment_id;

        $assessmentPillar   = DB::table("assessment_pillar")->where("impact_assessment_id",$impactAssessmentId)->orderBy("index_no",'DESC')->get();

        $finalGraphArray    = array();
        foreach ($assessmentPillar as $key => $pillar) {

            $finalGraphArray[$pillar->name][$pillar->sharestar_cat1] = array();
            $finalGraphArray[$pillar->name][$pillar->sharestar_cat2] = array();

            $impactReportAnsData = DB::table("impact_report_ans")->where("impact_report_id",$impactReportId)->get();

            if(!empty($impactReportAnsData))
            {
                $assessmentIndicatorArr = array();
                foreach ($impactReportAnsData as $key=>$ans) {
                    $assessmentIndicatorArr[$ans->assessment_indicator_id][] = $ans->indicator_questions_id;
                }

                foreach ($assessmentIndicatorArr as $key => $indicator_questions) {
                    $assessmentIndicatorData = DB::table("assessment_indicator")->select('in_sharestar_cat1','in_sharestar_cat2')->where('assessment_indicator_id',$key)->first();

                    $directQuestion     = false;
                    $indirectQuestion   = false;
                    $noneQuestion       = false;
                    foreach ($indicator_questions as $questions) {
                        $questionsData = DB::table("indicator_questions")->select('benefit_type_id')->where("indicator_questions_id",$ans->indicator_questions_id)->first();
                        if($directQuestion == false && $questionsData->benefit_type_id == 0) {
                            $directQuestion = true;
                        } else if( $indirectQuestion == false && $questionsData->benefit_type_id == 1) {
                            $indirectQuestion = true;
                        } else if($noneQuestion == false && $questionsData->benefit_type_id == 2) {
                            $noneQuestion       = true;
                        }
                    }
                    // dd($directQuestion);
                    // dd($assessmentIndicatorData->in_sharestar_cat1);
                    // dd($assessmentIndicatorData);
                    if($assessmentIndicatorData->in_sharestar_cat1 == 1 && $directQuestion == true){
                        $finalGraphArray[$pillar->name][$pillar->sharestar_cat1]['directQuestions'][] = 'yes';
                    }
                    if($assessmentIndicatorData->in_sharestar_cat1 == 1 && $indirectQuestion == true) {
                        // dd("in indirectQuestion");
                        $finalGraphArray[$pillar->name][$pillar->sharestar_cat1]['indirectQuestion'][] = 'yes';
                    }
                    if($assessmentIndicatorData->in_sharestar_cat1 == 1 && $noneQuestion == true) {
                        // dd("in noneQuestion");
                        $finalGraphArray[$pillar->name][$pillar->sharestar_cat1]['noneQuestion'][] = 'yes';
                    }

                    if($assessmentIndicatorData->in_sharestar_cat2 == 1 && $directQuestion == true){
                        $finalGraphArray[$pillar->name][$pillar->sharestar_cat2]['directQuestions'][] = 'yes';
                    }
                    if($assessmentIndicatorData->in_sharestar_cat2 == 1 && $indirectQuestion == true) {
                        $finalGraphArray[$pillar->name][$pillar->sharestar_cat2]['indirectQuestion'][] = 'yes';
                    }
                    if($assessmentIndicatorData->in_sharestar_cat2 == 1 && $noneQuestion == true) {
                        $finalGraphArray[$pillar->name][$pillar->sharestar_cat2]['noneQuestion'][] = 'yes';
                    }
                }
            }
        }

        $total_old_columns = 0;
        $total_columns = 0;

        foreach ($finalGraphArray as $key => $pillar_categories) {
            foreach ($pillar_categories as $key => $category) {
                if(!empty($category)){
                 $total_columns += isset($category['indirectQuestion'])?count($category['indirectQuestion']):0;
                 $total_columns += isset($category['directQuestions'])?count($category['directQuestions']):0;
                 $total_columns += isset($category['noneQuestion'])?count($category['noneQuestion']):0;
                }
                if($total_columns > $total_old_columns){
                    $total_old_columns = $total_columns;
                }
                $total_columns = 0;
            }
        }

        //dd($finalGraphArray);

        //$finalGraphArray['total_columns'] = $total_old_columns;

        $view = \View::make('user/sharestarchart', [
            'sharestar_data'    => $finalGraphArray,
            'total_columns'     => $total_old_columns,
            'columns_colorcode' => ['#ffce55','#a2cf70','#4bc1e9','#49cfae']
        ]);
        return $html = $view->render();
        /*return view('user/sharestarchart')
                    ->with(
                        array(
                            "sharestar_data"=>$finalGraphArray
                        )
                    );*/

        //dd($finalGraphArray);
    }
    public function ReportExport($type, $is_approved)
    {
            


        $csv_array = array();
        if($is_approved == 1) {
          $data = DB::table('impact_report')->select('impact_assessment_id', 'date_completed', 'status')->where([['is_finished','=',1],['is_shared','=',1],['is_approved','=',1]])->orderBy('date_completed', 'desc')->get()->toArray();
        } else {
          $data = DB::table('impact_report')->select('impact_assessment_id', 'date_completed', 'status')->where([['is_finished','=',1],['is_shared','=',1],['is_approved','=',0]])->orderBy('date_completed', 'desc')->get()->toArray();
        }
        foreach ($data as $key => $value) {
           $csv_array[] = (array) $value;
        }   
        $curr_date = date('d-m-Y');
        $curr_date = str_replace('-', '', $curr_date);
        if($is_approved == 1) {
          $filename = 'approved_reportlist'.$curr_date;
        } else {
          $filename = 'unapproved_reportlist'.$curr_date;
        }

        return Excel::create($filename, function($excel) use ($csv_array) {
            $excel->sheet('Report List', function($sheet) use ($csv_array)
            {
                $sheet->cell('A1', function($cell) {$cell->setValue('Report title'); });
                $sheet->cell('B1', function($cell) {$cell->setValue('Date'); });
                $sheet->cell('C1', function($cell) {$cell->setValue('Status'); });
                if (!empty($csv_array)) {
                    foreach ($csv_array as $key => $value) {
                        $i= $key+2;
                        $impact_assessment= DB::table('impact_assessment')->where([['impact_assessment_id','=',$value['impact_assessment_id']]])->first();
                        $report_title=$impact_assessment->title;

                        $sheet->cell('A'.$i, $report_title);

                        if(!empty($value['date_completed']))
                        {
                            $report_date_completed =  date('d-m-Y H:m:s',strtotime($value['date_completed'])); 
                        }
                        else
                        {
                            $report_date_completed = "";
                        }
                        $sheet->cell('B'.$i, $report_date_completed); 

                        if($value['status'] == 1) {
                          $status = "Visible";
                        } else {
                          $status = "Hidden";
                        }
                        $sheet->cell('C'.$i, $status);
                    }
                }
            });
        })->download($type);
    }
    
    public function ReportPDFExport($is_approved) 
    {

      if($is_approved == 1) {
          $data = DB::table('impact_report')->select('impact_assessment_id', 'date_completed', 'status')->where([['is_finished','=',1],['is_shared','=',1],['is_approved','=',1]])->orderBy('date_completed', 'desc')->get()->toArray();
          $is_approved = 1;
          $title_caption = "Approved Report List";
        } else {
          $data = DB::table('impact_report')->select('impact_assessment_id', 'date_completed', 'status')->where([['is_finished','=',1],['is_shared','=',1],['is_approved','=',0]])->orderBy('date_completed', 'desc')->get()->toArray();
          $is_approved = 0;
          $title_caption = "Unapproved Report List";
        }
            $curr_date = date('d-m-Y');
            $curr_date = str_replace('-', '', $curr_date);
            if($is_approved == 1) {
              $filename = 'approved_reportlist'.$curr_date.".pdf";
            } else {
              $filename = 'unapproved_reportlist'.$curr_date.".pdf";
            }

            $pdf      = PDF::loadview('admin/report_export_pdf',[
                            "data"=>$data,
                            "is_approved"=>$is_approved])->setPaper('a4', 'portrait');
            return $pdf->download($filename);  
            /*End PDF download code*/
    }
}
