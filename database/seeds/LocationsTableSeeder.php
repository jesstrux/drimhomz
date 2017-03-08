<?php

use Illuminate\Database\Seeder;
use App\Location;
class LocationsTableSeeder extends Seeder
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

        for ($i=0; $i < count($users); $i++) { 
        	$location = [
	        	'user_id' => $users[$i],
	            'long' => $faker->longitude(),
	            'lat' => $faker->latitude()
	        ];

	        Location::create($location);
        }
    }
}
