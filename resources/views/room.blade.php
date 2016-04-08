@extends('layout.layout')
@section('title', '| Online Game Tic Tac Toe')
@section('scriptHead')
	<script>
		var result;
		var isPrivate = {!! $room->RoomPrivate ? 1 : 0 !!};
		if(isPrivate&& {!!$room->user_id!!} !== {!!Auth::User()->id!!}){
			var password=prompt('Please enter password to join this room!',' ');
			if(password !== "{!! $room->RoomPrivate ? $room->RoomPrivate->password : '' !!}"){
				window.location="{!! url('/lobby'); !!}";
				alert('WRONG PASSWORD!!');
			}
		}
		if("{!!$status!!}"=="Player1"){
			var play = confirm('You are player one, waiting for your oppponent');
			if(play){
				waitingPlayer();
			}else{
				window.location="{!! url('/lobby'); !!}";	
			}
		}else if("{!!$status!!}"=="Player2"){
			var play = confirm('You are player two, get ready for the battle');
			if(play){
				if(readyForPlay()==false)
				{
					alert("Something error, try again");
					window.location="{!! url('/lobby'); !!}";	
				}
			}else{
				window.location="{!! url('/lobby'); !!}";	
			}
		}else{
			alert('You are spectator, just watch and relax');
		}

		function waitingPlayer(){
			var xmlHttp = new XMLHttpRequest();
    		xmlHttp.open( "GET", "{!!url('waitPlayer')!!}", false );
    		xmlHttp.send( null );
 
    		if(xmlHttp.responseText == 'success'){
    			alert('Player 2 ready for battle');
    			return true;
    		}
    		else
    			waitingPlayer();
		}

		function readyForPlay(){
			var xmlHttp = new XMLHttpRequest();
    		xmlHttp.open( "GET", "{!!url("ready")!!}", false );
    		xmlHttp.send( null );
 
    		if(xmlHttp.responseText == 'success')
    			return true;
    		else
    			console.log(xmlHttp.responseText);
		}
	</script>
@endsection
@section('content')
<div style="margin-top:50px">
	<div class='col-md-12'>
		<div class="panel panel-success">
		    <div class="panel-heading" id="accordion">
		        <span class="glyphicon glyphicon-th"></span> TIC TAC TOE 
			@if($status == "Spectator")
		        <span class="pull-right"><a href='{!! url("lobby"); !!}'>Back to lobby</a></span>
		    @endif
		    </div>
		    <div class="panel">
		        <div class="panel-body" style="overflow-y:hidden">
		            <div class="col-md-6">
		            	<div>
			            	<canvas id="0" class="col-md-4" width="100%" height="100%/3" style="border:1px solid #000000; margin: 0 auto;"></canvas>
			            	<canvas id="1" class="col-md-4" width="100%" height="100%/3" style="border:1px solid #000000; margin: 0 auto;"></canvas>
			            	<canvas id="2" class="col-md-4" width="100%" height="100%/3" style="border:1px solid #000000; margin: 0 auto;"></canvas>
			            	<canvas id="3" class="col-md-4" width="100%" height="100%/3" style="border:1px solid #000000; margin: 0 auto;"></canvas>
			            	<canvas id="4" class="col-md-4" width="100%" height="100%/3" style="border:1px solid #000000; margin: 0 auto;"></canvas>
			            	<canvas id="5" class="col-md-4" width="100%" height="100%/3" style="border:1px solid #000000; margin: 0 auto;"></canvas>
			            	<canvas id="6" class="col-md-4" width="100%" height="100%/3" style="border:1px solid #000000; margin: 0 auto;"></canvas>
			            	<canvas id="7" class="col-md-4" width="100%" height="100%/3" style="border:1px solid #000000; margin: 0 auto;"></canvas>
			            	<canvas id="8" class="col-md-4" width="100%" height="100%/3" style="border:1px solid #000000; margin: 0 auto;"></canvas>
		            	</div>
		            </div>
		            <div class="col-md-6">
		            	<div class="panel panel-info">
						        <div class="panel-body" style="overflow-y:scroll; height:274.13px;" id="panelInfo"> 
						        	<p id="info">
						        	</p>
						        </div>
						</div>
		            </div>
		        </div>
		        <div class="panel-footer">
		            @if($status != "Spectator")
		            <div class="input-group">
			                <input id="msg" type="text" class="form-control input-sm" maxlength="200" placeholder="{!! $status == 'Player2' ? 'Not your turn, wait for other player' : 'Your Turn' !!}" {!! $status=="Player2" ? "disabled" : ""!!}/>
			                <span class="input-group-btn">
			                    <button class="btn btn-warning btn-sm" id="btn-chat">Send</button>
			                </span>
		            </div>
		            @endif
		        </div>
		    </div>
		</div>
	</div>
