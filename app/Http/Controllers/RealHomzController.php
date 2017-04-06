<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Home;
use App\Plot;
use App\Rental;
use App\HomeUtility;
use App\Utility;

class RealHomzController extends Controller
{
    public function index($page){
        $pages = ["homes", "plots", "rentals"];

        if(!in_array($page, $pages))
            $page = "homes";

        $list = null;
        switch($page){
            case "homes": {
                $list = Home::with('images')->orderBy('created_at', 'desc')->get();
                break;
            }

//        case "plots": {
//            $list = Plot::all();
//            break;
//        }
//
//        case "rentals": {
//            $list = Rental::all();
//            break;
//        }
        }
        return view('realhomz.index', compact('page', 'list'));
    }

    public function create_home(Request $request){
//        if(Auth::guest() || Auth::user()->role != 'realtor'){
//            return response()->json([
//                'success' => false,
//                'msg' => 'You have to be registered as a realtor and logged in to add a home.'
//            ]);
//        }

        $home = [
            'user_id' => $request->input('user_id'),
            'name' => $request->input('name'),
            'description' => $request->input('description'),
            'price' => $request->input('price')
        ];

        $home_exists = Home::where([
            'user_id' => $request->input('user_id'),
            'name' => $request->input('title')])->exists();

        if($home_exists){
            return response()->json([
                'success' => false,
                'msg' => 'You already have a home called ' . $request->input('name')
            ]);
        }

        $new_home = Home::create($home);

        if($new_home)
            return response()->json([
                'success' => true,
                'home' => $new_home
            ]);
        else
            return response()->json([
                'success' => false,
                'msg' => 'Failed to save home'
            ]);
    }

    public function new_profile($page, $id){
        return $this->profile($page, $id, true);
    }

    public function profile($page, $id, $is_new = false){
        $pages = ["homes", "plots", "rentals"];

        if(!in_array($page, $pages))
            $page = "homes";

        $real = new \stdClass();

        switch($page){
            case "homes": {
                $real = Home::with("images")->find($id);
                break;
            }

//        case "plots": {
//            $list = Plot::all();
//            break;
//        }
//
//        case "rentals": {
//            $list = Rental::all();
//            break;
//        }
        }

        return view('realhomz.single', compact('page', 'real', 'is_new'));
    }

    public function add_rooms(Request $request){
        $home_id = $request->input("home_id");
        $utility_ids = $request->get("utility_id");
        $utility_counts = $request->get("count");

        for ($j=0; $j < count($utility_ids); $j++) {
            $utility = [
                "home_id" => $home_id,
                "utility_id" => $utility_ids[$j],
                "count" => (int) $utility_counts[$j]
            ];

            $room_created = HomeUtility::create($utility);

            if(!$room_created) {
                return response()->json([
                    "success" => false,
                    "msg" => "Coulnd't add rooms to home"
                ]);
                break;
            }

        }

        $new_rooms = Utility::whereIn("id", $utility_ids)->get();

        return response()->json([
            "success" => true,
            "rooms" => $new_rooms,
            "counts" => $utility_counts,
            "msg" => "Successfully Added rooms to home"
        ]);
    }

    public function remove_room(Request $request){
        $home_utility_id = $request->get("home_utility_id");
        $home_utility = HomeUtility::find($home_utility_id);
        if($home_utility->delete())
            return response()->json([
                "success" => true,
                "msg" => "Successfully removed room."
            ]);
        else
            return response()->json([
                "success" => false,
                "msg" => "Coulnd't remove room."
            ]);
    }
}
