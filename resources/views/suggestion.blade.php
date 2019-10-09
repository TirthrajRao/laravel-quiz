@extends('layouts.app')

@section('content')
<div class="page-min-height"  style="background-color: rgb(69, 77, 102)">
	<section class="all_quiz_list" style="padding: 40px 0px 16px">
    <div class="container">
       <div class="row">  
         @if (count($suggestion) > 0)              
                @foreach ($suggestion as $index=>$qz)          
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="inner-container">
                        <div class="card cardHome">
                            <div class="content active">
                                <?php
                            $unit = explode(",",$qz->title);
                            $quizTit =  'Unit - '.$unit[0].', Quiz - '.$unit[1];
                                ?>
                                <h4>{{$quizTit}}</h4>
                                <p>Suggested   by  {{$qz->name}}<i class="em em-coffee"></i></p><span>{{$qz->suggestion}}</span>                              
                            </div>
                        </div>
                    </div>
                </div>
                 @endforeach
        @else
         <h5 style="color: #fff; margin-bottom: 35px;text-align: center;font-size: 24px; font-weight: 700">This Quiz has not get any suggestion !</h5>
        @endif
       
        </div>
    </div>
	</section>
</div>
@endsection