<?php

use App\AdView;
use Illuminate\Database\Seeder;

class AdViewsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create();
        $ads = App\Advertisement::all()->modelKeys();
        $users = App\User::all()->modelKeys();
        $user_count = count($users);

        for ($i=0; $i < count($ads); $i++) {
        	for ($j=0; $j < 3; $j++) { 
        		$ad_view = [
		        	'user_id' => $users[$faker->numberBetween(0, count($users) - 1)],
		            'advertisement_id' => $ads[$i]
		        ];

		        AdView::create($ad_view);
        	}
        }
    }
}
