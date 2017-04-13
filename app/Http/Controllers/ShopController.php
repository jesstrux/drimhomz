<?php

namespace App\Http\Controllers;

use Auth;
use App\Shop;
use App\User;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    public function index()
    {
    	$shops = Shop::with('products')->get();
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
        $user_role = User::find($request->input('user_id'))->role;

        if($user_role != "seller"){
            return response()->json([
                'success' => false,
                'msg' => 'You must be registered as a seller and be logged in to create shop.'
            ]);
        }

        $shop = [
            'user_id' => $request->input('user_id'),
            'name' => $request->input('name')
        ];

        $shop_exists = Shop::where($shop)->exists();

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

        $shop['location'] = "";
        $shop['image_url'] = "def.png";

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
}
