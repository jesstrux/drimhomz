<?php

use App\Page;
use Illuminate\Database\Seeder;

class PagesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $pages = ["Dashboard", "Home", "About", "Shop", "Expert", "Advice", "Profile"];
        $urls  = ["/dashboard", "/", "/about", "/shop", "/expert", "/advice", "/profile"];

        for ($i=0; $i < 7; $i++) {

			$page = [
	        	'title' => $pages[$i],
	        	'url' => $urls[$i],
	        ];

	        Page::create($page);
		}
    }
}
