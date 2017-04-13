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
	            'name' => $faker->sentence($faker->numberBetween(4, 6)),
                'image_url' => 'def.png',
                'town' => $faker->streetName(),
                'street' => $faker->city(),
                'city' => $faker->city(),
                'country' => $faker->country(),
                'quality_statement' => $faker->realText($faker->numberBetween(20, 50)),
                'service_statement' => $faker->realText($faker->numberBetween(20, 50)),
	        ];

	        Shop::create($shop);
        }
    }
}
