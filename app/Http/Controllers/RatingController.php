<?php

namespace App\Http\Controllers;

use Auth;
use App\Notifications\ExpertRated;
use App\Notifications\ShopRated;
use App\Shop;
use App\User;
use Illuminate\Http\Request;

class RatingController extends Controller
{
	public function rate(Request $request){
		$what = $request->input("what");
		$rated_id = $request->input('rate_id');

		$rating = [
			'rating' => $request->input("rating"),
			'comment' => $request->input("comment"),
			'user_id' => $request->input("user_id")
		];

//	    return response()->json([
//		    "success" => false,
//		    "msg" => "Rating $what ". $rated_id
//	    ]);

		switch($what){
			case "shop" : {
				$newly_rated = Shop::find($rated_id)->ratings()->create($rating);

				if($newly_rated)
					if(Auth::user()->id != $newly_rated->ratable_id)
						User::find($newly_rated->ratable->user->id)->notify(new ShopRated($newly_rated, $newly_rated->user));
			}
			break;

			case "expert" : {
				$newly_rated = User::find($rated_id)->ratings()->create($rating);

				if($newly_rated)
					if(Auth::user()->id != $newly_rated->ratable_id)
						$newly_rated->ratable->notify(new ExpertRated($newly_rated, $newly_rated->user));
			}
			break;
		}

		if($newly_rated){
			return response()->json([
				"success" => true,
				"msg" => "Successfully rated $what."
			]);
		}else{
			return response()->json([
				"success" => false,
				"msg" => "Coulnd't rate $what."
			]);
		}
	}
}
