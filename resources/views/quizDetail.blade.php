@extends('layouts.app')
@section('content')
<div class="page-min-height addQuestion" style="margin-top: -103px;overflow-x: hidden;">
	
	<div class="container">
		<div class="row" style="margin: 30px 0px">
			<div class="col-md-7 offset-md-5">
				@if ($message = Session::get('failure'))
				<div class="alert alert-danger" style=" color: #e3342f;    background-color: #f9d6d5; border-color: #f7c6c5; position: absolute; top: 75px; z-index: 1; font-size: 19px; margin-left: 18px;" id="message_id">
					<p>{{ $message }}</p>
				</div>
				@endif
			</div>
		</div>
	</div>

	<div class="row" style="margin-top: 30px;">
		<div class="col-md-6 offset-md-6">
			@if ($message = Session::get('success'))
			<div class="alert alert-success" id="message_id" style="position: absolute; top: 60px; z-index: 1; margin-left: 35px;">
				<p>{{ $message }}</p>
			</div>
			@endif
		</div>
	</div>
	<div class="container-fluid">
		<div id="responsiveTabsDemo" class="row">
			<ul class="register_tab_title col-md-3 content_left">
				<?php
			        $unit = explode(",",$title->title);
			        $quizTit =  'Unit - '.$unit[0].', Quiz - '.$unit[1];
			    ?>
				<h3>{{$quizTit}}</h3>
				@if (count($questions) > 0)
				@foreach($questions as $index=>$question)
				<li><a href="#tab-{{$index+1}}" class="showone{{$index+1}}">{{$index+1}}. {{ $question->question }}</a> </li>
					
				@endforeach				
				@endif

			</ul>
			<div class="col-md-9 content_right">
				
				@if (count($questions) > 0)
				@foreach($questions as $index=>$question)
				<div class="register_tab_content">
					<div id="tab-{{$index+1}}" class="quesion_display">
						<h2>{{$index+1}}. {{ $question->question }}</h2>
						<!-- <p>Description (Optional)</p> -->
						@if( $question->question_type == 'mcq')
						<hr>	
						<div class="row numbers">
							<div class="col-6">
								a) {{ $question->option_1 }}
							</div>
							<div class="col-6">
								b) {{ $question->option_2 }}
							</div>
							<div class="col-6">
								c) {{ $question->option_3 }}
							</div>
							<div class="col-6">
								d) {{ $question->option_4 }}
							</div>
						</div>
						<hr>
						<div class="col-12" style="padding-left: 0px"><h3>Answer: {{ $question->answer }}</h3> </div>
						@endif
						@if($question->question_type == 'tf')
						<hr>
						<div class="row">
							@if($question->answer == 1)
							<div class="col-12"><h3>Answer: <span>True </span></h3> </div>
							@else
							<div class="col-12" ><h3>Answer:  <span>False</span></h3></div>
							@endif
						</div>
						@endif
						@if( $question->question_type == 'fib')
						<hr>
						<div class="col-12" style="padding-left: 0px"><h3>Answer: {{ $question->answer }}</h3> </div>
						@endif
					</div>
				</div>
				@endforeach
				@endif
			</div>
		</div>
		<div class="add_que_class">
			<button class="btn" data-toggle="modal" data-target="#AddQueModal" style="border-radius: 7px; width: 130px; color: white">Add Suggestion
			</button>
		</div>
	</div>
	 <div class="modal" id="AddQueModal">
        <div class="modal-dialog">
            {!! Form::open(array('url' => 'addSuggestion','role' => 'form')) !!}

            <input type="hidden"  name="qId" id="qId"
                                             value="{{$quiz}}">
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
	
	
</div>
<script type="text/javascript">
$( document ).ready(function() {
	//alert("jkj");
	    $(".showone1").trigger('click');

	//$('.showone1').click();
});
</script>
@endsection
