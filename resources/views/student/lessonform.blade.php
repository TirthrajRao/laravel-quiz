<!DOCTYPE html>
<html>
<head>
	<title>LESSON PLANNING</title>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	
	<link rel="stylesheet" href="lessionPlan/css/style.css" media="all" />
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
	<style>
		#regForm {
		    background-color: #ffffff;
		    margin: auto;
		    width: 100%;
		}
		.tab {
		    padding: 8px;
		    border-radius: 15px;
		    border-style: double;
		}
		.form_head img {
    		height: 65px;
    		width: 85px;
    		position: absolute;
		}
		.form_head h6 {
		    font-size: 28px;
		    font-weight: 900;
		   	text-align: center;
		}
		.form_head p {
		    font-size: 20px;
		    font-weight: 600;
		    text-align: center;
		    padding-bottom: 5px;
		}
		.sub_head{
			margin-top: 8px;
		}
		
		.sub_head span {
		    border: 2px solid black;
		    border-radius: 10px;
		    font-size: 20px;
    		padding: 4px 12px;
    		text-align: center;
		    font-weight: 600;
		    border-right:none;
		    border-left:none;
		}
		.td_class{
			width: 125px;
		}
		.no label {
	    	font-weight: 600;
	    	font-size: 16px;
		}
		.basic_detail {
		    border: 2px solid black;
		    padding: 15px 20px;
		    margin-top: 7px;
		}
		.table3 input {
		    font-size: 17px;
		    font-family: Raleway;
		    border: none;
		    border-bottom: 3px dotted #000;
		    width: 100%;
		}
		.tech_details {
		    border: 1px solid #000;
		    width: 100%;
		    resize: none;
		    border-left: none;
		}
		.table_line {
		    border-style: double;
		    border-radius: 15px;
		    padding: 0px;
		    max-height:  auto!important;
   			min-height: 110%;
		    overflow: hidden;
		    border-collapse: unset;
		}
		.assign_area{
			height: 200px;
		}
		
	</style>    
