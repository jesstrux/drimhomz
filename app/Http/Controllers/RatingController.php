<?php

namespace App\Http\Controllers;

use App\Rating;
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

		$new_rating = Rating::create($rating);

//	    return response()->json([
//		    "success" => false,
//		    "msg" => "Rating $what ". $rated_id
//	    ]);
		$newly_rated = false;

		switch($what){
			case "shop" : {
				$shop = Shop::find($rated_id);
				$newly_rated = $shop->ratings()->create(['rating_id' => $new_rating -> id, 'shop_id' => $shop -> id]);
//				return $shop->ratings()->get();

				if($newly_rated)
					if(Auth::user()->id != $newly_rated->shop_id)
						User::find($shop->user_id)->notify(new ShopRated($newly_rated, $newly_rated->user));
			}
			break;

			case "expert" : {
				$user = User::find($rated_id);
				$newly_rated = $user->ratings()->create(['rating_id' => $new_rating -> id, 'expert_id' => $user -> id]);

				if($newly_rated)
					if(Auth::user()->id != $newly_rated->expert_id)
						$user->notify(new ExpertRated($newly_rated, $newly_rated->user));
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
