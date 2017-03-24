<?php

use App\House;
use Illuminate\Database\Seeder;
use ColorThief\ColorThief;
use Intervention\Image\Facades\Image;

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

        function saveThumb($ext){
            $destinationPath = public_path('images/uploads/houses/');
            $thumbPath = $destinationPath.'thumbs/';
            $real_path = $thumbPath . $ext;

            $img = Image::make($destinationPath . $ext);
            $img->resize(600, 600, function ($constraint) {
                $constraint->aspectRatio();
            })->save($real_path);

            return getColor($real_path);
        }

        function getColor($image_url){
            try{
                $dominantColor = ColorThief::getColor($image_url);
            }
            catch (Exception $e) {
                $dominantColor = array(0,0,0);
            }

            return "rgb(".implode(", ", $dominantColor).")";
        }

    	for ($i=0; $i < 32; $i++) {
            // $ext = $i%31;
            $image_url = "slide$i.jpg";

            $dominantColor = saveThumb($image_url);

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
