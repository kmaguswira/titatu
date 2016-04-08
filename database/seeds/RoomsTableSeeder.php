<?php

use Illuminate\Database\Seeder;

class RoomsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for($i=1; $i<=5; $i++){
	        DB::table('rooms')->insert([
	            'room_name' => 'rooms'.$i,
	            'user_id' => $i + 3,
	        ]);
	    }
    }
}
