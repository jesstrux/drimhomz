<?php

namespace App\Http\Controllers;

use Auth;
use App\Shop;
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
}
