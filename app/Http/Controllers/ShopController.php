<?php

namespace App\Http\Controllers;

use Auth;
use Image;
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
        $shop_owner = User::find($request->input('user_id'));

        if($shop_owner->role != "seller"){
            $shop_owner->role = "seller";
            $shop_owner->save();
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
            'user_id' => $request->input('user_id'),
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
}
