<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    protected $table = 'chats';

    protected $primaryKey = 'id';

    protected $fillable = ['user_id', 'chat', 'created_at', 'updated_at'];

	public function User()
	{
	    return $this->belongsTo('App\Models\User', 'user_id', 'id');
	}

}
