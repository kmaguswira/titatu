<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Room;
use App\Models\RoomPrivate;
use App\Models\RoomUser;
use App\Models\User;
use Auth;
use Illuminate\Support\Facades\Input;


class RoomController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }
    
	public function index($id){
        $room = Room::find($id);
        if(RoomUser::where('room_id', $id)->count()<10)
        {
	        $roomUser = new RoomUser;
	        $roomUser->user_id = Auth::User()->id;
	        $roomUser->room_id = $id;
	        $roomUser->save();
	        return view('room')->with('room', $room);
        }else{
        	return redirect('/lobby')->with('status', 'Room is full');
        }
	}

	public function create(){
		$room = new Room;
		$room->room_name = Input::get('name');
		$room->user_id = Auth::User()->id;
		$room->save();
		if(Input::get('isPrivate')!==null&&Input::get('password')!==""){
			$roomPrivate = new RoomPrivate;
			$roomPrivate->room_id = $room->id;
			$roomPrivate->password = Input::get('password');
			$roomPrivate->save();
		}
		return redirect('/room/'.$room->id);
	}

}