</div>
@endsection
@section('script')
@if($status!="Spectator")
<script>
	var init = 9;
	var countLoop =0;
	var timeup;

	{!!$status=="Player1"? "timeup = setTimeout(timeCountdown, 30000);" : ""!!}
	//onclick send button
	$("#btn-chat").click(function(){
    	var move = $('#msg').val().toUpperCase();
    	$('#msg').val("");

    	var validCommand = ['A1', 'A2', 'A3', 'B1', 'B2', 'B3', 'C1', 'C2', 'C3', 'WITHDRAW'];
    	var valid = false;
    	for(i=0; i<validCommand.length; i++){
    		if(move==validCommand[i]){
    			valid=true;
    		}
    	}
    	if(valid){
    		if(move=='WITHDRAW'){
				var	update = "<b>{!!$status!!}</b> : "+move+"<br> {!!$status=='Player1'?'Player2':'Player1'!!} WINS<br>";
    			saveInfo(update);
				$("#info").append(update);
				$("#panelInfo").animate({scrollTop: $('#panelInfo').height()}, 1000);
    			playerWithdraw();
    		}else{
    			checkOnBoard(move);
    		}
    	}else{
			var update="<b>{!!$status!!}</b> : "+move+" INVALID COMMAND!<br> VALID COMMAND : "+validCommand.toString()+"<br>";
			saveInfo(update);
			$("#info").append(update);
			$("#panelInfo").animate({scrollTop: $('#panelInfo').height()}, 1000);
    	}
	});

	function checkOnBoard(move){
		var alpha = move.substring(0,1);
		var index = "";
			if(alpha=='A'){
				index = 0 + parseInt(move.substring(1,2)) -1;  
			}else if(alpha=='B'){
				index = 3 + parseInt(move.substring(1,2)) -1;
			}else if(alpha=='C'){
				index = 6 + parseInt(move.substring(1,2)) -1;
			}
		$.ajax({
		        url: "{!! url('move') !!}",
		        type: "post",
		        data: "move="+index ,
		        success: function (response) {
		           if(response=='next'){
		           		var update = "<b>{!!$status!!}</b> : "+move+"<br><hr>";
		    			//send info to database
		    			saveInfo(update);
						$("#info").append(update);
						$("#msg").attr('disabled','disabled');
						$("#msg").attr('placeholder','Not your turn, wait for other player');
						$("#panelInfo").animate({scrollTop: $('#panelInfo').height()}, 1000);

						//fill canvas
						var canvas = document.getElementById(index);
						var ctx=canvas.getContext("2d");
						ctx.font="40px Arial";
						ctx.textAlign = "center";
						ctx.fillText("{!!$status=='Player1' ? 'X' : 'O' !!}", canvas.width/2, canvas.height/2);
						init -= 1;
						countLoop = 0;				
						//wait for other player for 30 second
						clearTimeout(timeup);
						wait();
		           }else if(response=='already'){
		           		var update = "<b>{!!$status!!}</b> : "+move+" HAS BEEN CHOOSEN BY OTHER PLAYER.<br>";
		    			//send info to database
		    			saveInfo(update);
						$("#info").append(update);
						$("#panelInfo").animate({scrollTop: $('#panelInfo').height()}, 1000);
		           }else if(response=='tie'){
		           		clearTimeout(timeup);
		    			//send info to database
		    			update = "TIE.";
						$("#info").append(update);
						$("#panelInfo").animate({scrollTop: $('#panelInfo').height()}, 1000);
		    			saveInfo(update);
						alert("OH NO ITS TIE!, Back to lobby");
						window.location="{!! url('/lobby'); !!}";
		           }else if(response=='winner'){
		           		$("#msg").attr('disabled','disabled');
		           		//fill canvas
						var canvas = document.getElementById(index);
						var ctx=canvas.getContext("2d");
						ctx.font="40px Arial";
						ctx.textAlign = "center";
						ctx.fillText("{!!$status=='Player1' ? 'X' : 'O' !!}", canvas.width/2, canvas.height/2);
		           		clearTimeout(timeup);
		    			//send info to database
		    			update = "END.";
						$("#info").append(update);
						$("#panelInfo").animate({scrollTop: $('#panelInfo').height()}, 1000);
		    			saveInfo(update);
						alert("You Win");
						window.location="{!! url('/lobby'); !!}";
		           }else
		           	console.log(response);
		        },
		        error: function(jqXHR, textStatus, errorThrown) {
		           console.log(textStatus, errorThrown);
		        }
			});
	}

	function wait(){
		setTimeout(function(){
			$.get("{!!url('countdown')!!}", function(data) {
		       if(data == init){
	    			countLoop++;
	    			updateInfo();
	    			if(countLoop == 30){
	    				$.get("{!!url('runaway')!!}", function(data) {
	    					alert("Time out, You Win ! Back to lobby");
	    					window.location="{!! url('/lobby'); !!}";				
	    				});
	    			}
	    			wait();			
	    		}else{
	    			init = data;
	    			updateBoard();
	    			$("#msg").removeAttr('disabled')
					$("#msg").attr('placeholder','Your Turn');
					timeup = setTimeout(timeCountdown, 30000);
	    			updateInfo();
	    			setTimeout(updateInfo, 5000);

	    		} 
		    });
		}, 1000);
	}

	function updateInfo(){
		$.get("{!!url('updateinfo')!!}", function(data) {
			var res = "";
			for(i=0; i<data.length; i++){
				res += data[i];	
			}
			$("#info").html("");
			$("#info").append(res);
			$("#panelInfo").animate({scrollTop: $('#panelInfo').height()}, 1000);
			if(data[data.length-1]=="END."){
			   	clearTimeout(timeup);
			   	$("#msg").removeAttr('disabled')
			   	alert("You Lose");
				window.location="{!! url('/lobby'); !!}";							
			}else if(data[data.length-1]=="TIE."){
				clearTimeout(timeup);
			   	$("#msg").removeAttr('disabled')
				alert("OH NO ITS TIE!, Back to lobby");
				window.location="{!! url('/lobby'); !!}";
			}else if(data[data.length-1]=="WITHDRAW."){
				clearTimeout(timeup);
				alert("YOU WIN!, Your oppponent has been withdraw.");
				window.location="{!! url('/lobby'); !!}";
			}
		});
	}

	function saveInfo(move){
		$.ajax({
		        url: "{!! url('saveinfoplay') !!}",
		        type: "post",
		        data: "move="+move,
		        success: function (response) {
		        },
		        error: function(jqXHR, textStatus, errorThrown) {
		           console.log(textStatus, errorThrown);
		        }
			});
	}

	function updateBoard(){
		$.get("{!!url('updateboard')!!}", function(data) {
			var res =data;
			for(i=0; i<res.length; i++){
				var canvas = document.getElementById(i);
				var ctx=canvas.getContext("2d");
				ctx.font="40px Arial";
				ctx.textAlign = "center";
				if("{!!$status!!}"=="Player1"){
					if(res[i].user_id=={!!Auth::User()->id!!})
						ctx.fillText("X", canvas.width/2, canvas.height/2);	
					else if(res[i].user_id==null)
						ctx.fillText("", canvas.width/2, canvas.height/2);	
					else
						ctx.fillText("O", canvas.width/2, canvas.height/2);	
				}else if("{!!$status!!}"=="Player2"){
					if(res[i].user_id=={!!Auth::User()->id!!})
						ctx.fillText("O", canvas.width/2, canvas.height/2);	
					else if(res[i].user_id==null)
						ctx.fillText("", canvas.width/2, canvas.height/2);	
					else
						ctx.fillText("X", canvas.width/2, canvas.height/2);	
				}
			}
		});
	}
	{!! $status=="Player2" ? "wait();" : ""!!}

	function timeCountdown(){
		alert("Time up, You Lose. Back to lobby");
		window.location="{!! url('/lobby'); !!}";				
	}

	function playerWithdraw(){
		$.get("{!!url('playerwithdraw')!!}", function(data) {
       		clearTimeout(timeup);
			update = "WITHDRAW.";
			$("#info").append(update);
			$("#panelInfo").animate({scrollTop: $('#panelInfo').height()}, 1000);
			saveInfo(update);
			alert("WITHDRAW, YOU LOSE. Back to lobby");
			window.location="{!! url('/lobby'); !!}";
		});
	}
