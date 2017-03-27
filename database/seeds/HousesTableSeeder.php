<?php

use App\House;
use App\HouseImage;
use Illuminate\Database\Seeder;
use ColorThief\ColorThief;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\File;

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
            $orgPath = public_path('images/uploads/houses/');
            $image = Image::make($orgPath . $ext);
            $destinationPath = storage_path('app/public/uploads/houses');
            if(!File::exists($destinationPath)) File::makeDirectory($destinationPath, 0777,true);
            $image->save($destinationPath .'/'.$ext);

            $image_sizes = new \stdClass();
            $image_sizes->width = $image->width();
            $image_sizes->height = $image->height();

            $img = Image::make($image->basePath());
            $thumb_path = $destinationPath.'/thumbs/'.$ext;
            if(!File::exists($destinationPath.'/thumbs/')) File::makeDirectory($destinationPath.'/thumbs/', 0777,true);

            $img->resize(rand (400, 800), null, function ($constraint) {
                $constraint->aspectRatio();
            })->save($thumb_path);

            $image_sizes->width_thumb = $img->width();
            $image_sizes->height_thumb = $img->height();

            return [
                "image_sizes" => $image_sizes,
                "color" => $img->limitColors(1)->pickColor(0, 0, 'hex')
            ];
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

            $more_info = saveThumb($image_url);
            $image_sizes = $more_info["image_sizes"];

			$house = [
	        	'title' => $faker->realText(10),
                'image_url' => $image_url,
                'placeholder_color' => $more_info["color"],
                'description' => $faker->realText(),
	        	'project_id' => $projects[$faker->numberBetween(0, count($projects) - 1)]
	        ];

	        $new_house = House::create($house);

            if($new_house){
                $house_image = [
                    'house_id' => $new_house->id,
                    'width' => $image_sizes->width,
                    'height' => $image_sizes->height,
                    'width_thumb' => $image_sizes->width_thumb,
                    'height_thumb' => $image_sizes->height_thumb
                ];

                HouseImage::create($house_image);
            }
		}
    }
}
