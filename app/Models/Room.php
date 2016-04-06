<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    protected $table = 'rooms';

    protected $primaryKey = 'id';

    protected $fillable = ['room_name', 'user_id', 'created_at', 'updated_at'];

	public function User()
	{
	    return $this->belongsTo('App\Models\User', 'user_id', 'id');
	}

	public function RoomPrivate()
	{
		return $this->hasOne('App\Models\RoomPrivate', 'room_id', 'id');
	}

	public function RoomUser()
	{
		return $this->hasMany('App\Models\RoomUser', 'room_id', 'id');
	}
}
