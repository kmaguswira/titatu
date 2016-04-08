<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserInfo extends Model
{
    protected $table = 'user_infos';

    protected $primaryKey = 'user_id';

    protected $fillable = ['user_id', 'win', 'lose', 'draw', 'created_at', 'updated_at'];

	public function User()
	{
	    return $this->belongsTo('App\Models\User', 'user_id', 'id');
	}

}
