@extends('layouts.studentMaster')
@section('content')
<div class="page-min-height" style="background-color: #454d66">
	<section class="all_quiz_list" style="padding: 40px 0px 40px">

		{!! Form::open(array('id' => 'regForm','url' => 'createLession3/'.$id,'role' => 'form','enctype' => 'multipart/form-data','files' => true,)) !!}

		<!-- third step start -->
		<div class="tab" >
			<div class="board_work">
				<h6>BLACK BOARD WORK</h6>
			</div>
			<!-- subject_details -->
			<div class="table-responsive-md">
                <table class="table1 mt-3">
                    <tbody>
                        <tr>
                            <td><p>SUBJECT : <span>{{$result->subject}}</span></p></td>
                            
                            <td><p>TOPIC : <span>{{$result->topic}}</span></p></td>
                        
                        </tr>
                        <tr>
                            <td><p>STD : <span>{{$result->standard}}</span></p></td>
                            
                            <td><p>DATE : <span>{{$result->date}}</span></p></td>
                            
                        </tr>
                    </tbody>
                </table>
            </div>
			<!-- canvas -->
			<div id="paint-app"></div>
			<textarea name="base64" id="base64" class="frmsubmit" style="display:none;"></textarea>

			<!-- assignment -->
			<div class="assign_head">
				<h6>ASSIGNMENT</h6>
			</div>
			<textarea rows="8" name="assignment" maxlength="800" class="frmsubmit"></textarea>

			<!-- remark  -->
			<div class="remark_head">
				<h6>OBSERVER'S REMARK</h6>
			</div>
			<textarea rows="15" name="observers_remark" disabled=""></textarea>

			<!-- form end details -->
			<div class="date mt-5">
				<span>DATE</span>
				<span class="float-right">OBSERVER'S SIGN</span>
			</div>
			<div>
				<div style="float:right;">
					<a href="{{route('lessionPlan2Edit',$id)}}"><button type="button">Previous</button></a>
					<button type="submit" onclick="getCanvas();">Submit</button>

				</div>
			</div>
		</div>
		<!-- third step end -->

		{!! Form::close() !!}
	</section>
</div>
<script>
	var appDiv = document.querySelector('#paint-app');
	createPaint(appDiv);
	function createPaint(parent) {
		var canvas = elt('canvas', {});
		var cx = canvas.getContext('2d');
		canvas.width  = 920;
		canvas.height = 400;
		canvas.id = 'canId';
		var toolbar = elt('div', {class: 'toolbar'});
		for (var name in controls)
			toolbar.appendChild(controls[name](cx));

		var panel = elt('div', {class: 'picturepanel'}, canvas);
		parent.appendChild(elt('div', null, panel, toolbar));
	}
	function getCanvas(){
		var canvasGetValue = document.getElementById("canId");
		  var imageCan = canvasGetValue.toDataURL();
		  document.getElementById('base64').value = imageCan;	
	}
$('.frmsubmit').keyup(function(e) {
 var data = $("form").serialize();
 var Id = '<?php echo $id; ?>';
  $.ajax({
    url: 'createLession3/'+Id,
    data: data,
    dataType:'json',
    type:'POST',       
    success: function(data) {         
     
    }
     });
});
alert("ppp");
</script>
@endsection
