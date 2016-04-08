@extends('layout.layout')
@section('title', '| Lobby')
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
			        <div class="panel-body" id="panelChat">
			            <ul class="chat" id="chatBox">
							<?php for($i=count($chats)-1; $i>=0; $i--):?>
				                <li class="clearfix" data-id="{!! $chats[$i]->id !!}">
				                    <div class="chat-body clearfix">
				                        <div class="header">
				                            <strong class="primary-font">{!!$chats[$i]->User->name!!}</strong> <small class="pull-right text-muted">
				                            <span class="glyphicon glyphicon-time"></span>{!!$chats[$i]->created_at!!}</small>
				                        </div>
				                        <p>
				                        	{!! $chats[$i]->chat !!}
				                        </p>
				                    </div>
				                </li>
			                <?php endfor; ?>
			            </ul>
			        </div>
			        <div class="panel-footer">
			            <div class="input-group">
				                <input id="msg" type="text" class="form-control input-sm" maxlength="200" placeholder="Type your message here..." />
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
			        	<table class="table table-striped" id="roomTable">
								@foreach($rooms as $room)
									<tr>
										<td><center><strong>{!! $room->room_name !!}</strong></center></td>
										<td><center>{!! $room->User->name !!}</center></td>
										<td><center>{!! $room->RoomPrivate ? "Private" : "Public" !!}</center></td>
										<td><center>
										<li style="list-style:none" class="dropdown"><a href="#" onclick="seeinside({!!$room->id!!});"class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">See Inside <span class="caret"></span></a>
										<ul id="{!!$room->id!!}" class="dropdown-menu"></ul></li>

										</center></td>
										<td><center>
											<a href="{!! url('/room/'.$room->id)!!}">Join</a>
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

		function chatPoll(){
			if($("#chatBox li:last").data("id"))
				var last = $("#chatBox li:last").data("id");
			else
				var last = 0;
			$.get('{!! url("getchat") !!}/'+last, function(data) {
				for(var i=0; i<data.length; i++){
					var row = '<li class="clearfix" data-id="'+data[i].id+'">';
                    row += '<div class="chat-body clearfix"><div class="header">';
                    row += '<strong class="primary-font">'+data[i].user_id+'</strong> <small class="pull-right text-muted">';
                    row += '<span class="glyphicon glyphicon-time"></span>'+data[i].created_at+'</small></div>';
                    row += '<p>'+data[i].chat+'</p></div></li>';
					
         			$("#chatBox li:last").after(row);
         		}
         		$("#panelChat").animate({scrollTop: $('#panelChat').height()}, 1000);
			}).fail(function() {
				//setTimeout(chatPoll,1000);
			});
				setTimeout(chatPoll,5000);
		}

		function roomPoll(){
			$.get('{!! url("getroom") !!}', function(data) {
				$("#roomTable tr").remove();
				for(var i=0; i<data.length; i++){
					var row = '<tr><td><center><strong>'+data[i].room_name+'</strong></center></td>';
					row += '<td><center>'+data[i].username+'</center></td>';
					row += '<td><center>'+data[i].isprivate+'</center></td><td><center>';
					row += '<li style="list-style:none" class="dropdown"><a href="#" onclick="seeinside('+data[i].id+');"class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">See Inside <span class="caret"></span></a>';
					row += '<ul id="'+data[i].id+'" class="dropdown-menu"></ul></li>';
					row += '</center></td><td><center><a href="room/'+data[i].id+'">Join</a>';
					row += '</center></td></tr>';
					$("#roomTable").append(row);

										
				}
			}).fail(function() {
				//setTimeout(roomPoll,3000);
			});;
			setTimeout(roomPoll,5000);
		}

		$("#btn-chat").click(function(event){
			var values = $("#msg").val();
			$.ajax({
		        url: "{!! url('chat') !!}",
		        type: "post",
		        data: "chat="+values ,
		        success: function (response) {
		           $("#msg").val("");
		        },
		        error: function(jqXHR, textStatus, errorThrown) {
		           console.log(textStatus, errorThrown);
		        }
			});
		});

		
		function seeinside(aa){
			console.log(aa);
			$('#'+aa).empty();

			$.get('{!! url("seeinside") !!}/'+aa, function(data) {
				var str="";
				for(i=0; i<data.length; i++){
					str+="<li>"+data[i].username+"-"+data[i].role+"</li>";
				}
				$('#'+aa).val("");
				$('#'+aa).append(str);
			});
		}		
		
		setTimeout(chatPoll,5000);
		setTimeout(roomPoll,5000);
    </script>
@endsection