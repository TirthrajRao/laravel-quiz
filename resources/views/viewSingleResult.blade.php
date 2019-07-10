@extends('layouts.app')
{!! Charts::styles() !!}
@section('content')
<div class="page-min-height" style="background-color: rgb(69, 77, 102);overflow-x: hidden;">
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

	<div class="container">
		@include('errors.common')
		<div class="row" style="margin: 30px 0px 0px 0px">
			<div class="col-md-6" style="margin-bottom: 35px;">
				<div class="card" style="background-color: #343F4A;">
					<article class="card-group-item">
						<div class="container" style="margin: 20px 0px; color: #fff"> 
							@foreach($question as $index=>$quest)
							@if($index == 0)
							<h4 style="margin: 10px 0px"> {{$quest->title}} Quiz Result: {{$countTrue}} / {{$totalQuestion}} <a href="/quizLeaderboard/{{ $quest->quizid }}" class="btn btn_quiz" style="float: right;">View Leaderboard</a></h4>
							<h6>Given on {{ Carbon\Carbon::parse($quest->created_at)->format('d-m-Y') }} at {{ Carbon\Carbon::parse($quest->created_at)->format('G:i:s') }}</h6>
							@endif 
							@endforeach
						</div>
						@if (count($question) > 0)
						@foreach($question as $index=>$quest)
						<div class="filter-content" style="margin: 30px 0px;">
							@if($quest->correct == 1)
							<div class="list-group-item" style="margin: 10px; background: #dbffbc">
								@else						
								<div class="list-group-item" style="margin: 10px; background: #eac2c2">
									@endif
									<div class="row">
										<div class="col-md-6">
											<p><strong>Question {{$index += 1}}:</strong> {{ $quest->question }}</p>
										</div>
									</div>
									@if( $quest->question_type == 'mcq')
									<p><strong>Question Type: </strong>MCQ</p>
									@endif
									@if( $quest->question_type == 'tf')
									<p><strong>Question Type: </strong>True or False</p>
									@endif
									@if( $quest->question_type == 'fib')
									<p><strong>Question Type: </strong>Fill in the Blanks</p>
									@endif
									@if( $quest->question_type == 'mcq')
									<strong>Choices:</strong>
									<ul>
										<li>
											<p>A) {{ $quest->option_1 }}</p>
										</li>
										<li>
											<p>B) {{ $quest->option_2 }}</p>
										</li>
										<li>
											<p>C) {{ $quest->option_3 }}</p>
										</li>
										<li>
											<p>D) {{ $quest->option_4 }}</p>
										</li>
									</ul>
									@endif
									@if($quest->question_type == 'tf')
									@if($quest->answer == 1)
									<p><strong>Correct Answer: </strong>True</p>
									@else
									<p><strong>Correct Answer: </strong>False</p>
									@endif
									@else
									<p><strong>Correct Answer: </strong>{{ $quest->answer }}</p>
									@endif
									<p><strong>You Answered: </strong>
										@if($quest->user_response == 1)
										True	
										@elseif($quest->user_response == 0)
										False
										@else
										{{$quest->user_response}}
										@endif
									</p>
									<p><strong>Time:</strong> {{ $quest->question_duration }} sec</p>
									<p><strong>Time taken by You:</strong> {{ $quest->time_taken }} sec</p>
								</div>
							</div>
							@endforeach
							@endif
						</article>
					</div>
				</div>
				<div class="col-md-6" style="margin-bottom: 35px;">
					<center>
						{!! $chart->html() !!}
					</center>
				</div>
			</div> 
		</div>
	</div>
	{!! Charts::scripts() !!}
	{!! $chart->script() !!}
	<script type="text/javascript">
		$("document").ready(function(){
			setTimeout(function(){
				$("#message_id").remove();
			}, 2000 );
		});
	</script>
	@endsection