</script>
@endif
@if($status=="Spectator")
	<script>
		var player;

		function getIdPlayer(){
			$.get("{!!url('getidplayer')!!}", function(data) {
				player = data;
			});
		}
		function pollMove(){
			$.get("{!!url('updateinfo')!!}", function(data) {
				var res = "";
				for(i=0; i<data.length; i++){
					res += data[i];	
				}
				$("#info").html("");
				$("#info").append(res);
				$("#panelInfo").animate({scrollTop: $('#panelInfo').height()}, 1000);
			});
			setTimeout(pollMove, 3000);
		}
		function pollBoard(){
			$.get("{!!url('updateboard')!!}", function(data) {
				var res = data;
				for(i=0; i<res.length; i++){
					var canvas = document.getElementById(res[i].col);
					var ctx=canvas.getContext("2d");
					ctx.font="40px Arial";
					ctx.textAlign = "center";
					if(res[i].user_id==player){
						ctx.fillText("X", canvas.width/2, canvas.height/2);		
					}else if(res[i].user_id==null){						
						ctx.fillText("", canvas.width/2, canvas.height/2);	
					}else{
						ctx.fillText("O", canvas.width/2, canvas.height/2);	
					}	
				}
			});
			setTimeout(pollBoard, 3000);
		}
		getIdPlayer();
		setTimeout(pollMove, 3000);
		setTimeout(pollBoard, 3000);

	</script>
@endif
@endsection