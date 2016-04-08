<?php

use Illuminate\Database\Seeder;

class RoomUsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for($i=1; $i<=5; $i++){
	        DB::table('room_users')->insert([
	            'room_id' => $i,
	            'user_id' => $i + 3,
                'role' => 'Player',
	        ]);
	    }
    }
}
