@extends('layouts.app')
@section('content')
@include('layouts.lessonPlanCss')

<div class="page-min-height" style="background-color: #454d66">
	<section class="all_quiz_list" style="padding: 40px 0px 16px">	
	{!! Form::open(array('id' => 'regForm','method' => 'get','url' => 'viewLession2/'.$lession_result->id.'/'.$user->id,'role' => 'form','enctype' => 'multipart/form-data','files' => true,)) !!}
	<input type="hidden" name="lesId" id="lesId">
		<!-- One "tab" for each step in the form: -->
		<div class="tab">
			<!-- form heading -->
			<div class="form_head">
				<img src="{{ URL::to('images/logo.png') }}" alt="Site Logo">
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
				<input type="text" name="lesson_no" class="frmsubmit" value="{{$lession_result->lession_no}}" readonly="">			
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
								<input oninput="this.className = ''" name="school_name" value="{{$lession_result->school_name}}" class="frmsubmit" readonly="">
							</div>
						</div>

						<div class="col-md-4 mt-2">
							<div class="merge">
								<span>STD </span> 
								<select  name="standard" onchange="saveDraft();" disabled="">
									<option value="6" {{$lession_result->standard == '6' ? ' selected="selected"' : ''}}>6</option>
									<option value="7" {{$lession_result->standard == '7' ? ' selected="selected"' : ''}}>7</option>
									<option value="8" {{$lession_result->standard == '8' ? ' selected="selected"' : ''}}>8</option>
									<option value="9" {{$lession_result->standard == '9' ? ' selected="selected"' : ''}}>9</option>
								</select>
							</div>
						</div>

						<div class="col-md-4 mt-2">
							<div class="merge">
								<span>SUBJECT </span>
								<select name="subject" onchange="saveDraft();" disabled="">
									<option value="english" {{$lession_result->subject == 'english' ? ' selected="selected"' : ''}}>English</option>
									<option value="gujrati" {{$lession_result->subject == 'gujrati' ? ' selected="selected"' : ''}}>Gujrati</option>
									<option value="s.s" {{$lession_result->subject == 's.s' ? ' selected="selected"' : ''}}>S.S.</option>
									<option value="sanskrit" {{$lession_result->subject == 'sanskrit' ? ' selected="selected"' : ''}}>Sanskrit</option>
									<option value="maths" {{$lession_result->subject == 'maths' ? ' selected="selected"' : ''}}>Maths</option>
									<option value="science" {{$lession_result->subject == 'science' ? ' selected="selected"' : ''}}>Science</option>
									<option value="hindi" {{$lession_result->subject == 'hindi' ? ' selected="selected"' : ''}}>Hindi</option>
								</select>
							</div>
						</div>

						<div class="col-md-4 mt-2">
							<div class="merge">
								<span>TOPIC </span>
								<input oninput="this.className = ''" name="topic" value="{{$lession_result->topic}}" class="frmsubmit" readonly="">
							</div>
						</div>

						<div class="col-md-4 mt-2">
							<div class="merge">
								<span>DATE </span>
								<input id="datepicker1" name="datepicker1" value="{{$lession_result->date_lession}}" autocomplete="off" onchange="saveDraft();" disabled="">
							</div>
						</div>

						<div class="col-md-4 mt-2">
							<div class="merge">
								<span class="period_no">PERIOD NO.</span>
								<input oninput="this.className = ''" class="time frmsubmit" name="period_no" value="{{$lession_result->period_no}}" readonly="">
							</div>
						</div>

						<div class="col-md-4 mt-2">
							<div class="merge">
								<span>TIME </span>
								<input oninput="this.className = ''" onchange="saveDraft();" class="timepicker time frmsubmit" name="time" value="{{$lession_result->time}}" autocomplete="off" disabled="">
							</div>
						</div>

						<div class="col-md-4 mt-2">
							<div class="merge">
								<span>TO </span>
								<input oninput="this.className = ''" onchange="saveDraft();" class="timepicker time frmsubmit" name="time_to" value="{{$lession_result->time_to}}" autocomplete="off" disabled="">
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
						<textarea rows="17" name="general_objectives" maxlength="700" class="frmsubmit" readonly="">{{$lession_result->general_objectives}}</textarea>
					</div>
				</div>

				<div class="col-md-4 technic">
					<div class="technics_head text-center">
						<h6>Approach Technique</h6>
					</div>
					<div class="general_detail">
						<textarea rows="11" class="tech_details frmsubmit" name="approach_technique" maxlength="200" readonly="">{{$lession_result->approach_technique}}</textarea>
					</div>
					<div class="aids_head text-center">
						<h6>Teaching Aids</h6>
					</div>
					<div class="general_detail">
						<textarea rows="13" class="tech_details frmsubmit" name="teaching_aids" maxlength="140" readonly="">{{$lession_result->teaching_aids}}</textarea>
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
							<td><input oninput="this.className = ''" name="text_book" maxlength="50" value="{{$lession_result->text_book}}" class="frmsubmit" readonly=""></td>
							<td><textarea rows="1" cols="2" name="author_book" class="frmsubmit" maxlength="10" readonly="">{{$lession_result->author_book}}</textarea></td>
							<td><textarea rows="1" cols="1" name="page_textbook" class="frmsubmit" id="page_textbook" maxlength="5" readonly="">{{$lession_result->pageno_textbook}}</textarea></td>
						</tr>
						<tr>
							<td>Refernce Book</td>
							<td><textarea rows="4" name="refernce_books" class="frmsubmit" maxlength="120" readonly="">{{$lession_result->refernce_books}}</textarea></td>
							<td><textarea rows="4" cols="2" name="author_ref_book"maxlength="30" class="frmsubmit" readonly="">{{$lession_result->author_ref_book}}</textarea></td>
							<td><textarea rows="4" cols="1" class="frmsubmit" name="page_refbook" id="page_refbook" maxlength="5" readonly="">{{$lession_result->pageno_refbook}}</textarea></td>
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

		<!-- Circles which indicates the steps of the form: -->
		<div style="text-align:center;margin-top:40px;">
			<span class="step"></span>
			<span class="step"></span>
			<span class="step"></span>
		</div>
	</section>
</div>
<script type="text/javascript">
	 // allow to enter only numeric value
$("#page_textbook , #page_refbook").keypress(function (e) {
   if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
   return false;
  } 
});

$('.frmsubmit').keyup(function(e) {
 	 var data = $("form").serialize();
 	 var Id = '<?php echo $lession_result->id; ?>';
      $.ajax({
        url: '/createLessionajax/'+Id,
        data: data,
        dataType:'json',
        type:'POST',       
        success: function(data) {
        	$('#lesId').val(data.id);
         
        }
         });
 });
function saveDraft(){
var data = $("form").serialize();
 	 var Id = '<?php echo $lession_result->id; ?>';
      $.ajax({
        url: '/createLessionajax/'+Id,
        data: data,
        dataType:'json',
        type:'POST',       
        success: function(data) {
        	$('#lesId').val(data.id);
         
        }
    });
 }
</script>
@endsection
