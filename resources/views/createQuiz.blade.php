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
			<div class="col-md-6">
				<h5 style="color: #fff; margin-bottom: 35px;text-align: center;font-size: 24px;font-weight: 700">Create Quiz</h5>
				<div class="card createQuiz">
					<article class="card-group-item">
						<div class="container" style="margin-top: 10px">
						</div>
						<div class="filter-content">
							<div class="card-body">
								{{ Form::open(array('url' => 'createQuiz', 'role' => 'form', 'class' => 'form-horizontal')) }}
								<div class="form-group {{ $errors->has('quiz-title') ? 'has-error' : ''}}">
									<div class="row">
										<div class="col-md-6">
											<label for="test-title" class=" control-label">Quiz Title</label>
										</div>
										<div class="col-md-6">
											<input id="test-title" placeholder="Quiz Title" type="text" onfocus="this.placeholder = ''"
											onblur="this.placeholder = 'Quiz Title'" name="quiz-title" required="required" value="{{old('quiz-title')}}">
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
											<input type="number" min="2" value="2"  name="num-questions"
											>
										</div>
									</div>
								</div>
								<div class="form-group ">
									<br/>
									<button type="submit" class="btn btn_quiz">Create Quiz</button>
								</div>
								{{ Form::close() }}
							</div> 
						</div>
					</article>
				</div>
			</div>
			<div class="col-md-6">
				@if (count($testsByMe) > 0)
				<table class="rwd-table">
					<h5 style="color: #fff; margin-bottom: 35px;text-align: center;font-size: 24px; font-weight: 700">My Quizzes</h5>
					<tbody>
						<tr>
							<th>Quiz Title</th>
							<th>Created At</th>
							<th>Published Status</th>
							<th>View Details</th>
							<th>Action</th>
						</tr>
						@foreach($testsByMe as $QuizByMe)
						<tr>
							<td data-th="Quiz Title">
								{{ $QuizByMe->title }}
							</td>
							<td data-th="Created At">
								{{ $QuizByMe->created_at->toDateString() }}
							</td>
							<td data-th="Published Status">
								@if($QuizByMe->permitted)
								Yes
								@else
								No
								@endif
							</td>
							<td data-th="View Details">
								<a href="/viewQuiz/{{ $QuizByMe->quizid }}"><button style="border: none; background-color: #009975;color: #fff; cursor: pointer;border-radius: 5px;">Click</button></a>
							</td>
							<td data-th="Action">
								{{ Form::open(array('url' => 'deleteQuiz/'.$QuizByMe->quizid, 'role' => 'form', 'method' => 'delete')) }}
								<button type="submit" id="delete-user-{{ $QuizByMe->quizid }}" style="border: none; background-color: red;color: #fff; cursor: pointer;border-radius: 5px; margin: 1px;">Delete</button>
								{{ Form::close() }}

								<a href="JavaScript:Void(0)"  data-toggle="modal" data-target="#AddQueModal" class="editquiz" id="{{$QuizByMe->quizid}}"><button style="border: none; background-color: #009975;color: #fff; cursor: pointer;border-radius: 5px; margin: 1px;">Edit</button></a>
							</td>
						</tr>
						<div class="modal" id="AddQueModal">
		<div class="modal-dialog">
			{!! Form::open(array('url' => 'updateQuiz','role' => 'form')) !!}

			<input type="hidden"  name="quizEditId" id="quizEditId"
											 value="">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title">Edit Quiz</h4>
					<button type="button" class="close" data-dismiss="modal" style="color: inherit!important">&times;</button>
				</div>
				<div class="modal-body">
					<div class="row" style="margin: 10px 0px">
						<div class="col-md-8">
							<div class="filter-content" style="margin: 30px 0px">								
								<div class="form-group">
									<div class="row">
										<div class="col-md-6">
											<label for="question-text" class=" control-label">Question</label>
										</div>
										<div class="col-md-5">
											
										<input type="text"  name="quiz-title" id="quiz-title"
											required="" value="{{ $QuizByMe->title }}">


				@error('quiz-title')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
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
											<input type="number" min="2" value="2" id="num-questions" name="num-questions"
											required="">
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
					</tbody>
				</table>
				@else
				<h5 style="color: #fff; margin-bottom: 35px;text-align: center;font-size: 24px; font-weight: 700">No Quizzes added!</h5>
				@endif
				<div class="offset-md-4" style="margin-top: 35px;"> 
					{{ $testsByMe->links() }}
				</div>
			</div>
		</div> 
	</div>
</div>

<script type="text/javascript">
	$("document").ready(function(){
		setTimeout(function(){
			$("#message_id").remove();
		}, 1000 );
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
                       $('#quiz-title').val(data.data.title);
                       $('#num-questions').val(data.data.no_of_questions);
					   $('#quizEditId').val(data.data.quizid);
                    }
                });
    });
</script>
@endsection

