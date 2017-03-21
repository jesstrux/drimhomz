<?php

namespace App\Http\Controllers;

use App\User;
use App\House;
use App\Shop;
use App\Product;

use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function search(){
    	// $users = User::where()->get();
    	// $houses = House::where()->get();
    	// $shops = Shop::where()->get();
    	// $products = Product::where()->get();

    	// return view('home.profile');
    	return $_GET['q'];
    }
}
