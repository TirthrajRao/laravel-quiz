@extends('layouts.studentMaster')

@section('content')
<div class="page-min-height"  style="background-color: rgb(69, 77, 102)">
	<section class="all_quiz_list" style="padding: 40px 0px 16px">
    <div class="container">
       <div class="row">        
                @foreach ($allQuiz as $index=>$qz)               
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="inner-container">
                        <div class="card cardHome">
                            <div class="content active">
                                 <?php
                            $unit = explode(",",$qz->title);
                            $quizTit =  'Unit - '.$unit[0].', Quiz - '.$unit[1];
                                ?>
                                <h4>{{$quizTit}}</h4>
                                <p>Created   by {{$qz->name}} <i class="em em-coffee"></i></p> 
                                <?php
                                if(!empty($qz->attempt_no_of__que)){
                                    $attemptQue = $qz->attempt_no_of__que;
                                }else{
                                    $attemptQue = '';
                                }
                                $uid = Auth::user()->id;       
                                $latestQue = \DB::table('user_responses')->where('user_id',$uid)->where('quiz_id',$qz->quizid)->latest()->first();
                                if(!empty($latestQue)){ 
                                 $att_que_user = $latestQue->attempt_no_of__que;             
                                $page = $latestQue->attempt_no_of__que + 1;
                                $att_status_user = $latestQue->status;
                                }else{
                                    $page = '';
                                    $att_que_user  = '';
                                    $att_status_user = '';
                                }                               
                                ?>                                
                            @if($qz->no_of_questions == $att_que_user) 
                                <a href="{{ url('/userResultsStudent') }}" class="btn btn_quiz float-left">Result</a>
                            @elseif($att_status_user == 1)
                                <a href="/takeQuizStudent/{{$qz->quizid}}?page={{$page}}" class="btn btn_quiz float-left">Resume</a>
                            @else
                                 <a href="/quizWelcomeStudent/{{ $qz->quizid }}" class="btn btn_quiz float-left">Start</a>
                            @endif
                               
                                
                                <a href="/quizLeaderboardStudent/{{ $qz->quizid }}" class="btn btn_quiz float-left" style="background-color: rgba(150,38,166,1)">Score Board</a>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
        </div>
    </div>
	</section>
</div>
@endsection