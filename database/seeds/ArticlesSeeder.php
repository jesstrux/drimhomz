<?php

use Illuminate\Database\Seeder;
use App\Article;
class ArticlesSeeder extends Seeder
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
        	$project = [
	        	'user_id' => $faker->numberBetween(1, $users->count()),
	            'title' => $faker->sentence($faker->numberBetween(2, 4)),
	            'content' => $faker->realText($faker->numberBetween(240, 570))
	        ];

            $imageable = Article::create($project);

            if($imageable){
                $house_image = [
                    'url' => "rental" .$i % 4 .".jpg",
                    'placeholder_color' => $faker->hexColor(),
                    'caption' => $faker->realText(15)
                ];

	            $owner = Article::find($imageable->id);
                $owner->images()->create($house_image);
            }
        }
    }
}
