<?php

use App\Follows;
use Illuminate\Database\Seeder;

class FollowsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	$faker = Faker\Factory::create();
        $users = App\User::all()->modelKeys();
        $user_count = count($users);
        // $len = $user_count * $user_count - 1;
        // Illuminate\Database\Eloquent\Collection
        $follow_list = array();
        $follower_list = array();

        for ($i=0; $i < count($users); $i++) { 
        	for ($j=0; $j < count($users); $j++) { 
        		if($i != $j){
        			$follow = [
			        	'user_id' => $users[$i],
			            'followed_id' => $users[$j]
			        ];
			        Follows::create($follow);
        		}
        	}
        }
    }
}
