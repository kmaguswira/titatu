<?php

use Illuminate\Database\Seeder;

class UserInfosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for($i=1; $i<=10; $i++){
            $win = rand(0, 10);
            $lose = rand(0, 10);
            $draw = rand(0, 10);
	        DB::table('user_infos')->insert([
	        	'user_id' => $i,
	            'win' => $win,
	            'lose' => $lose,
	            'draw' => $draw,
                'total_point' => ($win*15)+($lose*5)+($draw*10),
	        ]);
	    }
    }
}
