<?php

namespace App\Http\Controllers;

use App\House;
use Illuminate\Http\Request;

class HousesController extends Controller
{
    public function index(){
    	return view('houses.index');
    }

    public function randomList(){
    	$db_values = House::all();
		$len = count($db_values) - 1;
		$values = array();

		for ($i=0; $i < 10; $i++) {
			$rand = rand ( 0 , $len );
			$value = $db_values[$rand];

			// echo $rand . ": ". $value->title . ", ";
			// echo '<img src="'.$value->image_url.'" alt="">';

		  	$values []= $value;
		}

		// print_r($values);
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
