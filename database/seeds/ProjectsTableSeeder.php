<?php

use App\Project;
use Illuminate\Database\Seeder;

class ProjectsTableSeeder extends Seeder
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
	            'title' => $faker->sentence($faker->numberBetween(2, 4))
	        ];

	        Project::create($project);
        }
    }
}
