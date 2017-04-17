<?php

use App\Project;
use App\ProjectPersonel;
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

	        $new_project = Project::create($project);

            if($new_project){
                $user  = [
                    'project_id'=> $new_project->id,
                    'user_id'=> $new_project->user_id,
                    'position'=> "owner"
                ];

	            ProjectPersonel::create($user);
            }
        }
    }
}
