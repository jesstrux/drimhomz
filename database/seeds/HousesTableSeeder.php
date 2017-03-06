<?php

use App\House;
use Illuminate\Database\Seeder;
use ColorThief\ColorThief;

class HousesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	$faker = Faker\Factory::create();
    	$projects = App\Project::all()->modelKeys();

    	for ($i=1; $i < 50; $i++) {
            $ext = $i%18;
            $image_url = "images/slideshow/slide$ext.jpg";

            try{
                $dominantColor = ColorThief::getColor("public/" . $image_url);
            }
            catch (Exception $e) {
                $dominantColor = array(0,0,0);
            }

            // $hsl = RGBToHSL($dominantColor);
            $dominantColor = "rgb(".implode(", ", $dominantColor).")";

			$house = [
	        	'image_url' => $image_url,
	        	'title' => $faker->realText(10),
	        	'description' => $faker->realText(),
	        	'placeholder_color' => $dominantColor,
	        	'project_id' => $projects[$faker->numberBetween(0, count($projects) - 1)]
	        ];

	        House::create($house);
		}
    }
}
