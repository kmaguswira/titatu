@extends('layout.layout')
@section('title', '| Online Game Tic Tac Toe')
@section('scriptHead')
	<script language="JavaScript">
		var result;
		var isPrivate = {!! $room->RoomPrivate !!};
		if(isPrivate&& $room->user_id !== Auth::User()->user_id){
			var password=prompt('Please enter password to join this room!',' ');
			if(password !== "{!! $room->RoomPrivate ? $room->RoomPrivate->password : '' !!}"){
				alert('WRONG PASSWORD!!');
				window.location="{!! url('/lobby'); !!}";
			}
		}
	</script>
@endsection
@section('content')
	Board TIC TAC TOE
@endsection