<?php

namespace App\Http\Controllers;

use App\Notifications\ExpertRated;
use App\Notifications\ShopRated;
use App\Role;
use Auth;
use Image;
use App\Shop;
use App\User;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    public function index()
    {
    	$shops = Shop::with('products')->orderBy('updated_at','desc')->get();
		return view('shop.index', compact('shops'));
    }

    public function show_profile($id)
    {
    	 $shop = Shop::with('products')->find($id);

        if(!Auth::guest()){
            $authuser = Auth::user();
            $myShop = $authuser->id == $shop->user->id;
        }else{
            $myShop = false;
        }

		return view('shop.profile', compact('shop', 'myShop'));
    }

    public function store(Request $request){
        $shop_owner = User::find($request->input('user_id'));
        $user_id = $request->input('user_id');



        if(!$shop_owner->hasRole('seller')){
            $seller_role = Role::where('name','seller')->first();
            $shop_owner->attachRole($seller_role);
        }

        function saveThumb(Request $request){
            $image = $request->file('image_url');
            $destinationPath = public_path('images/uploads/shops/');

            $img = Image::make($image->getRealPath());
            $new_image_name = "shop-" .$request->input('user_id').'-'.time().'.'.$image->getClientOriginalExtension();
            $img->save($destinationPath.$new_image_name);
            return $new_image_name;
        }

        $shop_test = [
            'user_id' => $user_id,
            'name' => $request->input('name'),
        ];

        $shop_exists = Shop::where($shop_test)->exists();

        if($shop_exists){
            return response()->json([
                'success' => false,
                'msg' => 'You already have a shop called ' . $request->input('name')
            ]);
        }

        $max_shops = Shop::where("user_id", $request->input('user_id'))->count();

        if($max_shops > 2){
            return response()->json([
                'success' => false,
                'msg' => 'You can not have more than 3 shopes'
            ]);
        }

        if($request->file('image_url') != null){
            $image_url = saveThumb($request);
        }else{
            $image_url = "def.png";
        }

        $shop = [
            'user_id' => $request->input('user_id'),
            'name' => $request->input('name'),
            'type' => $request->input('type'),
            'street' => $request->input('street'),
            'town' => $request->input('town'),
            'city' => $request->input('city'),
            'country' => $request->input('country'),
            'quality_statement' => $request->input('quality_statement'),
            'service_statement' => $request->input('service_statement'),
            'image_url' => $image_url
        ];

        $new_shop = Shop::create($shop);

        if($new_shop){
            return response()->json([
                'success' => true,
                'shop' => $new_shop
            ]);
        }else
            // return back()->withErrors(['msg','Failed to create shop']);
            return response()->json([
                'success' => false,
                'msg' => 'Failed to create shop'
            ]);
    }

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
			    $newly_rated = Shop::find($rated_id)->create($rating);

			    if($newly_rated)
				    if(Auth::user()->id != $newly_rated->ratable_id)
					    User::find($newly_rated->ratable->user()->id)->notify(new ShopRated($newly_rated, $newly_rated->user));
		    }
		    break;

		    case "user" : {
			    $newly_rated = User::find($rated_id)->create($rating);

			    if($newly_rated)
				    if(Auth::user()->id != $newly_rated->ratable_id)
					    User::find($newly_rated->ratable_id)->notify(new ExpertRated($newly_rated, $newly_rated->user));
		    }
		    break;
	    }

        if($newly_rated){
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
