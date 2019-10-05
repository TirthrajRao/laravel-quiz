@extends('layouts.studentMaster')
@section('content') 
<div class="page-min-height "  style="background-color: rgb(69, 77, 102); padding-bottom: 40px;">
    <div class="container">
    	<div class="row">
      <div class="col-md-6">      	
			@if ($message = Session::get('success'))
			<div class="alert alert-success" id="message_id">
				<p>{{ $message }}</p>
			</div>
			@endif
			<a href="{{ url('/lessionPlans') }}"><button class="btn add_btn" type="button">Add <i class="fa fa-plus" style="color: #fff;"></i>
					</button></a>
				@if (count($lession) > 0)			
				<table class="rwd-table">
					<h5 style="color: #fff; margin-bottom: 35px;text-align: right;font-size: 24px; font-weight: 700">Lesson Plan </h5>
					
					<thead>
						<tr>
							<th>Lesson No</th>
							<th>Topic</th>
							<th>Action</th>
						</tr>
					</thead>
					<tbody>
						@if (count($lesson_complete) > 0)	
						@foreach($lesson_complete as $lessions)
						<tr>
							<td data-th="Lesson No">
								{{ $lessions->lession_no }}
							</td>
							<td data-th="Topic">
								{{ $lessions->topic }}
							</td>	
							<td data-th="Action">
								<a href="{{ route('deleteLession',$lessions->id) }}"><button style="border: none; background-color: #009975;color: #fff; cursor: pointer;border-radius: 5px;margin: 2px;">Delete</button></a>
								<a href="{{ route('editLession',$lessions->id) }}"><button style="border: none; background-color: #009975;color: #fff; cursor: pointer;border-radius: 5px;margin: 2px;">Edit</button></a>
								<a href="{{ route('downloadLesson',$lessions->id) }}"><button style="border: none; background-color: #009975;color: #fff; cursor: pointer;border-radius: 5px;margin: 2px;">Download</button></a>
							</td>
						</tr>	
						@endforeach
						@else
						<tr>
                      <td colspan="3"><h5 style="color: #fff; margin-bottom: 35px;text-align: center;font-weight: 700">No Lesson Plan Completed!</h5></td>
                    </tr>
				
				@endif
					</tbody>
				</table>
				@else
				 <h5 style="color: #fff; margin-bottom: 35px;text-align: right;font-weight: 700">No Lesson Plan Created!</h5>
                   
				@endif
					<div class="lesson_pagination" style="margin-top: 35px; margin-bottom: 35px;"> 
					{{ $lesson_complete->links() }}
				</div>
				
				
	  </div>
	 
	  <div class="col-md-6">
			@if (count($lession) > 0)
			<table class="rwd-table">
				<h5 style="color: #fff; margin-bottom: 35px;text-align: right;font-size: 24px; font-weight: 700; margin-top: 24px;">Drafts</h5>
				
				<thead>
					<tr>
						<th>Lesson No</th>
						<th>Topic</th>
						<th>Action</th>
					</tr>
				</thead>
				<tbody>
					 @if (count($lession_draft) > 0)
					@foreach($lession_draft as $lession_drafts)
					<tr>
						<td data-th="Lesson No">
							{{ $lession_drafts->lession_no }}
						</td>
						<td data-th="Topic">
							{{ $lession_drafts->topic }}
						</td>	
						<td data-th="Action">
							<a href="{{ route('deleteLession',$lession_drafts->id) }}"><button style="border: none; background-color: #009975;color: #fff; cursor: pointer;border-radius: 5px;margin: 2px;">Delete</button></a>
							<a href="{{ route('lessionPlan2Edit',$lession_drafts->id) }}"><button style="border: none; background-color: #009975;color: #fff; cursor: pointer;border-radius: 5px;margin: 2px;">Start</button></a>
						</td>
					</tr>
					@endforeach
					@else
					<tr>
                        <td colspan="3"><h5 style="color: #fff; margin-bottom: 35px;text-align: center;font-weight: 700">No Pending Lesson Plans!</h5></td>
                    </tr>
					
					 @endif
					 
				</tbody>
			</table>	
			@else					
					
		   @endif
		   <div class="lesson_pagination" style="margin-top: 35px; margin-bottom: 35px;"> 
					{{ $lession_draft->links() }}
				</div>
		
	  </div>

	</div>
    </div>
</div>

<script type="text/javascript">
	$("document").ready(function(){
		setTimeout(function(){
			$("#message_id").remove();
		}, 1000 );
	});
</script>

@endsection
