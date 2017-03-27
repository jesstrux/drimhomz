<?php

use Illuminate\Database\Seeder;
use App\FollowPost;

class FollowPostTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = App\User::all()->modelKeys();
        $houses = App\House::all()->modelKeys();

        for ($i=0; $i < count($users); $i++) {
            for ($j=0; $j < count($users); $j++) {
                if($i != $j){
                    $follow = [
                        'user_id' => $users[$i],
                        'house_id' => $houses[$j]
                    ];
                    FollowPost::create($follow);
                }
            }
        }
    }
}
