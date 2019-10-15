@extends('layouts.adminMaster')
@section('content')

<div class="page-min-height"  style="background-color: rgb(69, 77, 102); padding: 118px 0px 40px;">
    <div class="container">
      <div class="col-md-12">
				@if (count($teacher) > 0)
				<table class="rwd-table">
					<h5 style="color: #fff; margin-bottom: 35px;text-align: right;font-size: 24px; font-weight: 700">Teachers List</h5>
					<tbody>
						<tr class="teacherlist">
							<th class="headergreen">Name</th>
							<th class="headergreen">Email</th>
							<th class="headergreen">Designation</th>
							<th class="headergreen">Qualification</th>
							<th class="headergreen">Action</th>
						</tr>
						@foreach($teacher as $teachers)
						<tr>
							<td title="{{ $teachers->name }}" data-th="Name">
								{{ $teachers->name }}
							</td>
							<td title="{{ $teachers->email }}" data-th="Email">
								{{ $teachers->email }}
							</td>
							<td data-th="Designation">
								{{ $teachers->designation }}
							</td>
							<td data-th="Qualification">
								{{ $teachers->qualification }}
							</td>
							<td data-th="Action">
								<a href="{{ route('deleteTeacher',$teachers->id) }}"><button style="border: none; background-color: #009975;color: #fff; cursor: pointer;border-radius: 5px;margin: 2px;">Delete</button></a>
								@if($teachers->is_approved == 1)
								<a href="{{ route('denyTeacher',$teachers->id) }}"><button style="border: none; background-color: #009975;color: #fff; cursor: pointer;border-radius: 5px;margin: 2px;">Deny</button></a>
								<a href="{{ route('QuizList',$teachers->id) }}"><button style="border: none; background-color: #009975;color: #fff; cursor: pointer;border-radius: 5px;margin: 2px;">Quizzes</button></a>
								@else
								<a href="{{ route('approveTeacher',$teachers->id) }}"><button style="border: none; background-color: #009975;color: #fff; cursor: pointer;border-radius: 5px;margin: 2px;">Approve</button></a>
								@endif
								
							</td>
						
						</tr>
	
						@endforeach
					</tbody>
				</table>
				@else
				<h5 style="color: #fff; margin-bottom: 35px;text-align: center;font-size: 24px; font-weight: 700">No Quizzes added!</h5>
				@endif	
				<div class="teacherlist_pagination" style="margin-top: 35px;"> 
					{{ $teacher->links() }}
				</div>			
			</div>
    </div>
</div>
@endsection
