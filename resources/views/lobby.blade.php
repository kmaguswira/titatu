@extends('layout.layout')
@section('title', '| Online Game Tic Tac Toe')
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
			<div class="panel panel-info">
			    <div class="panel-heading" id="accordion">
			        <span class="glyphicon glyphicon-comment"></span> Chat
			    </div>
			    <div class="panel">
			        <div class="panel-body">
			            <ul class="chat">
			                <li class="clearfix">
			                    <div class="chat-body clearfix">
			                        <div class="header">
			                            <strong class="primary-font">Jack Sparrow</strong> <small class="pull-right text-muted">
			                            <span class="glyphicon glyphicon-time"></span>12 mins ago</small>
			                        </div>
			                        <p>
			                            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur bibendum ornare
			                            dolor, quis ullamcorper ligula sodales.
			                        </p>
			                    </div>
			                </li>
			                <li class="clearfix">
			                    <div class="chat-body clearfix">
			                        <div class="header">
			                            <small class=" text-muted"><span class="glyphicon glyphicon-time"></span>13 mins ago</small>
			                            <strong class="pull-right primary-font">Bhaumik Patel</strong>
			                        </div>
			                        <p style="text-align:right;">
			                            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur bibendum ornare
			                            dolor, quis ullamcorper ligula sodales.
			                        </p>
			                    </div>
			                </li>
			            </ul>
			        </div>
			        <div class="panel-footer">
			            <div class="input-group">
			                <input id="btn-input" type="text" class="form-control input-sm" placeholder="Type your message here..." />
			                <span class="input-group-btn">
			                    <button class="btn btn-warning btn-sm" id="btn-chat">Send</button>
			                </span>
			            </div>
			        </div>
			    </div>
			</div>
		</div>
		<div class='col-md-6'>
			<div class="panel panel-danger">
			    <div class="panel-heading" id="accordion">
			        <span class="glyphicon glyphicon-home"></span> Room
			    </div>
			    <div class="panel">
			      	<div class="panel-body">
			        	<table class="table table-striped">
								@foreach($rooms as $room)
									<tr>
										<td><center><strong>{!! $room->room_name !!}</strong></center></td>
										<td><center>{!! $room->User->name !!}</center></td>
										<td><center>{!! $room->RoomPrivate ? "Private" : "Public" !!}</center></td>
										<td><center>
											<a class="btn {!! $room->RoomPrivate ? 'btn-warning' : 'btn-info' !!}" href="{!! url('/room/'.$room->id)!!}">Join</a>
											<a class="btn btn-default"><span class="glyphicon glyphicon-eye-open"></span></a>
										</center></td>

									</tr>
								@endforeach
						</table>    
			        </div>
			        <div class="panel-footer">
			            <center><a class="btn btn-primary" href="#" style="font-size:11px;" data-toggle="modal" data-target="#addRoom"><b><span class="glyphicon glyphicon-plus"></span> Create Room</b></a></center>
			        </div>
			    </div>
			</div>
		</div>
	</div>
	<div class="modal fade" id="addRoom" tabindex="-1" role="dialog" aria-labelledby="addRoom">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="addRoom">Create Room</h4>
                </div> 
                {!! Form::open(array('url' => '/room/create', 'method' => 'post')) !!}
                <div class="modal-body">
                    <div class="form-group">
                        {!! Form::label('name', 'Room Name') !!}
                        {!! Form::text('name', '', array('class'=>'form-control', 'placeholder'=>'Room Name', 'required'=>true)); !!}
                    </div>
                    <div>
                    	<input type="checkbox" name="isPrivate" value="1">Private? 
                	</div>
                    <div class="form-group" id="private" style="display:none;">
                        {!! Form::label('password', 'Password') !!}
                        {!! Form::text('password', '', array('class'=>'form-control', 'placeholder'=>'Your Password')); !!}
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    {!! Form::submit('Create', array('class'=>"btn btn-primary"))!!}
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
@endsection
@section('script')
	<script>
		$('input[name=isPrivate]').change(
	    function(){
	        if (this.checked) {
	            $('#private').show();
	        }else if(this.checked==false){
	        	$('#private').hide();
	        }
	    });
    </script>
@endsection