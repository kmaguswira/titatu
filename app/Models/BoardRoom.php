<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BoardRoom extends Model
{
    protected $table = 'board_rooms';

    protected $fillable = ['room_id', 'user_id', 'col', 'created_at', 'updated_at'];

	public function User()
	{
	    return $this->belongsTo('App\Models\User', 'user_id', 'id');
	}

	public function Room()
	{
	    return $this->belongsTo('App\Models\Room', 'room_id', 'id');
	}

}
