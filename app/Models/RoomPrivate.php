<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RoomPrivate extends Model
{
    protected $table = 'room_privates';

    protected $primaryKey = 'room_id';

    protected $fillable = ['password', 'created_at', 'updated_at'];

    protected $hidden = ['password'];

	public function Room()
	{
	    return $this->belongsTo('App\Models\Room', 'room_id', 'id');
	}

}