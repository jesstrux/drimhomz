<?php

use App\Advertisement;
use Illuminate\Database\Seeder;

class AdvertisementsTableSeeder extends Seeder
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

        for ($i=1; $i < 19; $i++) {
        	$advertisement = [
	        	'title' => $faker->realText(10),
	            'link' => $faker->url(),
	            'image_url' => "banner$i.jpg",
                'priority' => rand(1, 5),
                'description' => $faker->realText($faker->numberBetween(20, 80))
	        ];
	        Advertisement::create($advertisement);
        }
    }
}
