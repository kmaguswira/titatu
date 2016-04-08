<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Room;
use App\Models\RoomPrivate;
use App\Models\RoomUser;
use App\Models\User;
use App\Models\UserInfo;
use App\Models\BoardRoom;
use App\Models\InfoPlay;
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
        $status="";
        //check room less than ten users
        if(RoomUser::where('room_id', $id)->count()<10)
        {
        	//check user not in that room, create their relation and new board
        	if(RoomUser::where('room_id', $id)->where('user_id', Auth::User()->id)->count()==0){
        		$roomUser = new RoomUser;
		        $roomUser->user_id = Auth::User()->id;
		        $roomUser->room_id = $id;
		        //check if room has no board and create board
		        if(RoomUser::where('room_id', $id)->count()==0){
		        	$roomUser->role= 'Player';
		        	for($i=0; $i<9; $i++){
		        		$board = new BoardRoom;
		        		$board->room_id =$id;
		        		$board->col=$i;
		        		$board->save();
		        	}
		        	$status="Player1";
		        }
		        //give user a role in that room
		        elseif(RoomUser::where("room_id", $id)->where('role', 'Player')->count()==1 && RoomUser::where('room_id', $id)->where('role', 'Player2')->count()==0){
		        	$roomUser->role = 'Player';
		        	$status="Player2";
		    	}else{
		    		$roomUser->role = 'Spectator';
		    		$status="Spectator";
		    	}
		        $roomUser->save();
        	}
			   return view('room')->with('room', $room)->with('status', $status);
        }else{
        	return redirect('/lobby')->with('status', 'Room is full');
        }
	}

	public function create(){
		$room = new Room;
		$room->room_name = Input::get('name');
		$room->user_id = Auth::User()->id;
		$room->save();
		//if private
		if(Input::get('isPrivate')!==null&&Input::get('password')!==""){
			$roomPrivate = new RoomPrivate;
			$roomPrivate->room_id = $room->id;
			$roomPrivate->password = Input::get('password');
			$roomPrivate->save();
		}
		return redirect('/room/'.$room->id);
	}

	public function move(){
		$index = Input::get('move');
		$room = RoomUser::where('user_id', Auth::User()->id)->get();
		$idRoom = $room[0]->room_id;
		$row = BoardRoom::where('room_id', $idRoom)->where('col', $index)->get();
		if(is_null($row[0]->user_id)){
			BoardRoom::where('room_id', $idRoom)->where('col', $index)->update(['user_id'=>Auth::User()->id]);
			
			$cols = BoardRoom::where('room_id', $idRoom)->get();
			// check winner
			if(
				($cols[0]->user_id==Auth::User()->id&&$cols[1]->user_id==Auth::User()->id&&$cols[2]->user_id==Auth::User()->id) ||
				($cols[3]->user_id==Auth::User()->id&&$cols[4]->user_id==Auth::User()->id&&$cols[5]->user_id==Auth::User()->id) ||
				($cols[6]->user_id==Auth::User()->id&&$cols[7]->user_id==Auth::User()->id&&$cols[8]->user_id==Auth::User()->id) ||
				($cols[0]->user_id==Auth::User()->id&&$cols[3]->user_id==Auth::User()->id&&$cols[6]->user_id==Auth::User()->id) ||
				($cols[1]->user_id==Auth::User()->id&&$cols[4]->user_id==Auth::User()->id&&$cols[7]->user_id==Auth::User()->id) ||
				($cols[2]->user_id==Auth::User()->id&&$cols[5]->user_id==Auth::User()->id&&$cols[8]->user_id==Auth::User()->id) ||
				($cols[0]->user_id==Auth::User()->id&&$cols[4]->user_id==Auth::User()->id&&$cols[8]->user_id==Auth::User()->id) ||
				($cols[6]->user_id==Auth::User()->id&&$cols[4]->user_id==Auth::User()->id&&$cols[2]->user_id==Auth::User()->id)
				){
				$moves = RoomUser::where('room_id', $idRoom)->get();
				$idOpponent="";
				foreach ($moves as $move) {
					if($move->user_id!=Auth::User()->id&&$move->user_id!=null)
						$idOpponent = $move->user_id;
				}
				$user = UserInfo::where('user_id', Auth::User()->id)->get();
				$totalPointUser = (($user[0]->win+1) * 15) + ($user[0]->draw * 10) + ($user[0]->lose * 5);
				$opponent = UserInfo::where('user_id', $idOpponent)->get();
				$totalPointOpponent = ($opponent[0]->win * 15) + ($opponent[0]->draw * 10) + (($opponent[0]->lose + 1) * 5);
				UserInfo::where('user_id', Auth::User()->id)->update(['win'=>$user[0]->win+1, 'total_point'=>$totalPointUser]);
				UserInfo::where('user_id', $idOpponent)->update(['lose'=>$opponent[0]->lose+1, 'total_point'=>$totalPointOpponent]);
				
				return "winner";
			}
			// check board full or not, if full its mean tie
			if(BoardRoom::where('room_id', $idRoom)->where('user_id', null)->count()==0){
				$moves = RoomUser::where('room_id', $idRoom)->get();
				$idOpponent="";
				foreach ($moves as $move) {
					if($move->user_id!=Auth::User()->id&&$move->user_id!=null)
						$idOpponent = $move->user_id;
				}
				$user = UserInfo::where('user_id', Auth::User()->id)->get();
				$opponent = UserInfo::where('user_id',$idOpponent)->get();
				
				UserInfo::where('user_id', Auth::User()->id)->update(['draw'=>$user[0]->draw+1, 'total_point'=>($user[0]->win*15)+($user[0]->lose*5)+(($user[0]->draw+1)*10)]);
				UserInfo::where('user_id', $idOpponent)->update(['draw'=>$opponent[0]->draw+1, 'total_point'=>($opponent[0]->win*15)+($opponent[0]->lose*5)+(($opponent[0]->draw+1)*10)]);
				
				return "tie";
			}
			// next turn to player 2
			else{
				return "next";
			}
		}
		// move already taken by other player
		else{
			return 'already';
		}
	}

	public function ready(){
		RoomUser::where('user_id', Auth::User()->id)->update(['role'=>'Player2']);
		return "success";
	}

	public function waitPlayer(){
		$room = RoomUser::where('user_id', Auth::User()->id)->get();
		$idRoom = $room[0]->room_id;

		if(RoomUser::where('room_id', $idRoom)->where('role', 'Player2')->count()==1)
			return 'success';
		else
			return 'failed';
	}

	public function countdown(){
		$room = RoomUser::where('user_id', Auth::User()->id)->get();
		$idRoom = $room[0]->room_id;
		return BoardRoom::where('room_id', $idRoom)->where('user_id', null)->count();
	}

	public function runaway(){
		$user = UserInfo::where('user_id', Auth::User()->id)->get();
		UserInfo::where('user_id', Auth::User()->id)->update(['win'=>$user[0]->win+1,'total_point'=>(($user[0]->win+1)*15)+($user[0]->lose*5)+($user[0]->draw*10)]);
	}

	public function saveinfoplay(){
		$room = RoomUser::where('user_id', Auth::User()->id)->get();
		$idRoom = $room[0]->room_id;

		$info = new InfoPlay;
		$info->room_id = $idRoom;
		$info->move = Input::get('move');
		$info->save();
		return "move saved";
	}

	public function updateboard(){
		$room = RoomUser::where('user_id', Auth::User()->id)->get();
		$idRoom = $room[0]->room_id;

		$boards = BoardRoom::where('room_id', $idRoom)->orderBy('col', 'asc')->get();
		$response = array();
		foreach ($boards as $board) {
					array_push($response, ['col'=>$board->col, 'user_id'=>$board->user_id]);
				}
		return $response;		
	}

	public function updateinfo(){
		$room = RoomUser::where('user_id', Auth::User()->id)->get();
		$idRoom = $room[0]->room_id;

		$infos = InfoPlay::where('room_id', $idRoom)->get();
		$response = array();
		foreach ($infos as $info) {
			array_push($response, $info->move);
		}
		return $response;		
	}

	public function playerwithdraw(){
		$room = RoomUser::where('user_id', Auth::User()->id)->get();
		$idRoom = $room[0]->room_id;
		$moves = RoomUser::where('room_id', $idRoom)->get();
		$idOpponent="";
		foreach ($moves as $move) {
			if($move->user_id!=Auth::User()->id&&$move->user_id!=null)
				$idOpponent = $move->user_id;
		}
		$user = UserInfo::where('user_id', Auth::User()->id)->get();
		$opponent = UserInfo::where('user_id',$idOpponent)->get();
		UserInfo::where('user_id', Auth::User()->id)->update(['lose'=>$user[0]->lose+1, 'total_point'=>($user[0]->win*15)+(($user[0]->lose+1)*5)+($user[0]->draw*10)]);
		UserInfo::where('user_id', $idOpponent)->update(['win'=>$opponent[0]->win+1, 'total_point'=>(($opponent[0]->win+1)*15)+($opponent[0]->lose*5)+($opponent[0]->draw*10)]);
	}

	public function getidplayer(){
		$room = RoomUser::where('user_id', Auth::User()->id)->get();
		$idRoom = $room[0]->room_id;
		$response = Room::find($idRoom);
		$res = $response->user_id;
		return $res;
	}
}