<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InfoPlay extends Model
{
    protected $table = 'info_plays';

    protected $fillable = ['room_id', 'move', 'created_at', 'updated_at'];

	public function Room()
	{
	    return $this->belongsTo('App\Models\Room', 'room_id', 'id');
	}

}
