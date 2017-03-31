<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class ExpertController extends Controller
{
    public function index()
    {
    	$experts = User::where("role", "<>" , "user")->where("role", "<>" , "admin")->get();
		return view('expert.index', compact('experts'));
    }

    public function rate_expert(Request $request){
        return $request->toArray();
//        'rating', 'comment', 'user_id', 'expert_id'
//        $rating = [
//            'rating' =>
//        ];
//        if($user_id != $new_follow->house->owner()->id)
//            User::find($new_follow->house->owner()->id)->notify(new PostFollowed($new_follow->user, $new_follow->house));
    }
}
