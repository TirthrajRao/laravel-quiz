@extends('layouts.app')
@section('content')
@include('layouts.lessonPlanCss')

<div class="page-min-height" style="background-color: #454d66">
	<section class="all_quiz_list" style="padding: 40px 0px 40px">
	
	{!! Form::open(array('id' => 'regForm','url' => 'viewLession3/'.$lession_result->id.'/'.$uid,'role' => 'form','enctype' => 'multipart/form-data','files' => true,)) !!}

	<!-- second step start -->
		<div class="tab breck_table">
			<div class="table-responsive all_details">  
				<div class="row">
					<div class="col-lg-6">
                        <div class="table_line">
                        <table class="table" style="height: 100%;">
                            <thead>
                                <tr>
                                    <th>Steps</th>
                                    <th>Specific Objectives</th>
                                    <th>Teaching Points</th>                      
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><textarea rows="47" cols="7" class="frmsubmit" name="steps" id="steps" readonly="">{{$lession_result->steps}}</textarea></td>
                                    <td><textarea rows="47" class="frmsubmit" name="specific_objectives" maxlength="1500" readonly="">{{$lession_result->specific_objectives}}</textarea></td>
                                    <td><textarea rows="47" class="frmsubmit" cols="30" name="teaching_points" maxlength="1500" readonly="">{{$lession_result->teaching_points}}</textarea></td>
                                </tr>
                            </tbody>
                        </table>
                        </div>    
                    </div>

					<div class="col-lg-6 print_break">
						<div class="table_line">
							<table class="table" style="height: 100%;">
								<thead>
									<tr>
										<th>Teacher's Activity</th>
										<th>Student's Activity</th>
										<th>Reference / Example</th>
									</tr>
								</thead>
								<tbody>
                                    <tr>                        
                                        <td rowspan="25"><textarea rows="35" cols="45" name="teacher_activity" maxlength="1000" class="frmsubmit" readonly="">{{$lession_result->teacher_activity}}</textarea></td>
                                        <td rowspan="20" ><textarea rows="35" class="frmsubmit" cols="45" name="student_activity"  maxlength=" 1200" readonly="">{{$lession_result->student_activity}}</textarea></td>
                                        <td class="linking_area">
                                            <?php
                                            $result = explode(',', $lession_result->reference);
                                            ?>
                                            <ul class="form_ul" style="overflow-y: scroll; height: 180px;">
                                            @foreach($result as $results)
                                            <li>
                                                <a href="{{ route('openPdf',$results) }}"  target="_blank">{{$results}}</a>
                                            </li>        
                                            @endforeach
                                            </ul>
                                            <textarea rows="10" maxlength="80" name="reference_manual" class="frmsubmit" readonly="">{{$lession_result->reference_manual}}</textarea>
                                            
                                            <!-- <a href="{{ route('openPdf',$lession_result->id) }}"  target="_blank">{{$lession_result->reference}}</a> -->   
                                            <!-- <button type="button" id="add_multifile">add</button> -->
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <input type="file" name="reference[]" id="reference" class="frmsubmit" multiple  disabled="">
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Details of Evaluation</th>
                                    </tr>
                                    <tr>
                                        <td><textarea rows="12" name="evaluation" maxlength="100" class="frmsubmit" readonly="">{{$lession_result->evaluation}}</textarea></td>                               
                                    </tr>
                                </tbody>
							</table>	
						</div>
					</div>
				</div>
			</div>
			<div>
			<div style="float:right;">
				<a href="{{route('viewLession',[$lession_result->id,$uid])}}"><button type="button">Previous</button></a>
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
   if (e.which != 8 && e.which != 0 && e.which != 13 && e.which != 32 && (e.which < 48 || e.which > 57)) {
   return false;
  } 
}); 

$('.frmsubmit').keyup(function(e) {
     var data = $("form").serialize();
     var Id = '<?php echo $lession_result->id; ?>';
      $.ajax({
        url: '/updateLesson2/'+Id,
        data: data,
        dataType:'json',
        type:'POST',       
        success: function(data) {         
         
        }
    });
 });
 </script>
@endsection
