<?php

use App\Answer;
use Illuminate\Database\Seeder;

class AnswersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create();
        $users = App\User::all()->modelKeys();
        $questions = App\Question::all()->modelKeys();

        for ($i=0; $i < 50; $i++) {
            $comment = [
                'user_id' => $users[$faker->numberBetween(0, count($users) - 1)],
                'question_id' => $questions[$faker->numberBetween(0, count($questions) - 1)],
                'content' => $faker->realText($faker->numberBetween(10, 40))
            ];
            Answer::create($comment);
        }
    }
}
