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
			<div class="col-md-8 offset-md-2">
				@if ($message = Session::get('failure'))
				<div class="alert alert-danger" id="message_id">
					<p>{{ $message }}</p>
				</div>
				@endif
			</div>
		</div>
	</div>

	<div class="row" style="margin-top: 30px;">
		<div class="col-md-6 offset-md-3">
			@if ($message = Session::get('success'))
			<div class="alert alert-success" id="message_id">
				<p>{{ $message }}</p>
			</div>
			@endif
		</div>
	</div>


	<div class="container-fluid">
		<div id="responsiveTabsDemo" class="row">
			<ul class="register_tab_title col-md-3 content_left">
				<li><a href="#tab-info"><h3>{{ $test->title }} Quiz</h3></a></li>
				@if (count($questions) > 0)
				@foreach($questions as $index=>$question)
				<li><a href="#tab-{{$index+1}}">{{$index+1}}. {{ $question->question }}</a></li>
				@endforeach
				@endif
			</ul>
			<div class="col-md-9 content_right">
				<div class="register_tab_content">
					<div id="tab-info" class="quesion_display">
						<div class="inner-container">
							<div class="card cardHome">
								<div class="content active" style="color: black; padding: 20px">
									<h3>{{ $test->title}} Quiz</h3>
									<h4>Min. No. of questions: {{ $test->no_of_questions }}</h4>
									<h4>Total Questions: {{ $questionsCount}}</h4>
									@if(!$test->permitted)
									{{ Form::open(array('url' => 'activateQuiz/'.$test->quizid, 'role' => 'form', 'class' => 'form-horizontal')) }}
									<button type="submit" id="activate-test-{{ $test->quizid }}" class="btn btn-sm btn-success">Activate Test</button>
									{{ Form::close() }}
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
	<!-- modal -->
	<div class="modal" id="AddQueModal">
		<div class="modal-dialog">
			{!! Form::open(array('url' => 'addQuestion/'.$test->quizid, 'name' => 'add-question', 'id' => 'add-question', 'role' => 'form')) !!}
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title">Add Question</h4>
					<button type="button" class="close" data-dismiss="modal">&times;</button>
				</div>
				<div class="modal-body">
					<div class="row" style="margin: 10px 0px">
						<div class="col-md-8">
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
										<div class="col-md-5">
											<textarea rows="3" cols="20" style="resize: none;" id="question-text" name="question-text" class="" form="add-question" placeholder="Enter Question..."></textarea>
										</div>
									</div>
								</div>
								<div class="box mcq">
									<div class="form-group">
										<div class="row">
											<div class="col-md-6">
												<label>Option 1: </label>
											</div>
											<div class="col-md-5">
												<input name="option1" type="text" class=""  id="option1" placeholder="Option 1" />
											</div>
										</div>
									</div>
									<div class="form-group">
										<div class="row">
											<div class="input-group form-group">
												<div class="col-md-6">
													<label>Option 2: </label>
												</div>
												<div class="col-md-5">
													<input name="option2" type="text" class=""  id="option2" placeholder="Option 2" />
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
												<div class="col-md-5">
													<input name="option3" type="text" class=""  id="option3" placeholder="Option 3" />
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
												<div class="col-md-5">
													<input name="option4" type="text" class=""  id="option4" placeholder="Option 4" />
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
									<div class="col-md-5">
										<input id="answer" type="text" class="" name="answer" placeholder="Answer">
									</div>
								</div>
							</div>
							<div class="form-group">
								<div class="row">
									<div class="col-md-6">
										<label for="time" class="control-label">Time:</label>
									</div>
									<div class="col-md-5">
										<input id="time" type="text" class="" name="question-duration" placeholder="in MM:SS format"/>
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
	$("document").ready(function(){
		setTimeout(function(){
			$("#message_id").remove();
		}, 2000 );
	});
</script>
@endsection
