@extends('layout.layout')
@section('title', '| Leaderboard')
@section('navigation')
	{!! View::make('components.nav')->render()  !!}
@endsection
@section('content')
	<div style="margin-top:50px">
		@if(session('status'))
			<div class="alert alert-danger alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <p>{!! session('status') !!}</p>
            </div>
		@endif
		<div class='col-md-6'>
			<div class="panel panel-primary">
			    <div class="panel-heading" id="accordion">
			        <span class="glyphicon glyphicon-user"></span> User Statistic
			    </div>
			    <div class="panel">
			        <div class="panel-body" style="overflow-y:hidden !important;">
			            <div class="col-md-4">
			            	<center><h1 style="font-size:100px"><strong>{!! $statistic[0]->win !!}</strong></h1></center><br>
			            	<center><h4>Wins</h4></center>
			            </div>
			            <div class="col-md-4">
			            	<center><h1 style="font-size:100px"><strong>{!! $statistic[0]->draw !!}</strong></h1></center><br>
			            	<center><h4>Tie</h4></center>
			            </div>
			            <div class="col-md-4">
			            	<center><h1 style="font-size:100px"><strong>{!! $statistic[0]->lose !!}</strong></h1></center><br>
			            	<center><h4>Lose</h4></center>
			            </div>
			            <div class="col-md-12">
			            	<hr>
			            	<center><h3><b>Total Points:</b></h3></center>
			            	<center><h1 style="font-size:100px"><strong>{!! $statistic[0]->total_point !!}</strong></h1></center><br>
			            </div>
			        </div>
			        <div class="panel-footer">
			        </div>
			    </div>
			</div>
		</div>
		<div class='col-md-6'>
			<div class="panel panel-warning">
			    <div class="panel-heading" id="accordion">
			        <span class="glyphicon glyphicon-globe"></span> Leaderboard
			    </div>
			    <div class="panel">
			      	<div class="panel-body" style="overflow-y:hidden !important;">
			      	<table class="table">
			      		<thead>
			      			<tr>
			      				<th><center>Rank</center></th>
			      				<th><center>Name</center></th>
			      				<th><center>Wins</center></th>
			      				<th><center>Ties</center></th>
			      				<th><center>Loses</center></th>
			      				<th><center>Total Points</center></th>
			      			</tr>
			      		</thead>	
			        	@foreach($leaderboards as $key=>$leaderboard)
			        	<tbody><tr class="{!! $leaderboard->user_id==Auth::User()->id ? 'success': '' !!}">
			        		<td><center>{!!$key+1!!}</center></td>
			        		<td><center>{!!$leaderboard->User->name!!}</center></td>
			        		<td><center>{!!$leaderboard->win!!}</center></td>
			        		<td><center>{!!$leaderboard->draw!!}</center></td>
			        		<td><center>{!!$leaderboard->lose!!}</center></td>
			        		<td><center>{!!$leaderboard->total_point!!}</center></td>
			        	<tr></tbody>
			        	@endforeach    
			        </table>
			        </div>
			        <div class="panel-footer">
			        </div>
			    </div>
			</div>
		</div>
	</div>
@endsection