<?php

use App\Shop;
use Illuminate\Database\Seeder;

class ShopsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create();
        $users = App\User::all();

        for ($i=0; $i < 30; $i++) { 
        	$shop = [
	        	'user_id' => $faker->numberBetween(1, $users->count()),
	            'name' => $faker->sentence($faker->numberBetween(2, 4)),
                'image_url' => 'def.png',
                'coords' => $faker->longitude() . ", " . $faker->latitude(),
                'location' => $faker->streetName()
	        ];

	        Shop::create($shop);
        }
    }
}
