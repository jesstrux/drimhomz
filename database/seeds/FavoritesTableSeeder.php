<?php

use App\Favorite;
use Illuminate\Database\Seeder;

class FavoritesTableSeeder extends Seeder
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
        $houses = App\House::all()->modelKeys();

        for ($i=0; $i < 50; $i++) {
        	$favorite = [
	        	'user_id' => $users[$faker->numberBetween(0, count($users) - 1)],
	            'house_id' => $houses[$faker->numberBetween(0, count($houses) - 1)]
	        ];
	        Favorite::create($favorite);
        }
    }
}
