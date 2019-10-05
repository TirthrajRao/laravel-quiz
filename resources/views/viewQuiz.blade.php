@extends('layouts.app')
@section('content')
<div class="page-min-height addQuestion" style="margin-top: -103px;overflow-x: hidden;">
	@if($questionAdded)
	<div class="col-sm-12 col-md-12 alert alert-info">
		<button class="close" data-dismiss="alert" aria-label="close">&times;</button>
		Question successfully added to {{ $test->title }}.
	</div>
	@endif
	<div class="container">
		<div class="row" style="margin: 30px 0px">
			<div class="col-md-7 offset-md-5">
				@if ($message = Session::get('failure'))
				<div class="alert alert-danger" style=" color: #e3342f;    background-color: #f9d6d5; border-color: #f7c6c5; position: absolute; top: 75px; z-index: 1; font-size: 19px; margin-left: 18px;" id="message_id_fail">
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
        $unit = explode(",",$test->title);
        $quizTit =  'Unit - '.$unit[0].', Quiz - '.$unit[1];
    ?>
				<li><a href="JavaScript:Void(0)"><h3 class="headergreen">{{ $quizTit }}</h3></a></li>
				@if (count($questions) > 0)
				@foreach($questions as $index=>$question)
				<li><a href="#tab-{{$index+1}}">{{$index+1}}. {{ $question->question }}</a> </li>
				<a href="JavaScript:Void(0)" class="editquestion" id="{{$question->questionid}}" data-toggle="modal" data-target="#editQueModal">Edit</a><a href="{{ route('delQuestion',[$question->questionid,$test->quizid])}}">Delete</a>	
				@endforeach				
				@endif

			</ul>
			<div class="col-md-9 content_right">
				<div class="register_tab_content">
					<div id="tab-info" class="quesion_display">
						<div class="inner-container">
							<div class="row">
								<div class="col-md-6 offset-md-3">
									<div class="inner-container all_quiz_list">
										<div class="card cardHome">
											<div class="content active">
	<?php
        $unit = explode(",",$test->title);
        $quizTit =  'Unit - '.$unit[0].', Quiz - '.$unit[1];
    ?>
												<h4>{{ $quizTit}}</h4>
												<p>Min. No. of questions: {{ $test->no_of_questions }}</p>
												<p>Total Questions: {{ $questionsCount}}</p>
												@if(!$test->permitted)
												
												<!-- <button type="submit" id="activate-test-{{ $test->quizid }}" class="btn btn-sm btn-success">Activate Test</button> -->
												<button type="button" class="btn btn-sm btn-success" data-toggle="modal" data-target="#activateModel">Activate Test
												</button>
												@else
												{{ Form::open(array('url' => 'deactivateQuiz/'.$test->quizid, 'role' => 'form', 'class' => 'form-horizontal')) }}
												<button type="submit" id="deactivate-test-{{ $test->quizid }}" class="btn btn-sm btn-danger">Deactivate Test</button>
												{{ Form::close() }}
												@endif
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
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
			<button class="btn" data-toggle="modal" data-target="#AddQueModal"><i class="fa fa-plus" style="color: #fff;"></i>
			</button>
		</div>
	</div>
	<!-- activate quiz model-->
	<div class="modal" id="activateModel">
		<div class="modal-dialog">
			{{ Form::open(array('url' => 'activateQuiz/'.$test->quizid, 'role' => 'form', 'class' => 'form-horizontal')) }}
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title">Activate Quiz</h4>
					<button type="button" class="close" data-dismiss="modal" style="color: inherit!important">&times;</button>
				</div>
				<div class="modal-body">
					<div class="row" style="margin: 10px 0px">
						<div class="col-md-8">
							<div class="filter-content" style="margin: 30px 0px">
								<div class="form-group">
									<div class="row">
										<div class="col-md-6 labelContent">
											<label for="question-type" class="control-label">Year</label>
										</div>
										<div class="col-md-6" >
											<!-- Assign a role as well. Default: Faculty -->
											<input type="radio" value="1" name="year" class="pull-left form-group" required="" />
											<label for="mcq">&nbsp;&nbsp;1st year</label>
											<br>
											<input type="radio" value="2" name="year" class="pull-left form-group" required="" />
											<label for="tf">&nbsp;&nbsp;2nd year</label>
											<br>
										</div>	
									</div>
								</div>
							</div>				
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn_cancel" data-dismiss="modal" style="width: 88px;">Close</button>
					<button type="submit" class="btn btn_quiz" id="activate-test-{{ $test->quizid }}">Activate</button>
				</div>
			</div>
			{!! Form::close() !!}
		</div>
	</div>
	<!-- modal -->
	<div class="modal" id="AddQueModal">
		<div class="modal-dialog">
			{!! Form::open(array('url' => 'addQuestion/'.$test->quizid, 'name' => 'add-question', 'id' => 'add-question', 'role' => 'form')) !!}
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title">Add Question</h4>
					<button type="button" class="close" data-dismiss="modal" style="color: inherit!important">&times;</button>
				</div>
				<div class="modal-body">
					<div class="row" style="margin: 10px 0px">
						<div class="col-md-12">
							<div class="filter-content" style="margin: 30px 0px">
								<div class="form-group">
									<div class="row">
										<div class="col-md-6 labelContent">
											<label for="question-type" class="control-label">Question Type</label>
										</div>
										<div class="col-md-6" >
											<!-- Assign a role as well. Default: Faculty -->
											<input type="radio" value="mcq" name="question-type" class="pull-left form-group" required="" />
											<label for="mcq">&nbsp;&nbsp;MCQ</label>
											<br>
											<input type="radio" value="tf" name="question-type" class="pull-left form-group" required="" />
											<label for="tf">&nbsp;&nbsp;True Or False</label>
											<br>

											<input type="radio" value="fib" name="question-type" class="pull-left form-group" required="" />
											<label for="fib">&nbsp;&nbsp;Fill the Blank</label>
										</div>
									</div>
								</div>
								<div class="form-group">
									<div class="row">
										<div class="col-md-6">
											<label for="question-text" class=" control-label">Question</label>
										</div>
										<div class="col-md-6">
											<textarea rows="3" cols="20" style="resize: none;" id="question-text" name="question-text" class="" form="add-question" placeholder="Enter Question..."></textarea>
				@error('question-text')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
										</div>
									</div>
								</div>
								<div class="box mcq">
									<div class="form-group">
										<div class="row">
											<div class="col-md-6">
												<label>Option 1: </label>
											</div>
											<div class="col-md-6">
												<input name="option1" type="text" class=""  id="option1" placeholder="Option 1" />
												@error('option1')
								                <span class="invalid-feedback" role="alert">
								                    <strong>{{ $message }}</strong>
								                </span>
								                @enderror
								                
								                <span class="invalid-feedback" role="alert">
					                    		<strong class="error_option"></strong>
					                </span>
											</div>
										</div>
									</div>
									<div class="form-group">
										<div class="row">
											<div class="input-group form-group">
												<div class="col-md-6">
													<label>Option 2: </label>
												</div>
												<div class="col-md-6">
													<input name="option2" type="text" class=""  id="option2" placeholder="Option 2" />
													@error('option2')
								                <span class="invalid-feedback" role="alert">
								                    <strong>{{ $message }}</strong>
								                </span>
								                @enderror
												</div>
											</div>
										</div>
									</div>
									<div class="form-group">
										<div class="row">
											<div class="input-group form-group">
												<div class="col-md-6">
													<label>Option 3: </label>
												</div>
												<div class="col-md-6">
													<input name="option3" type="text" class=""  id="option3" placeholder="Option 3" />
													@error('option3')
								                <span class="invalid-feedback" role="alert">
								                    <strong>{{ $message }}</strong>
								                </span>
								                @enderror
												</div>
											</div>
										</div>
									</div>
									<div class="form-group">
										<div class="row">
											<div class="input-group form-group">
												<div class="col-md-6">
													<label>Option 4: </label>
												</div>
												<div class="col-md-6">
													<input name="option4" type="text" class=""  id="option4" placeholder="Option 4" />
													@error('option4')
								                <span class="invalid-feedback" role="alert">
								                    <strong>{{ $message }}</strong>
								                </span>
								                @enderror
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="form-group box tf">
								<div class="row">
									<div class="col-md-6">
										<label for="tfanswer" class="control-label">Select Answer:</label>
									</div>
									<div class="col-md-4">
										<select class="" id="sel1" name="tfanswer">
											<option value="1">True</option>
											<option value="0">False</option>
										</select>
									</div>
								</div>
							</div>
							<div class="form-group box mcq fib">
								<div class="row">
									<div class="col-md-6">
										<label for="answer" class="control-label">Answer</label>
									</div>
									<div class="col-md-6">
										<input id="answer" type="text" class="" name="answer" placeholder="Answer">
										@error('answer')
						                <span class="invalid-feedback" role="alert">
						                    <strong>{{ $message }}</strong>
						                </span>
						                @enderror
									<span class="invalid-feedback" role="alert">
					                    <strong class="error_answer"></strong>
					                </span>
									</div>
								</div>
							</div>
							<!-- <div class="form-group">
								<div class="row">
									<div class="col-md-6">
										<label for="time" class="control-label">Time:</label>
									</div>
									<div class="col-md-5">
										<input id="time" type="time" class="" name="question-duration" placeholder="in MM:SS format" onkeypress="return isNumberKey(event)" required/>
										 	 @error('question-duration')
								            <span class="invalid-feedback" role="alert">
								                <strong>{{ $message }}</strong>
								            </span>
								          @enderror
									</div>
								</div>
							</div> -->
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn_cancel" data-dismiss="modal" style="width: 88px;">Close</button>
					<button type="submit" class="btn btn_quiz mcq_validation">Save</button>
				</div>
			</div>
			{!! Form::close() !!}
		</div>
	</div>
	<!-- edit modal -->
	<div class="modal" id="editQueModal">
		<div class="modal-dialog">
			{!! Form::open(array('url' => 'editQuestion/'.$test->quizid,  'role' => 'form')) !!}
			<input name="quesionModelIdEdit" type="hidden" id="quesionModelIdEdit" value="" />
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title">Edit Question</h4>
					<button type="button" class="close" data-dismiss="modal" style="color: inherit!important">&times;</button>
				</div>
				<div class="modal-body">
					<div class="row" style="margin: 10px 0px">
						<div class="col-md-12">
							<div class="filter-content" style="margin: 30px 0px">
								<div class="form-group">
									<div class="row">
										<div class="col-md-6 labelContent">
											<label for="question-type-edit" class="control-label">Question Type</label>
										</div>
										<div class="col-md-6" >
											<!-- Assign a role as well. Default: Faculty -->
											<input type="radio" value="mcq" name="question-type-edit" class="pull-left form-group" required="" />
											<label for="mcq">&nbsp;&nbsp;MCQ</label>
											<br>
											<input type="radio" value="tf" name="question-type-edit" class="pull-left form-group" required="" />
											<label for="tf">&nbsp;&nbsp;True Or False</label>
											<br>

											<input type="radio" value="fib" name="question-type-edit" class="pull-left form-group" required="" />
											<label for="fib">&nbsp;&nbsp;Fill the Blank</label>
										</div>
									</div>
								</div>
								<div class="form-group">
									<div class="row">
										<div class="col-md-6">
											<label for="question-text-edit" class=" control-label">Question</label>
										</div>
										<div class="col-md-6">
											<!-- <textarea rows="3" cols="20" style="resize: none;" id="question-text-edit" name="question-text-edit" class="" form="question-text-edit" placeholder="Enter Question..."></textarea> -->
											<input type="text"  name="question-text-edit" id="question-text-edit" class="pull-left form-group" required="" />
				@error('question-text-edit')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
										</div>
									</div>
								</div>
								<div class="box mcq">
									<div class="form-group">
										<div class="row">
											<div class="col-md-6">
												<label>Option 1: </label>
											</div>
											<div class="col-md-6">
												<input name="option1-edit" type="text" class=""  id="option1-edit" placeholder="Option 1"  />
												@error('option1-edit')
								                <span class="invalid-feedback" role="alert">
								                    <strong>{{ $message }}</strong>
								                </span>
								                @enderror	         
								                <span class="invalid-feedback" role="alert">
								                    <strong class="error_option_edit"></strong>
								                </span>
											</div>
										</div>
									</div>
									<div class="form-group">
										<div class="row">
											<div class="input-group form-group">
												<div class="col-md-6">
													<label>Option 2: </label>
												</div>
												<div class="col-md-6">
													<input name="option2-edit" type="text" class=""  id="option2-edit" placeholder="Option 2" />
												@error('option2-edit')
								                <span class="invalid-feedback" role="alert">
								                    <strong>{{ $message }}</strong>
								                </span>
								                @enderror
												</div>
											</div>
										</div>
									</div>
									<div class="form-group">
										<div class="row">
											<div class="input-group form-group">
												<div class="col-md-6">
													<label>Option 3: </label>
												</div>
												<div class="col-md-6">
													<input name="option3-edit" type="text" class=""  id="option3-edit" placeholder="Option 3" />
												@error('option3-edit')
								                <span class="invalid-feedback" role="alert">
								                    <strong>{{ $message }}</strong>
								                </span>
								                @enderror
												</div>
											</div>
										</div>
									</div>
									<div class="form-group">
										<div class="row">
											<div class="input-group form-group">
												<div class="col-md-6">
													<label>Option 4: </label>
												</div>
												<div class="col-md-6">
													<input name="option4-edit" type="text" class=""  id="option4-edit" placeholder="Option 4" />
												@error('option4-edit')
								                <span class="invalid-feedback" role="alert">
								                    <strong>{{ $message }}</strong>
								                </span>
								                @enderror
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="form-group box tf">
								<div class="row">
									<div class="col-md-6">
										<label for="tfanswer" class="control-label">Select Answer:</label>
									</div>
									<div class="col-md-4">
										<select class="" id="sel1-edit" name="sel1-edit">
											<option value="1">True</option>
											<option value="0">False</option>
										</select>
									</div>
								</div>
							</div>
							<div class="form-group box mcq fib">
								<div class="row">
									<div class="col-md-6">
										<label for="answer" class="control-label">Answer</label>
									</div>
									<div class="col-md-6">
										<input id="answer-edit" type="text" class="" name="answer-edit" placeholder="Answer">
										<span class="invalid-feedback" role="alert">
					                    <strong class="error_answer_edit"></strong>
					                </span>
									</div>
								</div>
							</div>
							
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn_cancel" data-dismiss="modal" style="width: 88px;">Close</button>
					<button type="submit" class="btn btn_quiz mcq_validation_edit">Save</button>
				</div>
			</div>
			{!! Form::close() !!}
		</div>
	</div>
