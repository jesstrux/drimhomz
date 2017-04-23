<?php

use Illuminate\Database\Seeder;
use App\Plot;

class PlotsTableSeeder extends Seeder
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
        $rental_types = [
            "Valley (Bondeni)", "Level ground (Tambalale)",
            "Hill land (Kilimani)",
            "Shrubs (Vichaka)", "Forestry (Msitu)",
            "Steep land (mteremkoni)"];

        for ($i=0; $i < 30; $i++) {
            $home = [
                'user_id' => $users[$faker->numberBetween(0, count($users) - 1)],
                'name' => $faker->sentence($faker->numberBetween(2, 4)),
                'description' => $faker->realText($faker->numberBetween(60, 200)),
                'price' => $faker->numberBetween(20000000, 400000000),
                'topographical_nature' => $rental_types[rand(0, 5)]
            ];

            $imageable = Plot::create($home);

            if($imageable){
                $house_image = [
                    'url' => "plot" .$i % 4 .".jpg",
                    'placeholder_color' => $faker->hexColor(),
                    'caption' => $faker->realText(15)
                ];

                $imageable->images()->create($house_image);
            }
        }
    }
}
