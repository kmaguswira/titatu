<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\UserInfo;
use Auth;


class LeaderboardController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }
    
	public function index(){
        $statistic = UserInfo::where('user_id', Auth::User()->id)->get();
        $leaderboards = UserInfo::orderBy('total_point', 'desc')->take(10)->get();
        return view('leaderboard')->with('statistic', $statistic)->with('leaderboards', $leaderboards);
	}

}