</div>
<script type="text/javascript">
 /*  set time out to success message */
         setTimeout(function(){
            $("#message_id_fail").remove();
        }, 3000 );
/* add model mcq validation */
$('.mcq_validation').click(function(){
	$('.error_option').html('');
	$('.error_answer').html('');
	var qtype = $('input[name=question-type]:checked').val();
	var option1 = $('#option1').val();
	var option2 = $('#option2').val();
	var option3 = $('#option3').val();
	var option4 = $('#option4').val();
	var answer = $('#answer').val(); 

	if(qtype == 'mcq'){
		if(option1 == option2 || option1 == option3 || option1 == option4 || option2 == option3 || option2 == option4 || option3 == option4){
    	 $('.error_option').html('Please do not add same options');
			return false;    	
    }
		var arlene1 = [];
		arlene1.push(option1);
		arlene1.push(option2);
		arlene1.push(option3);
		arlene1.push(option4);
		if(arlene1.indexOf(answer) !== -1){
		        
		} else{
		    $('.error_answer').html('Your answer is not valid');
			return false;
		}
	}
});
/* edit model mcq validation */
$('.mcq_validation_edit').click(function(){
	$('.error_option_edit').html('');
	$('.error_answer_edit').html('');
	var qtype = $('input[name=question-type-edit]:checked').val();
	var option1 = $('#option1-edit').val();
	var option2 = $('#option2-edit').val();
	var option3 = $('#option3-edit').val();
	var option4 = $('#option4-edit').val();
	var answer = $('#answer-edit').val();

	if(qtype == 'mcq'){
		 if(option1 == option2 || option1 == option3 || option1 == option4 || option2 == option3 || option2 == option4 || option3 == option4){
    	 $('.error_option_edit').html('Please do not add same options');
			return false;    	
    }
		var arlene1 = [];
		arlene1.push(option1);
		arlene1.push(option2);
		arlene1.push(option3);
		arlene1.push(option4);
		if(arlene1.indexOf(answer) !== -1){		        
		
		} else{
		    $('.error_answer_edit').html('Your answer is not valid');
			return false;
		}
	}
});

	function isNumberKey(evt){
    var charCode = (evt.which) ? evt.which : event.keyCode
    if (charCode > 31 && (charCode < 48 || charCode > 57))
        return false;
    return true;
	}
$(".editquestion").click(function() {
    var Id = $(this).attr('id');  
    var ajax_url = '/getQuestionData/'+Id; 

                $.ajax({                    
                    url: ajax_url,
                    type: "GET",  
                    crossDomain: true,
                    dataType: 'json',                                    
                    success: function (data) { 	
                    $('#quesionModelIdEdit').val(data.questions_data.questionid);
                    $('#question-text-edit').val(data.questions_data.question); 
                    /*$("textarea#question-text-edit").val(data.questions_data.question);*/

                    $('#answer-edit').val(data.questions_data.answer);  
                    $('input:radio[name=question-type-edit][value='+data.questions_data.question_type+']').click();
                    $('select[name^="sel1-edit"] option[value="'+data.questions_data.answer+'"]').attr("selected","selected");                  
                    $('#question-duration-edit').val(data.questions_data.question_duration);

                    $('#option1-edit').val(data.questions_data.option_1);
                    $('#option2-edit').val(data.questions_data.option_2);
                    $('#option3-edit').val(data.questions_data.option_3);
                    $('#option4-edit').val(data.questions_data.option_4);

                    
                    }
                });
    });
</script>
@endsection
