<?php

use Illuminate\Database\Seeder;
use App\PlotImage;

class PlotImagesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create();
        $plots = App\Plot::all()->modelKeys();

        for ($i=0; $i < count($plots); $i++) {
            $image = [
                'plot_id' => $plots[$i],
                'image_url' => "plot" .$i % 4 .".jpg",
                'placeholder_color' => $faker->hexColor(),
                'caption' => $faker->realText(15)
            ];

            PlotImage::create($image);
        }
    }
}
