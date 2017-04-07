<?php

use Illuminate\Database\Seeder;
use App\Home;

class HomesTableSeeder extends Seeder
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
            $home = [
                'user_id' => $faker->numberBetween(1, $users->count() - 1),
                'name' => $faker->sentence($faker->numberBetween(2, 4)),
                'description' => $faker->realText($faker->numberBetween(60, 200)),
                'price' => $faker->numberBetween(20000000, 400000000)
            ];

            Home::create($home);
        }
    }
}
