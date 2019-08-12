@extends('layouts.app')

@section('custom-meta-tags')
<meta http-equiv="refresh" content="310;url=/" />
@endsection
<!-- <link rel="stylesheet" type="text/css" href="{{asset('multi/css/multiform.css')}}"> -->
@section('title')
<title>Quiz</title>
@endsection

@section('custom-scripts')
<script>


    function str_pad_left(string,pad,length) {
        return (new Array(length+1).join(pad)+string).slice(-length);
    }

    function startTimer(){
        var count;
        var timer = setInterval(function() {
            var div = document.querySelector("#counter");
            var queDur = document.querySelector("#queDuration").value;
            var hidden_div = document.querySelector("#hidden");
            count = count != undefined ? count * 1 -1 : hidden_div.textContent * 1 - 1;
            var minutes = Math.floor(count / 60);
            var seconds = count - minutes * 60;
            var finalTime = str_pad_left(minutes,'0',2)+':'+str_pad_left(seconds,'0',2);
            div.textContent = finalTime;
            document.getElementById("queDuration").value = finalTime;
            queDur = finalTime;
            console.log(queDur);
            if (count == 0 && document.querySelector(".next")) {
                clearInterval(timer);
                document.querySelector(".next").click();
            }else if(count == 0){
                console.log("Submit");
                clearInterval(timer);
                document.quiz.submit();
            }
        }, 1000);
    }

    jQuery(document).ready(function($) {
        startTimer();
        window.history.pushState(null, "", window.location.href);        
        window.onpopstate = function() {
            window.history.pushState(null, "", window.location.href);
        };
        $('.next').on('click', ()=>{
            startTimer();
        })
    });
</script>

@endsection


@section('content')
<div class="page-min-height appearQuiz"  style="background-color: rgb(69, 77, 102)">
    <?php 
    if(isset($_GET['page']))
      $page = $_GET['page']; 
  else
      $page=1;
  ?>

  <h3 style="color: #fff;text-align: center;font-size: 24px;font-weight: 700">{{ $quiz->title}} Quiz</h3>
  @foreach($questions as $iteration=>$question)
    <div class="main">
        @if ( $questions-> hasMorePages())
        {{ Form::open(array('url' => 'nextClick', 'role' => 'form', 'name' => 'quiz', 'class' => 'form-horizontal', 'id' => 'myForm')) }}
        @else
        {{ Form::open(array('url' => 'finishQuiz', 'role' => 'form', 'name' => 'quiz', 'class' => 'form-horizontal', 'id' => 'myForm')) }}
        @endif
        <h6 style="color: #fff">Time Left: <span id="counter" style="color: #009975; font-weight: 800 "></span></h6>
        <input name="page" type="hidden" value="{{ $page}}">
        <div id="hidden" hidden="hidden">  <input type="" name="queDuration" id="queDuration" value="{{$question->question_duration}}">{{$question->question_duration}}</div>
        <input type="hidden" name="question_id[{{ $question->questionid }}]" value="{{$question->questionid}}">


        <div class="quiz-question"><h4 style="margin-bottom: 15px;">Question {{$page}} : {{ $question->question }}</h4></div>
        <div style="margin-bottom: 15px;"> 
            @if($question->question_type == 'mcq')
            <input class="type_1" type="radio" name="answer[{{ $question->questionid }}]" id="mc_c{{ $question->option_1 }}" value="{{ $question->option_1}}"> <label for="">{{ $question->option_1}}</label> <br>
            <input class="type_1" type="radio" name="answer[{{ $question->questionid }}]" id="mc_c{{ $question->option_2 }}" value="{{ $question->option_2}}"> <label for=""> {{ $question->option_2}} </label><br>
            <input class="type_1" type="radio" name="answer[{{ $question->questionid }}]" id="mc_c{{ $question->option_3 }}" value="{{ $question->option_3}}"> <label for=""> {{ $question->option_3}} </label><br>
            <input class="type_1" type="radio" name="answer[{{ $question->questionid }}]" id="mc_c{{ $question->option_4 }}" value="{{ $question->option_4}}"> <label for=""> {{ $question->option_4}} </label><br>
            @elseif($question->question_type == 'fib')

            <div>
                <h4>Answer:
                    <input  type="text" name="answer[{{ $question->questionid }}]">
                </h4>
            </div>
            @else

            <h4><strong>Answer:</strong>

                <select name="answer[{{ $question->questionid }}]">
                    <option value="">Select</option>
                    <option value="1">True</option>
                    <option value="0">False</option>
                </select>
            </h4>        
            @endif
        </div>
        <input type="hidden" name="quiz-id" id="test-id" value="{{ $quiz->quizid }}">
        <input type="hidden" name="user-id" id="student-id" value="{{ Auth::user()->id }}">
        <p>{{ $questions->links('vendor.pagination.simple-default') }}</p>
        {{ Form::close() }}
        {{ Form::close() }}
    </div>
</div>

  <!-- <div class="container">
    <div class="quiz" style="border: none;">
        <div class="section_title" align="center" data-aos="flip-up" data-aos-duration="1000">
            <p style="color: #fff">{{ $quiz->title}} Quiz</p>
        </div>
        <h6>Time Left: <span id="counter" style="color: #009975"></span></h6>
        <div class="quiz-question">Question {{$page}}: {{ $question->question }}</div>

        @if($question->question_type == 'mcq')
        <label class="quiz-answer">
            <input type="radio" name="answer[{{ $question->questionid }}]" id="mc_c{{ $question->option_1 }}" value="{{ $question->option_1}}">
            <div class="highlight"></div>
            <div class="circle"></div>
            <p>{{ $question->option_1}}</p>
        </label>

        <label class="quiz-answer">
            <input type="radio" name="answer[{{ $question->questionid }}]" id="mc_c{{ $question->option_2 }}" value="{{ $question->option_2}}">
            <div class="highlight"></div>
            <div class="circle"></div>
            <p>{{ $question->option_2}}</p>
        </label>

        <label class="quiz-answer">
            <input type="radio" name="answer[{{ $question->questionid }}]" id="mc_c{{ $question->option_3 }}" value="{{ $question->option_3}}">
            <div class="highlight"></div>
            <div class="circle"></div>
            <p>{{ $question->option_3}}</p>
        </label>

        <label class="quiz-answer">
            <input type="radio" name="answer[{{ $question->questionid }}]" id="mc_c{{ $question->option_4 }}" value="{{ $question->option_4}}">
            <div class="highlight"></div>
            <div class="circle"></div>
            <p>{{ $question->option_4}}</p>
        </label>
        @elseif($question->question_type == 'fib')

        <div class="form-group">
            <p><strong>Answer:</strong></p>
            <input  type="text" name="answer[{{ $question->questionid }}]">
        </div>
        @else

        <strong>Answer:</strong>

        <select name="answer[{{ $question->questionid }}]">
            <option value="">Select</option>
            <option value="1">True</option>
            <option value="0">False</option>
        </select>        
        @endif
        <input type="hidden" name="quiz-id" id="test-id" value="{{ $quiz->quizid }}">
        <input type="hidden" name="user-id" id="student-id" value="{{ Auth::user()->id }}">
        <div style="float:right; margin: 10px">
            <p>{{ $questions->links('vendor.pagination.simple-default') }}</p>
        </div>
    </div> -->
    <!-- </div> -->
    
    @endforeach
</div>
@endsection