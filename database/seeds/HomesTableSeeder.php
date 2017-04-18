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
        $users = App\User::all()->modelKeys();

        for ($i=0; $i < 30; $i++) {
            $home = [
                'user_id' => $users[$faker->numberBetween(0, count($users) - 1)],
                'name' => $faker->sentence($faker->numberBetween(2, 4)),
                'description' => $faker->realText($faker->numberBetween(60, 200)),
                'price' => $faker->numberBetween(20000000, 400000000)
            ];

            $imageable = Home::create($home);

            if($imageable){
                $house_image = [
                    'url' => "rental" .$i % 4 .".jpg",
                    'placeholder_color' => $faker->hexColor(),
                    'caption' => $faker->realText(15)
                ];

                $imageable->images()->create($house_image);
            }
        }
    }
}
