<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Home;
use App\HomeUtility;
use App\HomeImage;
use App\Rental;
use App\RentalUtility;
use App\RentalImage;
use App\Plot;
use App\PlotImage;
use App\Utility;
use Image;

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

            case "plots": {
                $list = Plot::with('images')->orderBy('created_at', 'desc')->get();
                break;
            }

            case "rentals": {
                $list = Rental::with('images')->orderBy('created_at', 'desc')->get();
                break;
            }
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
            'price' => $request->input('price'),
            'street' => $request->input('street'),
            'town' => $request->input('town'),
            'type' => $request->input('type'),
            'floor_count' => $request->input('floor_count')
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

    public function create_rental(Request $request){
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
            'price' => $request->input('price'),
            'rental_type' => $request->input('rental_type'),
            'street' => $request->input('street'),
            'town' => $request->input('town'),
            'type' => $request->input('type'),
            'floor_count' => $request->input('floor_count')
        ];

        $home_exists = Rental::where([
            'user_id' => $request->input('user_id'),
            'name' => $request->input('title')])->exists();

        if($home_exists){
            return response()->json([
                'success' => false,
                'msg' => 'You already have a home called ' . $request->input('name')
            ]);
        }

        $new_home = Rental::create($home);

        if($new_home)
            return response()->json([
                'success' => true,
                'rental' => $new_home
            ]);
        else
            return response()->json([
                'success' => false,
                'msg' => 'Failed to save home'
            ]);
    }

    public function create_plot(Request $request){
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
	        'street' => $request->input('street'),
	        'town' => $request->input('town'),
            'price' => $request->input('price'),
            'size' => $request->input('size'),
            'plot_number' => $request->input('plot_number'),
            'block' => $request->input('block'),
            'topographical_nature' => $request->input('topographical_nature')
        ];

        $home_exists = Plot::where([
            'user_id' => $request->input('user_id'),
            'name' => $request->input('title')])->exists();

        if($home_exists){
            return response()->json([
                'success' => false,
                'msg' => 'You already have a plot called ' . $request->input('name')
            ]);
        }

        $new_home = Plot::create($home);

        if($new_home)
            return response()->json([
                'success' => true,
                'plot' => $new_home
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
        $pages = ["home", "plot", "rental"];

        if(!in_array($page, $pages))
            $page = "home";

        $real = new \stdClass();

        switch($page){
            case "home": {
                $real = Home::with("images")->find($id);
                break;
            }

            case "plot": {
                $real = Plot::with("images")->find($id);
                break;
            }

            case "rental": {
                $real = Rental::with("images")->find($id);
                break;
            }
        }

        return view('realhomz.single', compact('page', 'real', 'is_new'));
    }

    public function add_rooms_to_home(Request $request){
        return $this->add_rooms($request, "home");
    }
    public function add_rooms_to_rental(Request $request){
        return $this->add_rooms($request, "rental");
    }
    public function add_rooms(Request $request, $where = null){
        $home_id = $request->input("home_id");
        $utility_ids = $request->get("utility_id");
        $utility_counts = $request->get("count");

//        echo "Utilties: " . count($utility_ids) . " Counts: " . count($utility_counts);
//        return;

        for ($j=0; $j < count($utility_ids); $j++) {
            $utility = [
                "utility_id" => $utility_ids[$j],
                "count" => (int) $utility_counts[$j]
            ];

            if($where == "home"){
                $utility["home_id"] = $home_id;
                $room_created = HomeUtility::create($utility);
            }else if($where == "rental"){
                $utility["rental_id"] = $home_id;
                $room_created = RentalUtility::create($utility);
            }else{
                $utility["home_id"] = $home_id;
                $room_created = HomeUtility::create($utility);
            }

            if(!$room_created) {
                return response()->json([
                    "success" => false,
                    "msg" => "Coulnd't add rooms to home"
                ]);
                break;
            }

        }

        $new_rooms = DB::table($where.'_utilities')
            ->join('utilities', 'utilities.id', '=', $where.'_utilities.utility_id')
            ->join($where.'s', $where.'s.id', '=', $where.'_utilities.'.$where.'_id')
            ->where([
                $where.'s.id' => $home_id
            ])
            ->whereIn(
                "utilities.id", $utility_ids
            )
            ->orderBy("utilities.type", "desc")
            ->select($where."_utilities.id", $where."_utilities.count", "utilities.name", "utilities.type")
            ->get();

        return response()->json([
            "success" => true,
            "rooms" => $new_rooms,
            "counts" => $utility_counts,
            "msg" => "Successfully Added rooms to home"
        ]);
    }

    public function remove_room_from_home(Request $request){
        return $this->remove_room($request, "home");
    }
    public function remove_room_from_rental(Request $request){
        return $this->remove_room($request, "rental");
    }

    public function remove_room(Request $request, $where = null){
        $real_utility_id = $request->get("home_utility_id");

        if($where == "home"){
            $real_utility = HomeUtility::find($real_utility_id);
        }else if($where == "rental"){
            $real_utility = RentalUtility::find($real_utility_id);
        }else{
            $real_utility = HomeUtility::find($real_utility_id);
        }


        if($real_utility->delete())
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

    public function add_pictures_to_home(Request $request){
        return $this->add_pictures($request, "home");
    }
    public function add_pictures_to_rental(Request $request){
        return $this->add_pictures($request, "rental");
    }
    public function add_pictures_to_plot(Request $request){
        return $this->add_pictures($request, "plot");
    }

    public function add_pictures(Request $request, $where = null){
        $home_id = $request->input("home_id");
        $house_images = $request->file("house_images");
        if(count($house_images) < 1){
            return response()->json([
                "success" => false,
                "msg" => "Please choose atleast one image"
            ]);
        }

        $first_image_src = "";
        $count = 0;
        foreach ($house_images as $image) {
            $count++;

            if($where == "home"){
                $real_path = 'homz/';
            }else if($where == "rental"){
                $real_path = 'rentals/';
            }else if($where == "plot"){
                $real_path = 'plots/';
            }else{
                $real_path = 'homz/';
            }

            $destinationPath = public_path('images/uploads/'.$real_path);
            $img = Image::make($image->getRealPath());
            $new_image_name = $home_id.'-'.time().$count.'.'.$image->getClientOriginalExtension();

            if($count == 1)
                $first_image_src = $new_image_name;

            $img->save($destinationPath.$new_image_name);

            $house_image = [
                'image_url' => $new_image_name,
                'placeholder_color' => $img->limitColors(1)->pickColor(0, 0, 'hex'),
                'caption' => ""
            ];

            if($where == "home"){
                $house_image['home_id'] = $home_id;
                $new_image = HomeImage::create($house_image);
            }else if($where == "rental"){
                $house_image['rental_id'] = $home_id;
                $new_image = RentalImage::create($house_image);
            }else if($where == "plot"){
                $house_image['plot_id'] = $home_id;
                $new_image = PlotImage::create($house_image);
            }else{
                $house_image['home_id'] = $home_id;
                $new_image = HomeImage::create($house_image);
            }

            if(!$new_image){
                return response()->json([
                    "success" => false,
                    "msg" => "Couldn't uploaded images."
                ]);

                break;
            }
        }

        return response()->json([
            "success" => true,
            "first_image" => $first_image_src,
            "msg" => "Images successfully uploaded"
        ]);
    }
}