</head>
<body>
	<form id="regForm" action="" style="width: 100%!important">
		<!-- One "tab" for each step in the form: -->
		<div class="tab" style="width: 100%;page-break-after: always;">
			<!-- form heading --> 
			<div class="form_head">
				<img src="images/logo.png" style="width: 70px;">
				<h6>INSTITUTE OF LANGUAGE TEACHING</h6>
				<P>(English Medium) B.Ed. College - Rajkot</P>
			</div>

			<!-- subhead -->
			<div class="sub_head" style=" margin-left: 32%;">
				<span style="border:2px solid #000; padding: 5px;">LESSON PLANNING</span>
			</div>

			<!-- form_no -->
			<div class="no" style="margin-left: 60%;">
				<label>TRAINEE'S ROLL NO.</label>
				<span>{{$user->enroll_no}}</span>
			</div>
			<div class="no" style="margin-left: 70%;">
				<label>LESSON NO.</label>
				<span>{{$lession_result->lession_no}}</span>
			</div>

			<!-- detailstable -->
			<div class="table-responsive basic_detail" style=" border:1px solid black;">  
				<table class="table3" style="width: 100%;">
					<tr>
						<td class="td_class">TRAINEE NAME </td>
						<td colspan="5" style=" border-bottom: 3px dotted #000;">{{$user->name}}</td>
					</tr>

					<tr>
						<td>SCHOOL NAME	</td>
						<td colspan="3" style=" border-bottom: 3px dotted #000;">{{$lession_result->school_name}}</td>
				
						<td style="width: 30px; padding: 0 8px;">STD</td>
						<td style="border-bottom: 3px dotted #000;">{{$lession_result->standard}}</td>
					</tr>	
			
					<tr>
						<td>SUBJECT </td>
						<td style="border-bottom: 3px dotted #000;">{{$lession_result->subject}}</td>
					
						<td style="width: 30px; padding: 0 8px;">TOPIC</td>
						<td style=" border-bottom: 3px dotted #000;">{{$lession_result->topic}}</td>
					
						<td style="padding: 0 8px;">DATE</td>
						<td style=" border-bottom: 3px dotted #000;">{{$lession_result->date_lession}}</td>
					</tr>
						
					<tr>
						<td>PERIOD NO.</td>
						<td style=" border-bottom: 3px dotted #000;">{{$lession_result->period_no}}</td>
					
						<td style="padding: 0 8px;">TIME </td>
						<td style=" border-bottom: 3px dotted #000;">{{$lession_result->time}}</td>
					
						<td style="padding: 0 8px;">TO</td>
						<td style=" border-bottom: 3px dotted #000;">{{$lession_result->time_to}}</td>
					</tr>

						
				</table>
			</div>  

			<!-- general details -->
			<form>
				<table class="table">
					<tr>
					  <th>General Objectives</th>
					  <th>Approach Technique</th>
					</tr>
					<tr>
					   <td rowspan="3" style="height: 130px; width: 15%;">{{$lession_result->general_objectives}}</td>
					   <td style="height: 142px; width: 10%;">{{$lession_result->approach_technique}}</td>
					</tr>					
					<tr>
					  <td style="height: 45px;">Teaching Aids</td>
					</tr>
					<tr>
						<td style="height: 118px; width:10%;" >{{$lession_result->teaching_aids}}</td>
					</tr>
					
				</table>				
			</form>

			<!-- books refernce details -->
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
							<td>{{$lession_result->text_book}}</td>
							<td>{{$lession_result->author_book}}</td>
							<td>{{$lession_result->pageno_textbook}}</td>
						</tr>
						<tr>
							<td>Refernce Book</td>
							<td>{{$lession_result->refernce_books}}</td>
							<td>{{$lession_result->author_ref_book}}</td>
							<td>{{$lession_result->pageno_refbook}}</td>
						</tr>
					</tbody>
				</table>
		</div>

		<!-- second step start -->
		<div class="tab" style="margin-top: 10px;page-break-after: always;">
		
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
							<td style="height:890px; width: 5%;">{{$lession_result->steps}}</td>
							<td style="height:890px; width: 20%;">{{$lession_result->specific_objectives}}</td>
							<td style="height:890px; width: 20%;">{{$lession_result->teaching_points}}</td>				       
						</tr>
					</tbody>
				</table>
			
		</div>

		<div class="tab" style="margin-top: 10px;page-break-after: always;">
				<table class="table" style="height: 700px;">
					<tr>
						<th>Teacher's Activity</th>
						<th>Student's Activity</th>
						<th>Reference / Example</th>				      
					</tr>
					<tr>
						<td rowspan="3" style="height: 620px; width: 35%;">{{$lession_result->teacher_activity}}</td>
						<td rowspan="3" style="height: 620px; width: 40%;">{{$lession_result->student_activity}}</td>
						<td style="height:377px; width:20%;">
							<?php
						        $result = explode(',', $lession_result->reference);
						    ?>
						    <ul class="form_ul">
						        @foreach($result as $results)
						        <li><a href="{{ route('openPdf',$results) }}"  target="_blank">{{$results}}</a></li>        
						         	@endforeach
								{{$lession_result->reference_manual}}
						</td>
					</tr>
					<tr>
						<td>Details of Evaluation</td>
					</tr>
					<tr>
						<td style="height: 250px;  width:20%;">{{$lession_result->evaluation}}</td>
					</tr>
				</table>
		</div>
					
	
		<!-- second step end -->
		<!-- third step start -->
		<div class="tab">
			<div class="board_work">
				<h6>BLACK BOARD WORD</h6>
			</div>
				<table class="table1">
					
						<tr>
							<td><p>SUBJECT : <span>{{$lession_result->subject}}</span></p></td>
							
							<td><p>TOPIC : <span>{{$lession_result->topic}}</span></select></p></td>
						</tr>
						<tr>
							<td><p>STD : <span>{{$lession_result->standard}}</span></p></td>
							
							<td><p>DATE : <span>{{$lession_result->date_lession}}</span></p></td>
						</tr>
				
				</table>

			<div id="paint-app"></div>

			<img src="canvas/<?php echo $lession_result->diagram;?>" style="height: 300px; width: 800px;">

			<table class="table" style="width: 100%;">
				<tr>
					<td>ASSIGNMENT</td>
				</tr>
				<tr>
					<td>
						{{$lession_result->assignment}}	
					</td>
				</tr>
				<tr>
					<td>OBSERVER'S REMARK</td>
				</tr>
				<tr>
					<td>
						<textarea rows="15" class="assign_area"></textarea>						
					</td>
				</tr>
			</table>
			
			<div class="date mt-5">
				<span>DATE</span>
				<span style=" position: absolute;right: 50px;">OBSERVER'S SIGN</span>
			</div>
		</div>
		<!-- third step end -->

	
	</form>

	<!-- jQuery library -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

	<!-- Popper JS -->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>

	<!-- Latest compiled JavaScript -->
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
	<script type="text/javascript" src="/public/lessionPlan/js/custom.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.0.943/pdf.min.js">
</script>



</body>
</html>