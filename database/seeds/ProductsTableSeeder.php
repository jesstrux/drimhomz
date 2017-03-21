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
	        	'shop_id' => $shops[$faker->numberBetween(0, count($shops) - 1)]
	        ];

	        Product::create($product);
		}
    }
}
