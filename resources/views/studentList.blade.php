@extends('layouts.app')
@section('content')
    <script src=" {{ URL::to('https://www.google.com/recaptcha/api.js') }} "></script>

	<div class="page-min-height studentList_section"  style="background-color: rgb(69, 77, 102); padding-bottom: 35px;">
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
		<div class="col-lg-8 offset-lg-2">
					<button class="btn add_btn" data-toggle="modal" data-target="#AddStudent">Add <i class="fa fa-plus" style="color: #fff;"></i>
					</button>
				@if (count($student) > 0)				
				<table class="rwd-table" >
					<h5 style="color: #fff; margin-bottom: 35px;text-align: right;font-size: 24px; font-weight: 700">Students List</h5>
					<thead>
						<tr class="student_list">
							<th class="headergreen">Name</th>
							<th class="headergreen">Email</th>
							<th class="headergreen">Enroll No.</th>
							<th class="headergreen">Batch</th>
							<th class="headergreen">Year <select onclick="changeYear(this.value)" id="changeYear"><option>Select...</option><option value="1">1st Year</option><option value="2">2st Year</option></select></th>
							<th class="headergreen">Action</th>							
						</tr>
					</thead>
					<tbody id="studentList">
						@foreach($student as $students)
						<tr>
							<td data-th="Name">
								<?php echo $students['name']; ?>
							</td>
							<td data-th="Email" title="<?php echo $students['email']; ?>">
								<?php echo $students['email']; ?>
							</td>	
							<td data-th="Enrollment No">{{ $students['enroll_no'] }}</td>
							<td data-th="Batch">{{ $students['batch'] }}</td>
							<?php
							if($students['year'] == '1'){
								$year = $students['year'].'st year';
							}elseif($students['year'] == '2'){
								$year = $students['year'].'nd year';
							}else{
								$year = '';
							}
							?>
							<td data-th="Year">
								{{ $year }}
							</td>	
							<td data-th="Action">
								<a href="{{ route('deleteStudent',$students['id']) }}"><button style="border: none; background-color: #009975;color: #fff; cursor: pointer;border-radius: 5px;margin: 2px;">Delete</button></a>
								<a href="{{ route('userReport',$students['id']) }}"><button style="border: none; background-color: #009975;color: #fff; cursor: pointer;border-radius: 5px;margin: 2px;">Report</button></a>
							</td>
						</tr>
						@endforeach
					</tbody>
				</table>
				@else
				<h5 style="color: #fff; margin-bottom: 35px;text-align: center;font-size: 24px; font-weight: 700">No Student Registered!</h5>
				@endif
			
				<div class="lesson_pagination" style="margin-top: 35px; margin-bottom: 35px;"> 
					{{ $student->links() }}
				</div>
	<!-- add student model-->
	<div class="modal" id="AddStudent">
		<div class="modal-dialog">
			{{ Form::open(array('url' => 'createUser','method' => 'POST','role' => 'form', 'class' => 'form-horizontal')) }}
			<div class="modal-content">	
				<div class="modal-header">
					<h4 class="modal-title">Add Student</h4>
					<button type="button" class="close" data-dismiss="modal" style="color: inherit!important">&times;</button>
				</div>
				<div class="modal-body">
					<div class="row" style="margin: 10px 0px">
						<div class="col-md-8">
							<div class="filter-content" style="margin: 30px 0px">
								<div class="form-group">
									<div class="row">
										<div class="col-md-6 labelContent">
											<label for="question-type" class="control-label">Name</label>
										</div>
										<div class="col-md-6" >
											<input id="name" type="text" class="stud_detail" name="name" placeholder="Name">
											 @error('name')
							                <span class="invalid-feedback" role="alert">
							                    <strong>{{ $message }}</strong>
							                </span>
							                @enderror
										</div>	
									</div>
									<div class="row">
										<div class="col-md-6 labelContent">
											<label for="question-type" class="control-label">Email</label>
										</div>
										<div class="col-md-6" >
											<input id="email" type="text" class="stud_detail" name="email" placeholder="Email" autocomplete="off">
											@error('email')
							                <span class="invalid-feedback" role="alert">
							                    <strong>{{ $message }}</strong>
							                </span>
							                @enderror
										</div>	
									</div>
									<div class="row">
										<div class="col-md-6 labelContent">
											<label for="question-type" class="control-label">Password</label>
										</div>
										<div class="col-md-6" >
											<input id="password" type="password" class="stud_detail" name="password" placeholder="Password" autocomplete="off">
											@error('password')
							                <span class="invalid-feedback" role="alert">
							                    <strong>{{ $message }}</strong>
							                </span>
							                @enderror
										</div>	
									</div>
									<div class="row">
										<div class="col-md-6 labelContent">
											<label for="question-type" class="control-label">Confirm Password</label>
										</div>
										<div class="col-md-6" >
											<input id="password_confirmation" type="password" class="stud_detail" name="password_confirmation" placeholder="Confirm Password">
										</div>	
									</div>
									<input type="hidden" name="imA" id="imA" value="0">
									<div class="row">
										<div class="col-md-6 labelContent">
											<label for="question-type" class="control-label">Enrollment No.</label>
										</div>
										<div class="col-md-6" >
											<input id="eno" type="text" class="stud_detail" name="eno" placeholder="Enrollment No.">
										</div>	
									</div>
									<div class="row">
										<div class="col-md-6 labelContent">
											<label for="question-type" class="control-label">Batch</label>
										</div>
										<div class="col-md-6" >
											<input id="batch" type="text" class="stud_detail" name="batch" placeholder="Batch" onkeypress="return Validate(event);">
										</div>	
									</div>
									<div class="row">
										<div class="col-md-6 labelContent">
											<label for="question-type" class="control-label">Year</label>
										</div>
										<div class="col-md-6" >
											<select id="year" name="year"><option value="">Select</option><option value="1">1st year</option><option value="2">2nd year</option></select>
										</div>	
									</div>
								</div>
							</div>				
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn_cancel" data-dismiss="modal" style="width: 88px;">Close</button>
					<button type="submit" class="btn btn_quiz" id="activate">Save</button>
				</div>
			</div>
			{{ Form::close() }}
		</div>
	</div>
			</div>
    </div>
