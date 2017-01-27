<?php

namespace App\Http\Controllers;

use App\House;
use App\User;
use Illuminate\Http\Request;

class HousesController extends Controller
{
    public function index(){
    	return view('houses.index');
    }

    public function randomList($page){
        $houses_per_page = 15;
    	$db_values = House::all();
		$len = count($db_values) - 1;
		$values = array();

        if($page > count(House::all())/$houses_per_page)
            return "No more";

		for ($i = $page - 1; $i < $houses_per_page * $page; $i++) {
			// $rand = rand ( 0 , $len );
			$value = $db_values[$i];
            $owner = User::find($value->user_id);
            // $value->user_name = $owner->full_name();
            $value->user_dp = $owner->dp;
            $value->user_name = $owner->fname." ".$owner->lname;
		  	$values []= $value;
		}
        
		return $values;
    }

    public function store(Request $request){
    	// $house = [
     //    	'image_url' => 'images/slideshow/slide'.$i.'.jpg',
     //    	'title' => $faker->realText(10),
     //    	'description' => $faker->realText(),
     //    	'placeholder_color' => $faker->hexcolor,
     //    	'fav_count' => $faker->numberBetween(0, 90),
     //    	'comment_count' => $faker->numberBetween(0, 50),
     //    	'user_id' => $faker->numberBetween(1, 3),
     //    ];

     //    House::create($house);
    	return $request->all();
    }
}
