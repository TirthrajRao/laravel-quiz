@extends('layouts.adminMaster')
@section('content') 
<div class="page-min-height "  style="background-color: rgb(69, 77, 102); padding-bottom: 40px;">
    <div class="container">
    	<div class="row">
      <div class="col-md-6">  
				@if (count($lesson_complete) > 0)			
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
								
								<a href="{{ route('viewLessionadmin',[$lessions->id,$id]) }}"><button style="border: none; background-color: #009975;color: #fff; cursor: pointer;border-radius: 5px;margin: 2px;">View</button></a>
								
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
					
						{{$lesson_complete->links()}}

				</div>			
				
	  </div>
	</div>
    </div>
</div>
@endsection
