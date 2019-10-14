@extends('layouts.studentMaster')
@section('content')
<div class="page-min-height" style="background-color: #454d66">
	<section class="all_quiz_list" style="padding: 40px 0px 40px">
	
	{!! Form::open(array('id' => 'regForm','url' => 'createLession2/'.$id,'role' => 'form','enctype' => 'multipart/form-data','files' => true,)) !!}

	<!-- second step start -->
		<div class="tab breck_table">
			<div class="table-responsive all_details">  
				<div class="row">
					<div class="col-lg-6">
						<div class="table_line">
						<table class="table">
							<thead>
								<tr>
									<th>Steps</th>
									<th>Specific Objectives</th>
									<th>Teaching Points</th>				      
								</tr>
							</thead>
							<tbody>
								<tr>
									<td><textarea rows="47" cols="7" name="steps" class="frmsubmit" id="steps"></textarea></td>
									<td><textarea rows="47" name="specific_objectives" class="frmsubmit" maxlength="1500"></textarea></td>
									<td><textarea rows="47" cols="30" class="frmsubmit" name="teaching_points" maxlength="1500"></textarea></td>
								</tr>
							</tbody>
						</table>
						</div>	
					</div>

				<div class="col-lg-6 print_break">
					<div class="table_line">
						<table class="table">
							<thead>
								<tr>
									<th>Teacher's Activity</th>
									<th>Student's Activity</th>
									<th>Reference / Example</th>
								</tr>
							</thead>
							<tbody>
								<tr>				        
									<td rowspan="25"><textarea rows="35" cols="45" class="frmsubmit" name="teacher_activity" maxlength="1000"></textarea></td>
									<td rowspan="20" ><textarea rows="35" class="frmsubmit" cols="45" name="student_activity" maxlength=" 1200"></textarea></td>
									<td><textarea rows="10" name="reference_manual" class="frmsubmit"  maxlength="80" style="overflow-y: scroll;"></textarea>
									</td>
								</tr>
									<tr>
										<td>
										<input type="file" class="frmsubmit" name="reference[]" id="reference" multiple style="overflow-y: scroll;">			
									</td>
								</tr>
								<tr>
									<th>Details of Evaluation</th>
								</tr>
								<tr>
									<td><textarea rows="12" name="evaluation" class="frmsubmit" maxlength="100"></textarea></td>	
								</tr>
							</tbody>
						</table>	
					</div>
				</div>
				</div>
			</div>
			<div>
			<div style="float:right;">
				<a href="{{route('editLession',$id)}}"><button type="button">Previous</button></a>
				<button type="submit">Next</button>				
			</div>
		</div> 	
		</div>
		<!-- second step end -->
	{!! Form::close() !!}
	</section>
</div>
<script type="text/javascript">
	// allow to enter only numeric value
$("#steps").keypress(function (e) {
   if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
   return false;
  } 
});	

$('.frmsubmit').keyup(function(e) {
 	 var data = $("form").serialize();
 	 var Id = '<?php echo $id; ?>';
      $.ajax({
        url: 'createLession2/'+Id,
        data: data,
        dataType:'json',
        type:'POST',       
        success: function(data) {
        	$('#lesId').val(data.id);
         
        }
         });
 });
</script>
@endsection
