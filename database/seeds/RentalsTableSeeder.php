<?php

use Illuminate\Database\Seeder;
use App\Rental;

class RentalsTableSeeder extends Seeder
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
        $rental_types = ["Apartment", "Hotel", "Hostel"];

        for ($i=0; $i < 30; $i++) {
            $home = [
                'user_id' => $users[$faker->numberBetween(0, count($users) - 1)],
                'name' => $faker->sentence($faker->numberBetween(2, 4)),
                'description' => $faker->realText($faker->numberBetween(60, 200)),
                'price' => $faker->numberBetween(20000000, 400000000),
                'rental_type' => $rental_types[rand(0, 2)]
            ];

            Rental::create($home);
        }
    }
}
