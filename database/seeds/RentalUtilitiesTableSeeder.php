<?php

use Illuminate\Database\Seeder;
use App\RentalUtility;

class RentalUtilitiesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create();
        $rentals = App\Rental::all()->modelKeys();
        $utilities = App\Utility::all()->modelKeys();

        for ($i=0; $i < count($rentals); $i++) {
            for ($j=0; $j < 5; $j++) {
                $utility = [
                    'rental_id' => $rentals[$i],
                    'utility_id' => $utilities[$faker->unique($reset = true)->numberBetween(1, count($utilities) - 1)],
                    'count' => rand(1, 3)
                ];

                RentalUtility::create($utility);
            }
        }
    }
}
