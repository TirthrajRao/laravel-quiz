@extends('layouts.app')
@section('content')
<div class="page-min-height" style="background-color: #454d66">
	<div class="container">
		<div class="row">
			<div class="col-md-6"></div>
			<div class="col-md-4 offset-md-7">
				@if ($message = Session::get('success'))
				<div class="alert alert-success" id="message_id">
					<p>{{ $message }}</p>
				</div>
				@endif
			</div>
		</div>
		<div class="row">
			<div class="col-lg-6">
				<h5 style="color: #fff; margin-bottom: 35px;text-align: right;font-size: 24px;font-weight: 700">Create Quiz</h5>
				<div class="card createQuiz">
					<article class="card-group-item">
						<div class="container" style="margin-top: 10px">
						</div>
						<div class="filter-content">
							<div class="card-body">
								{{ Form::open(array('url' => 'createQuiz','method' => 'post', 'role' => 'form', 'class' => 'form-horizontal')) }}
								<div class="form-group {{ $errors->has('quiz-title') ? 'has-error' : ''}}">
									<div class="row">
										<div class="col-md-4">
											<label for="test-title" class=" control-label">Quiz Title</label>
										</div>
										<div class="col-md-8">
											<label for="test-title" class=" control-label">Unit</label>
											<input type="hidden" value="" name="quiz-title" id="quiz-title">
											<input id="quiz-unit" placeholder="" class="num_input" type="number" onfocus="this.placeholder = ''"
											onblur="this.placeholder = '<number>'" name="quiz-unit" required="required" value="{{old('quiz-title')}}">
											<label for="test-title" class=" control-label">Quiz</label>
											<input id="quiz-number" placeholder="" type="number" onfocus="this.placeholder = ''"
											onblur="this.placeholder = '<number>'" class="num_input"  name="quiz-number" required="required" value="{{old('quiz-title')}}">
											{!! $errors->first('quiz-title', '<p class="help-block" style="color:red">:message</p>') !!}
										</div>
									</div>
								</div>
								<div class="form-group">
									<div class="row">
										<div class="col-md-6">
											<label for="num-questions" class="control-label">Min. questions to be asked</label>
										</div>
										<div class="col-md-6">
											<input type="number" min="2" max="50" value="2"  name="num-questions"
											>
										</div>
									</div>
								</div>
								<div class="form-group ">
									<br/>
									<button type="submit" class="btn btn_quiz" onclick="merge_qtitle();">Create Quiz</button>
								</div>
								{{ Form::close() }}
							</div> 
						</div>
					</article>
				</div>
			</div>
			<div class="col-lg-6">
				@if (count($testsByMe) > 0)
				<table class="rwd-table">
					<h5 style="color: #fff; margin-bottom: 35px;text-align: right;font-size: 24px; font-weight: 700">My Quizzes</h5>
					<tbody>
						<tr class="create_quiz">
							<th class="headergreen">Quiz Title</th>
							<th class="headergreen">Created on</th>
							<th class="headergreen">Published</th>
							<th class="headergreen">Details</th>
							<th class="headergreen">Action</th>	
						</tr>
						@foreach($testsByMe as $QuizByMe)
						<tr>
							<td data-th="Quiz Title">
								<?php
							$unit = explode(",",$QuizByMe->title);
							$quizTit =  'Unit - '.$unit[0].', Quiz - '.$unit[1];
								?>
								<a href="{{ route('detailPage',$QuizByMe->quizid) }}" style="color: #fff;">{{$quizTit}}</a>
								<!-- {{ $QuizByMe->title }} -->
							</td>
							<td data-th="Created On">
								{{ $QuizByMe->created_at->toDateString() }}
							</td>
							<td data-th="Published">
								@if($QuizByMe->permitted)
								Yes
								@else
								No
								@endif
							</td>
							<td data-th="Details">
								<a href="/viewQuiz/{{ $QuizByMe->quizid }}"><button style="border: none; background-color: #009975;color: #fff; cursor: pointer;border-radius: 5px;">Click</button></a>
							</td>
							<td data-th="Action">
								
								<a href="{{ route('deleteQuiz',$QuizByMe->quizid) }}"><button type="submit" id="delete-user-{{ $QuizByMe->quizid }}" style="border: none; background-color: red;color: #fff; cursor: pointer;border-radius: 5px; margin: 1px;">Delete</button></a>
								

								<a href="JavaScript:Void(0)"  data-toggle="modal" data-target="#AddQueModal" class="editquiz" id="{{$QuizByMe->quizid}}"><button style="border: none; background-color: #009975;color: #fff; cursor: pointer;border-radius: 5px; margin: 1px;">Edit</button></a>

								@if($QuizByMe->permitted == 1)
								<a href="JavaScript:Void(0)"  data-toggle="modal" data-target="#ShareQueModal" class="editquiz getName" id="{{$QuizByMe->quizid}}"><button style="border: none; background-color: #009975;color: #fff; cursor: pointer;border-radius: 5px; margin: 1px;">Share</button></a>
								@endif
							</td>							
						</tr>
	<div class="modal" id="AddQueModal">
		<div class="modal-dialog">
			{!! Form::open(array('url' => 'updateQuiz','role' => 'form')) !!}

			<input type="hidden"  name="quizEditId" id="quizEditId" value="">
			<input type="hidden"  name="quiz_title" id="quiz_title" value="">

			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title headergreen">Edit Quiz</h4>
					<button type="button" class="close" data-dismiss="modal" style="color: inherit!important">&times;</button>
				</div>
				<div class="modal-body">
					<div class="row" style="margin: 10px 0px">
						<div class="col-md-9">
							<div class="filter-content" style="margin: 30px 0px">								
								<div class="form-group">
									<div class="row">
										<div class="col-md-4">
											<label for="question-text" class=" control-label">Quiz Title</label>
										</div>
										
										<div class="col-md-8">
									 	<label for="test-title" class=" control-label">Unit</label>		
										<input type="number"  name="quiz-title-edit" id="quiz-title-edit"
											required="" class="num_input" value="{{ $QuizByMe->title }}">
										<label for="test-title" class=" control-label">Quiz</label>	
										<input type="number"  name="quiz-edit" id="quiz-edit"
											required=""  class="num_input"  value="{{ $QuizByMe->title }}">


				@error('quiz_title')
                <span class="invalid-feedback" role="alert" >
                    <strong class="error-edit">{{ $message }}</strong>
                </span>
                @enderror
										</div>
									</div>
								</div>
								<div class="form-group">
									<div class="row">
										<div class="col-md-6">
											<label for="num-questions" class="control-label">Min. questions to be asked</label>
										</div>
										<div class="col-md-6">
											<input type="number" min="2" max="50" value="2" id="num-questions" name="num-questions"
											required="">
										</div>
									</div>
								</div>
							
							</div>							
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn_cancel" data-dismiss="modal" style="width: 88px; background-color:rgb(150, 38, 166); color: white;">Close</button>
					<button type="submit" class="btn btn_quiz" onclick="merge_qtitle_edit();">Save</button>
				</div>
			</div>
			{!! Form::close() !!}
		</div>
	</div>
	<!-- share model start -->
	<div class="modal" id="ShareQueModal">
		<div class="modal-dialog">
			{!! Form::open(array('url' => 'shareQuiz','role' => 'form')) !!}

			<input type="hidden"  name="quizshareId" id="quizshareId"
											 value="">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title">Share Quiz</h4>	
					<button type="button" class="close" data-dismiss="modal" style="color: inherit!important">&times;</button>
				</div>
				<div class="modal-body">
					<div class="row" style="margin: 10px 0px">
						<div class="col-md-8">
							<div class="filter-content" style="margin: 30px 0px">								
								<div class="form-group">
									<div class="row">
										<div class="col-6">
											<label for="question-text" class=" control-label">Name</label>
										</div>
										<div class="col-5">
										
										<select id="teacher_id" name="teacher_id" required>
										</select>		
										@error('teacher_id')
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
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn_cancel" data-dismiss="modal" style="width: 88px;  background-color:rgb(150, 38, 166); color: white;">Close</button>
					<button type="submit" class="btn btn_quiz">Share</button>
				</div>
			</div>
			{!! Form::close() !!}
		</div>
	</div>
						@endforeach
					</tbody>
				</table>				
				@else
				<h5 style="color: #fff; margin-bottom: 35px;text-align: center;font-size: 24px; font-weight: 700">No Quizzes added!</h5>
				@endif
				<div class="create_pagination" style="margin-top: 35px; margin-bottom: 35px;" >
					{{ $testsByMe->links() }}
				</div>
			</div>
		</div> 
	</div>