</div>

<script type="text/javascript">
	// allow to enter only numeric value
/*$("#batch").keypress(function (e) {
   if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
   return false;
  } 
});*/

 function Validate(event) {
        var regex = new RegExp("^[0-9-?]");
        var key = String.fromCharCode(event.charCode ? event.which : event.charCode);
        if (!regex.test(key)) {
            event.preventDefault();
            return false;
        }
    } 

@if (count($errors) > 0)
    $('#AddStudent').modal('show');
@endif
function changeYear(val){
	$('#studentList').html('');
	var Id = val; 	
	var ajax_url = 'getStudentList/'+Id;     
                $.ajax({                    
                    url: ajax_url,
                    type: "GET",                     
                    dataType: 'json',                                    
                    success: function (data) { 
                    	var setResult = JSON.stringify(data.result);
                    if(data.success = 'success'){
			               var trHTML = '';
					        $.each(data.result, function (index, v) {
					        	var action_button = '<a href="deleteStudent/'+v.id+'"><button style="border: none; background-color: #009975;color: #fff; cursor: pointer;border-radius: 5px;margin: 2px;">Delete</button></a>';
					        	action_button += '<a href="userReport/'+v.id+'"><button style="border: none; background-color: #009975;color: #fff; cursor: pointer;border-radius: 5px;margin: 2px;">Report</button></a>'
					             trHTML += 
					                '<tr><td>' + v.name + 
					                '</td><td>' + v.email + 
					                '</td><td>' + v.enroll_no + 
					                '</td><td>' + v.batch + 
					                '</td><td>' + v.year + 			               
					                '</td><td>' + action_button + 			               
					                '</td></tr>';     
					        });			         
			            $('#studentList').append(trHTML);
                  	}
                    }
                });

}
</script>
@endsection
