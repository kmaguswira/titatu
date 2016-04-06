<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RoomUser extends Model
{
    protected $table = 'room_users';

    protected $fillable = ['room_id', 'user_id', 'created_at', 'updated_at'];

	public function User()
	{
	    return $this->belongsTo('App\Models\User', 'user_id', 'id');
	}

	public function Room()
	{
	    return $this->belongsTo('App\Models\Room', 'room_id', 'id');
	}

}
