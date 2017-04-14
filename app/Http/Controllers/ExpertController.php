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
        $rating = [
            'rating' => $request->input("rating"),
            'comment' => $request->input("comment"),
            'user_id' => $request->input("user_id")
        ];

        if(User::find($request->input("expert_id"))->create($rating)){
            return response()->json([
                "success" => true,
                "msg" => "Successfully rated expert."
            ]);
        }else{
            return response()->json([
                "success" => false,
                "msg" => "Coulnd't rate expert."
            ]);
        }
    }
}
