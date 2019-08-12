@extends('layouts.app')

@section('content')
<div class="page-min-height" style="background-color: #454d66">
    <div class="container">
        <section class="all_quiz_list" style="padding: 40px 0px 16px">
            <div class="container">
                <div class="section_title" align="center" data-aos="flip-up" data-aos-duration="1000">
                    <p id="list_p">Quizzes Appeared</p>
                    <p>By You</p>
                </div>
                <div class="row">
                   @foreach ($quizAppeared as $index=>$qAppeared)
                   <div class="col-lg-4 col-md-6 mb-4">
                    <div class="inner-container">
                        <div class="card cardHome">
                            <div class="content active">
                                <h5>{{ $qAppeared->title}} Quiz</h5>
                                <h5 style="margin: 10px 0px;">Correct: {{ $qAppeared->marks_scored * 100 / $qAppeared->total_questions}}%</h5>
                                <h5 style="margin: 10px 0px;">Date: {{ Carbon\Carbon::parse($qAppeared->created_at)->format('d-m-Y') }} at {{ Carbon\Carbon::parse($qAppeared->created_at)->format('G:i:s') }}</h5>
                                <a href="/viewSigleResult/{{ $qAppeared->quizappearid }}"><button type="submit" style="border: none; background-color: #009975; red;color: #fff; cursor: pointer;border-radius: 5px;">View Details</button></a>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>
</div>
<div class="offset-md-5" style="padding-bottom: 10px"> 
    {{ $quizAppeared->links() }}
</div>
</div>
@endsection
