@extends('layouts.adminMaster')
@section('content')
<div class="page-min-height addQuestion" style="margin-top: -103px;overflow-x: hidden;">
	
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
												<p>Total Questions:  {{ $questionsCount}}</p>
												@if(!$test->permitted)
												
												<!-- <button type="submit" id="activate-test-{{ $test->quizid }}" class="btn btn-sm btn-success">Activate Test</button> -->
												<button style="cursor: unset;" type="button" class="btn btn-sm btn-danger">Deactivated Test
												</button>
												@else
												
												<button type="button" style="cursor: unset;" class="btn btn-sm btn-success">Activated Test</button>												
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
