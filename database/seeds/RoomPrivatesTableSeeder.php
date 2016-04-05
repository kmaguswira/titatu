<?php

use Illuminate\Database\Seeder;

class RoomPrivatesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
		for($i=1; $i<=2; $i++){
	        DB::table('room_privates')->insert([
	            'room_id' => $i,
	            'password' => bcrypt('tanyague'),
	        ]);
	    }        
    }
}
