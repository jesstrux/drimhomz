<?php

use Illuminate\Database\Seeder;
use App\RentalImage;

class RentalImagesTableSeeder extends Seeder
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

        for ($i=0; $i < count($rentals); $i++) {
            $image = [
                'rental_id' => $rentals[$i],
                'image_url' => "rental" .$i % 4 .".jpg",
                'placeholder_color' => $faker->hexColor(),
                'caption' => $faker->realText(15)
            ];

            RentalImage::create($image);
        }
    }
}
