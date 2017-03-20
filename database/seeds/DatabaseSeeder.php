<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(PagesTableSeeder::class);
        $this->call(UsersTableSeeder::class);
        $this->call(AdvertisementsTableSeeder::class);
        $this->call(AdViewsTableSeeder::class);
        $this->call(FollowsTableSeeder::class);
        $this->call(ProjectsTableSeeder::class);
        $this->call(HousesTableSeeder::class);
        $this->call(CommentsTableSeeder::class);
        $this->call(FavoritesTableSeeder::class);
        $this->call(LocationsTableSeeder::class);

        $this->call(ArticlesSeeder::class);
        $this->call(ArticleCommentsSeeder::class);
        $this->call(QuestionsSeeder::class);
        $this->call(AnswersSeeder::class);
    }
}
