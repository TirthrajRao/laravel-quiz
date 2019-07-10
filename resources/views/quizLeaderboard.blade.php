@extends('layouts.app')
@section('content')
<div class="page-min-height" style="background-color: rgb(69, 77, 102)">
	<div class="container">
		<div class="row" style="margin-top: 30px;">
			<div class="col-md-6"></div>
			<div class="col-md-6">
				@if ($message = Session::get('success'))
				<div class="alert alert-success" id="message_id">
					<p>{{ $message }}</p>
				</div>
				@endif
			</div>
		</div>
		<table class="rwd-table">
			@foreach($leaderboard as $index=>$leader)
			@if($index==0)
			<h5 style="color: #fff; margin-bottom: 35px;text-align: center;">Leaderboard for <b><i>{{$leader->title}}</i></b> Quiz: (Total Questions: <b><i>{{ $leader->total_questions}} </i></b>)</h5>
			@endif
			@endforeach
			<tbody>
				<tr>
					<th>Rank</th>
					<th>Name</th>
					<th>Average Score</th>
					<th>No. of times appeared</th>
					<th>Updated at</th>
				</tr>
				@foreach($leaderboard as $index=>$leader)
				<tr>
					<td data-th="Rank">
						{{ $index+1 }}
					</td>
					@if($index==0)
					<td data-th="Name">{{ $leader->name }} <i class="fa fa-trophy" style="color: #AF9500; font-size: 20px"></i></td>
					@elseif($index==1)
					<td data-th="Name">{{ $leader->name }} <i class="fa fa-trophy" style="color: #B4B4B4; font-size: 20px"></i></td>
					@elseif($index==2)
					<td data-th="Name">{{ $leader->name }} <i class="fa fa-trophy" style="color: #AD8A56; font-size: 20px "></i></td>
					@else
					<td data-th="Name">{{ $leader->name }}</td>
					@endif
					<td data-th="Average Score">
						{{ $leader->avg_score * 100 / $leader->total_questions}}%
					</td>
					<td data-th="No. of times appeared">
						{{ $leader->appear_count }}
					</td>
					<td data-th="Updated at">
						{{ Carbon\Carbon::parse($leader->updated_at)->format('d-m-Y') }} at {{ Carbon\Carbon::parse($leader->updated_at)->format('g:i A') }}
					</td>
				</tr>
				@endforeach
			</tbody>
		</table>
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