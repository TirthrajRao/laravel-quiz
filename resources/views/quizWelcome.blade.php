@extends('layouts.app')

@section('title')
<title>{{ $test->title }}</title>
@endsection

<style type="text/css">
	.box {
		display: none;
		/*   opacity: 0; */
	}
</style>

@section('body')
<body>
	@endsection
	@section('content')
	<div class="page-min-height" style="background-color: rgb(69, 77, 102)">
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

		<div class="container">
			@include('errors.common')
			<!-- Test Details -->
			<div class="row" style="margin: 30px 0px">
				<div class="col-md-8 offset-md-2">
					<h3 style="; color: white; font-size: 30px; font-weight: 600"> {{ $test->title }} Quiz</h3>
				</div>
			</div>
		</div>

		<div class="container">
			<div class="row"></div>
			<div class="col-sm-8 col-md-8 alert alert-danger offset-md-2">
				<strong>Important Guidelines. Read carefully before proceeding.</strong><br>
				<ul style="list-style: none;">
					<li><i class="fas fa-hand-point-right"></i> Once you start your quiz by clicking on <strong>Begin Quiz</strong>, remember that:</li>
						<li><i class="fas fa-hand-point-right"></i>  A timer will start.</li>
						<li><i class="fas fa-hand-point-right"></i>  You <strong>must</strong> submit your answers before it expires, otherwise your responses may not be received and evaluated in time. Also once you press next button you cannot go to previous question again.</li>
						<li><i class="fas fa-hand-point-right"></i>  Also you cannot refresh your screen, close your browser or in any way navigate away from the quiz page. If any of these actions occur, remember that your quiz will automatically be forfeited and your score will get reduced!</li>
					<li><i class="fas fa-hand-point-right"></i>  <strong>Important: </strong> Once the quiz ends, <strong>do not close your window</strong>. Your score will be displayed.</li>
				</ul>
			</div>
			<div class="row">
				<div class="col-sm-8 col-md-8 alert offset-md-2">
					<a href="/takeQuiz/{{ $test->quizid }}" class="btn btn_quiz float-right">Begin Quiz >>>
						
					</a>	
				</div>
			</div>
		</div>
	</div>
	@endsection
