<?php

use App\House;
use Illuminate\Database\Seeder;

class HousesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	$faker = Faker\Factory::create();

    	for ($i=1; $i < 19; $i++) {

			$house = [
	        	'image_url' => 'images/slideshow/slide'.$i.'.jpg',
	        	'title' => $faker->realText(10),
	        	'description' => $faker->realText(),
	        	'placeholder_color' => $faker->hexcolor,
	        	'fav_count' => $faker->numberBetween(0, 90),
	        	'comment_count' => $faker->numberBetween(0, 50),
	        	'user_id' => $faker->numberBetween(1, 3),
	        ];

	        House::create($house);
		}
    }
}
