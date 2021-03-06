<?php

use App\Product;
use Illuminate\Database\Seeder;
use ColorThief\ColorThief;

class ProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	$faker = Faker\Factory::create();
    	$shops = App\Project::all()->modelKeys();

        for ($i=0; $i < 32; $i++) {
            $product = [
	        	'name' => $faker->sentence($faker->numberBetween(2,5)),
				'price' => $faker->numberBetween(2,5),
				'image_url' => 'def.png',
				'shop_id' => $shops[$faker->numberBetween(0, count($shops) - 1)],
				'brand' => $faker->word(),
				'description' => $faker->realText($faker->numberBetween(15, 40)),
				'specification' => $faker->realText($faker->numberBetween(10, 20))
	        ];

	        Product::create($product);
		}
    }
}
