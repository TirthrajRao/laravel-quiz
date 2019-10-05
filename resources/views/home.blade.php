@extends('layouts.app')

@section('content')
<div class="page-min-height" style="background-color: #343F4A">
    <section class="how_it_work_section">
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
            <div class="section_title" align="center" data-aos="flip-up" data-aos-duration="1000">
                <p>Simple Steps</p>
                <h3>How It Works</h3>
            </div>
            <div class="row">
                <div class="col-lg-4" data-aos="flip-left" data-aos-duration="1000">
                    <div class="how_it_work_content border_right">
                        <i class="fa fa-plus-square"></i>
                        <!-- <h5>Create Quiz</h5> -->
                        <p>Create Quiz by just adding Title and Minimum no. of Questions. Minimum Question for the Quiz is 2. You can add any number of Questions greater than or equal to 2.</p>
                    </div>
                </div>
                <div class="col-lg-4" data-aos="flip-left" data-aos-duration="1000">
                    <div class="how_it_work_content border_right">
                        <i class="fa fa-cart-plus"></i>
                        <!-- <h5>Add Questions</h5> -->
                        <p>Add Questions to the Quiz. Questions can be of 3 types; Multiple Choices, Fill in the blanks and True or Flase. You can add any number of Questions to your Quiz.</p>
                    </div>
                </div>
                <div class="col-lg-4" data-aos="flip-left" data-aos-duration="1000">
                    <div class="how_it_work_content">
                        <i class="fa fa-unlock"></i>
                        <!-- <h5>Activate Quiz</h5> -->
                        <p>After adding minimum no. of Questions you can Activate the Quiz so that other users can appear your Quiz. Hurrayyyyy! You are done!.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    
</div>

@endsection