</div>

<script type="text/javascript">

// open model when error occur
var eds = $('.error-edit').html();
if(eds == 'The quiz title has already been taken.'){
	@if (count($errors) > 0)
    $('#AddQueModal').modal('show');
  @endif
}


	function merge_qtitle(){
		var Unit = $('#quiz-unit').val();
		var Quiz = $('#quiz-number').val();
		$('#quiz-title').val(Unit+','+Quiz);
	}
	function merge_qtitle_edit(){
		var Unit = $('#quiz-title-edit').val();
		var Quiz = $('#quiz-edit').val();
		$('#quiz_title').val(Unit+','+Quiz);
	}
	$("document").ready(function(){
		setTimeout(function(){
			$("#message_id").remove();
		}, 1000 );
	});
	
	
$(".getName").click(function() {
	$('#teacher_id')
    .find('option')
    .remove()
    .end()
    .append('<option value="">Select</option>')
    .val('');
	var Id = $(this).attr('id'); 
	 var ajax_url = 'getName/'+Id;     
                $.ajax({                    
                    url: ajax_url,
                    type: "GET",  
                    crossDomain: true,
                    dataType: 'json',                                    
                    success: function (data) { 
                    if(data.success = 'success'){
                      var myArray = JSON.stringify(data.teacherArray);
                      $.each(data.teacherArray, function (index, v) {
                      	$('#teacher_id').append("<option value='"+v.id+"'>"+v.name+"</option>");
       
    					});
                  	}
                    }
                });
	});
$(".editquiz").click(function() {
    var Id = $(this).attr('id');  
    var ajax_url = 'getQuizData/'+Id;     
                $.ajax({                    
                    url: ajax_url,
                    type: "GET",  
                    crossDomain: true,
                    dataType: 'json',                                    
                    success: function (data) { 
                    	var res = data.data.title;
                    	var array = res.split(",");
                       $('#quiz-title-edit').val(array[0]);
                       $('#quiz-edit').val(array[1]);
                       $('#num-questions').val(data.data.no_of_questions);
					   $('#quizEditId').val(data.data.quizid);
					   $('#quizshareId').val(data.data.quizid);
                    }
                });
    });
</script>
@endsection

