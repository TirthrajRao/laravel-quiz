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
											<input type="number" min="2" value="2" name="num-questions"
											onblur="this.value = 2">
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
								<button type="submit" id="delete-user-{{ $QuizByMe->quizid }}" style="border: none; background-color: red;color: #fff; cursor: pointer;border-radius: 5px;">Delete</button>
								{{ Form::close() }}
							</td>
						</tr>
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
			$("div.alert").fadeOut(600, function() { $(this).remove(); });
		}, 1000 );
	});
</script>
@endsection

