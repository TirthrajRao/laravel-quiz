@extends('layouts.app')
@section('content')
<div class="page-min-height" style="background-color: #343F4A">

<section class="all_quiz_list" style="padding: 40px 0px 16px">
        <div class="container">
            <div class="section_title" align="center" data-aos="flip-up" data-aos-duration="1000">
                <p id="list_p">Quizzes</p>
                <h3 style="color: #fff">Shared with you!</h3>
            </div>
            <div class="row">
                @foreach ($allQuiz as $index=>$qz)
                 <?php 
              $user = Auth::user();              
             /* $result = \DB::table('users')->where('id',$user->id)->whereRaw("find_in_set('".$qz->quizid."',users.shared_quiz_id)")->get();
                echo "<pre>";
                print_r($result);*/
                 ?>
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="inner-container">
                        <div class="card cardHome">
                            <div class="content active">
                                <?php
                            $unit = explode(",",$qz->title);
                            $quizTit =  'Unit - '.$unit[0].', Quiz - '.$unit[1];
                                ?>
                               <a href="{{ route('quizDetail',$qz->quizid) }}"> <h4>{{ $quizTit}}</h4></a>
                                <p>Created   by {{$qz->name}}<i class="em em-coffee"></i></p>
                                
                                
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal" id="AddQueModal">
        <div class="modal-dialog">
            {!! Form::open(array('url' => 'addSuggestion','role' => 'form')) !!}

            <input type="hidden"  name="qId" id="qId"
                                             value="{{$qz->quizid}}">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Add Suggestion</h4>
                    <button type="button" class="close" data-dismiss="modal" style="color: inherit!important">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="row" style="margin: 10px 0px">
                        <div class="col-md-8">
                            <div class="filter-content" style="margin: 30px 0px">                               
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label for="suggestion-text" class=" control-label">Suggestion</label>
                                        </div>
                                        <div class="col-md-5">        
                                       <textarea rows="3" cols="20" style="resize: none;" id="suggestion-text" name="suggestion-text" class=""  placeholder="Enter Suggestion..." required=""></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>                          
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn_cancel" data-dismiss="modal" style="width: 88px;">Close</button>
                    <button type="submit" class="btn btn_quiz">Save</button>
                </div>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
                @endforeach
            </div> 
        </div>
    </section>
        
</div>

@endsection