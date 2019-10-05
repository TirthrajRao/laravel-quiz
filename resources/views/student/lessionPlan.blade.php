@extends('layouts.studentMaster')
@section('content')
<div class="page-min-height" style="background-color: #454d66">
	<section class="all_quiz_list" style="padding: 40px 0px 16px">
	
	{!! Form::open(array('id' => 'regForm','url' => 'createLession','role' => 'form','enctype' => 'multipart/form-data','files' => true,)) !!}

		<!-- One "tab" for each step in the form: -->
		<div class="tab">
			<!-- form heading -->
			<div class="form_head">
				<img src="images/logo.png">
				<h6>INSTITUTE OF LANGUAGE TEACHING</h6>
				<P>(English Medium) B.Ed. College - Rajkot</P>
			</div>

			<!-- subhead -->
			<div class="sub_head text-center m-3">
				<span>LESSON PLANNING</span>
			</div>

			<!-- form_no -->
			<div class="no">
				<label>TRAINEE'S ROLL NO.</label>
				<input type="text" value="{{$user->enroll_no}}" disabled="">
			</div>
			<div class="no">
				<label>LESSON NO.</label>
				<input type="text" name="lesson_no" id="lesson_no" required="">				
			</div>

			<!-- detailstable -->
			<div class="table-responsive-xl basic_detail">  
				<div class="table3">
					<div class="row">
						<div class="col-md-12 mt-2">
							<div class="merge">
								<span class="name">TRAINEE NAME </span>
								<input oninput="this.className = ''" type="text" value="{{$user->name}}" disabled="">		                		
							</div>
						</div>

						<div class="col-md-8 mt-2">
							<div class="merge">
								<span class="name">SCHOOL NAME</span>
								<input oninput="this.className = ''" name="school_name">
							</div>
						</div>

						<div class="col-md-4 mt-2">
							<div class="merge">
								<span>STD </span> 
								<select  name="standard">
									<option value="6">6</option>
									<option value="7">7</option>
									<option value="8">8</option>
									<option value="9">9</option>
								</select>
							</div>
						</div>

						<div class="col-md-4 mt-2">
							<div class="merge">
								<span>SUBJECT </span>
								<select name="subject">
									<option value="english">English</option>
									<option value="gujrati">Gujrati</option>
									<option value="s.s">S.S.</option>
									<option value="sanskrit">Sanskrit</option>
									<option value="maths">Maths</option>
									<option value="science">Science</option>
									<option value="hindi">Hindi</option>
								</select>
							</div>
						</div>

						<div class="col-md-4 mt-2">
							<div class="merge">
								<span>TOPIC </span>
								<input oninput="this.className = ''" name="topic" required="">
							</div>
						</div>

						<div class="col-md-4 mt-2">
							<div class="merge">
								<span>DATE </span>
								<input id="datepicker1" name="datepicker1" autocomplete="off">
							</div>
						</div>

						<div class="col-md-4 mt-2">
							<div class="merge">
								<span class="period_no">PERIOD NO.</span>
								<input oninput="this.className = ''" class="time" name="period_no" id="period_no">
							</div>
						</div>

						<div class="col-md-4 mt-2">
							<div class="merge">
								<span>TIME </span>
								<input oninput="this.className = ''" class="timepicker time " name="time" autocomplete="off">
							</div>
						</div>

						<div class="col-md-4 mt-2">
							<div class="merge">
								<span>TO </span>
								<input oninput="this.className = ''" class="timepicker time" name="time_to" autocomplete="off">
							</div>
						</div>
					</div>
				</div>
			</div>  

			<!-- general details -->
			<div class="row">
				<div class="col-md-8 general">
					<div class="general_heading text-center">
						<h6>General Objectives</h6>
					</div>
					<div class="general_detail">
						<textarea rows="17" name="general_objectives" maxlength="700"></textarea>
					</div>
				</div>

				<div class="col-md-4 technic">
					<div class="technics_head text-center">
						<h6>Approach Technique</h6>
					</div>
					<div class="general_detail">
						<textarea rows="11" class="tech_details" name="approach_technique" maxlength="150"></textarea>
					</div>
					<div class="aids_head text-center">
						<h6>Teaching Aids</h6>
					</div>
					<div class="general_detail">
						<textarea rows="13" class="tech_details" name="teaching_aids" maxlength="140"></textarea>
					</div>
					
				</div>
			</div>

			<!-- books refernce details -->
			<div class="table-responsive">          
				<table class="table">
					<thead>
						<tr>
							<th>Supportive Materials</th>
							<th>Name of the Book</th>
							<th>Author / Editor</th>
							<th>Page<br/> No.</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td>Text Book</td>
							<td><input oninput="this.className = ''" name="text_book" maxlength="50"></td>
							<td><textarea rows="1" cols="2" name="author_book" maxlength="10"></textarea></td>
							<td><textarea rows="1" cols="1" name="page_textbook" id="page_textbook" maxlength="5"></textarea></td>
						</tr>
						<tr>
							<td>Refernce Book</td>
							<td><textarea rows="4" name="refernce_books" maxlength="120"></textarea></td>
							<td><textarea rows="4" cols="2" name="author_ref_book" maxlength="30"></textarea></td>
							<td><textarea rows="4" cols="1" name="page_refbook" id="page_refbook" maxlength="5"></textarea></td>
						</tr>
					</tbody>
				</table>
			</div>
			<div>
			<div style="float:right;">
				<button type="submit">Next</button>
			</div>
		</div>

		</div>
	{!! Form::close() !!}

		<!-- next-prev button -->
		<!-- <div>
			<div style="float:right;">
				<button type="button" id="prevBtn" onclick="nextPrev(-1)">Previous</button>
				<button type="button" id="nextBtn" onclick="nextPrev(1)">Next</button>
			</div>
		</div> -->

		<!-- Circles which indicates the steps of the form: -->
		<div style="text-align:center;margin-top:40px;">
			<span class="step"></span>
			<span class="step"></span>
			<span class="step"></span>
		</div>
	</section>
</div>
<script type="text/javascript">
 /*$( "#add_multifile" ).click(function() {
 	$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
	});
 	var ajax_url = 'addReference'; 
 	//var reference =  $('input[name=reference]').val();
    var extension = $('#reference').val().split('.').pop().toLowerCase();
    var file_data = $('#reference').prop('files')[0];

    var form_data = new FormData();
       $.ajax({                    
            url: ajax_url,
            type: "get", 
            data: form_data,
	        enctype: 'multipart/form-data',
            crossDomain: true,
            async:false,
            processData: false,
            contentType: false,
            dataType: 'json',                    
            success: function (data) { 
             alert("success");
            }
        }); 
   }); */
 // allow to enter only numeric value
$("#page_textbook , #page_refbook , #lesson_no , #period_no").keypress(function (e) {
   if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
   return false;
  } 
});

</script>
@endsection
