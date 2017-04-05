<?php

use Illuminate\Database\Seeder;
use App\HomeUtility;

class HomeUtilitiesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create();
        $homes = App\Home::all()->modelKeys();
        $utilities = App\Utility::all()->modelKeys();

        for ($i=0; $i < count($homes); $i++) {
            for ($j=0; $j < 5; $j++) {
                $utility = [
                    'home_id' => $homes[$i],
                    'utility_id' => $utilities[$faker->unique($reset = true)->numberBetween(1, count($utilities) - 1)],
                    'count' => rand(1, 3)
                ];

                HomeUtility::create($utility);
            }
        }
    }
}
