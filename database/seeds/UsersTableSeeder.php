<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for($i=1; $i<=10; $i++){
	        DB::table('users')->insert([
	            'name' => 'user'.$i,
	            'email' => 'user'.$i.'@titatu.com',
	            'password' => bcrypt('tanyague'),
	        ]);
	    }
    }
}
