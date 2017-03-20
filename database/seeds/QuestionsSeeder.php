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
	            'content' => $faker->sentence($faker->numberBetween(4, 10))
	        ];

	        Question::create($project);
        }
    }
}
