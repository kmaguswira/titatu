<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Room;
use App\Models\RoomUser;
use App\Models\User;
use App\Models\Chat;
use Auth;
use Illuminate\Support\Facades\Input;


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
            if(RoomUser::where('room_id', $count[0]->room_id)->count()==1){ 
                Room::where('id', $count[0]->room_id)->delete();
            }
            if($count[0]->role == 'Player'){
                $update = RoomUser::where('room_id', $count[0]->room_id)->where('role', 'Spectator')->orderBy('created_at', 'asc')->take(1)->update(['role' => "Player"]);
            }
            RoomUser::where('user_id', Auth::User()->id)->delete();
        }
        $chats = Chat::orderBy('created_at', 'desc')->take(10)->get();
        return view('lobby')->with('rooms', $rooms)->with('users', $users)->with('chats', $chats);
	}

    public function sendChat(){
        $chat = new Chat;
        $chat->user_id=Auth::User()->id;
        $chat->chat=Input::get('chat');
        $chat->save();
        return "success";
    } 

    public function getChat($last){
        if($last < Chat::all()->count())
        {
            $response = array();
            $news = Chat::where('id', ">", $last)->get();
            foreach($news as $new){
                $new->user_id = $new->User->name;
                array_push($response, $new);
            } 
            return $response;
        }
    }

    public function getRoom(){
        $rooms = Room::all();
        $response = array();
        foreach ($rooms as $room) {
            $room->username = $room->User->name;
            $room->isprivate = $room->RoomPrivate ? "Private" : "Public";
            array_push($response, $room); 
        }
        return $response;
    }

    public function seeinside($id){
        $response =array();
        $users = RoomUser::where('room_id', $id)->get();

        foreach ($users as $user) {
            array_push($response, ['username' => $user->User->name, 'role' => $user->role]);
        }
        return $response;
    }

}