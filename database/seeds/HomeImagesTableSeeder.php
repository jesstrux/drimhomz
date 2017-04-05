<?php

use Illuminate\Database\Seeder;
use App\HomeImage;

class HomeImagesTableSeeder extends Seeder
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

        for ($i=0; $i < count($homes); $i++) {
            $image = [
                'home_id' => $homes[$i],
                'image_url' => "home" .$i % 6 .".jpg",
                'placeholder_color' => $faker->hexColor(),
                'caption' => $faker->realText(15)
            ];

            HomeImage::create($image);
        }
    }
}
