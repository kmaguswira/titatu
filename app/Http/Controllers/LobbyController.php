<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Room;
use App\Models\RoomUser;
use App\Models\User;
use Auth;


class LobbyController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }
    
	public function index(){
        $rooms = Room::all();
        $users = User::all();
        $count = RoomUser::where('user_id', Auth::User()->id)->get(); 
        if( $count->count() > 0){
            if(Room::where('id', $count[0]->room_id)->count()==1){ 
                Room::where('id', $count[0]->room_id)->delete();
            }
            RoomUser::where('user_id', Auth::User()->id)->delete();
        }
        return view('lobby')->with('rooms', $rooms)->with('users', $users);
	}

}