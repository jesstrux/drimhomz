<?php

use App\Question;
use Illuminate\Database\Seeder;

class QuestionsSeeder extends Seeder
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
	            'content' => $faker->realText($faker->numberBetween(40, 270))
	        ];

            $project['slug'] = str_slug($project['title']);
            $imageable = Question::create($project);

            if($imageable){
                $house_image = [
                    'url' => "home" .$i % 4 .".jpg",
                    'placeholder_color' => $faker->hexColor(),
                    'caption' => $faker->realText(15)
                ];

                $imageable->images()->create($house_image);
            }
        }
    }
}
