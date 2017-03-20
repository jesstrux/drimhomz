<?php

use App\ArticleComment;
use Illuminate\Database\Seeder;

class ArticleCommentsSeeder extends Seeder
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
        $articles = App\Article::all()->modelKeys();

        for ($i=0; $i < 50; $i++) {
            $comment = [
                'user_id' => $users[$faker->numberBetween(0, count($users) - 1)],
                'article_id' => $articles[$faker->numberBetween(0, count($articles) - 1)],
                'content' => $faker->realText($faker->numberBetween(10, 40))
            ];
            ArticleComment::create($comment);
        }
    }
}
