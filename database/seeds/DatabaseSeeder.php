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
        $this->call(FollowsTableSeeder::class);
        $this->call(ProjectsTableSeeder::class);
        $this->call(HousesTableSeeder::class);
        $this->call(CommentsTableSeeder::class);
        $this->call(FavoritesTableSeeder::class);
    }
}
