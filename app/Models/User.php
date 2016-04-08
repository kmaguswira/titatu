<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];


    public function Room()
    {
        return $this->hasOne('App\Models\Room', 'user_id', 'id');
    }

    public function UserInfo()
    {
        return $this->hasOne('App\Models\UserInfo', 'user_id', 'id');
    }

    public function RoomUser()
    {
        return $this->hasOne('App\Models\RoomUser', 'id', 'user_id');
    }

    public function Chats()
    {
        return $this->hasMany('App\Models\Chat', 'id', 'user_id');

    }

    public function BoardRoom()
    {
        return $this->hasMany('App\Models\BoardRoom', 'id', 'user_id');
    }
}
