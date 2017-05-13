<?php

namespace App\Http\Controllers;

use App\Home;
use App\Plot;
use App\Rental;
use App\User;
use App\Project;
use App\House;
use App\Shop;
use App\Product;
use App\Question;
use App\Article;

use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function search($q=null){
        $qwasnull = false;

        if($q == null){
            $q = $_GET['q'];
            $qwasnull = true;
        }

    	$users = User::where('fname', 'LIKE', '%'.$q.'%')->orWhere('lname', 'LIKE', '%'.$q.'%')->get();

    	$projects = Project::where('title', 'LIKE', '%'.$q.'%')->get();

    	$houses = House::where('title', 'LIKE', '%'.$q.'%')->orWhere('description', 'LIKE', '%'.$q.'%')->get();

    	$shops = Shop::where('name', 'LIKE', '%'.$q.'%')->get();

    	$products = Product::where('name', 'LIKE', '%'.$q.'%')->get();

    	// $questions = Question::where('title', 'LIKE', '%'.$q.'%')->orWhere('content', 'LIKE', '%'.$q.'%')->get();

    	// $articles = Article::where('title', 'LIKE', '%'.$q.'%')->orWhere('content', 'LIKE', '%'.$q.'%')->get();

        $homes = Home::where('name', 'LIKE', '%'.$q.'%')->orWhere('description', 'LIKE', '%'.$q.'%')->get();

        $rentals = Rental::where('name', 'LIKE', '%'.$q.'%')->orWhere('description', 'LIKE', '%'.$q.'%')->get();

        $plots = Plot::where('name', 'LIKE', '%'.$q.'%')->orWhere('description', 'LIKE', '%'.$q.'%')->get();

        $result_count = $users->count() + $projects->count() + $houses->count() + $shops->count() + $products->count() + $homes->count() + $rentals->count() + $plots->count();
    	 // + $questions->count() + $articles->count();

    	if($qwasnull){
            return view('search.results', compact('q', 'result_count', 'users', 'projects', 'houses', 'shops', 'products', 'homes', 'rentals', 'plots'));
        }else{
            return view('search.results-str', compact('q', 'result_count', 'users', 'projects', 'houses', 'shops', 'products', 'homes', 'rentals', 'plots'));
        }
    }

    public function search_category($q, $category){
        if($category == "users"){
            $users = User::where('fname', 'LIKE', '%'.$q.'%')->orWhere('lname', 'LIKE', '%'.$q.'%')->get();

            $result_count = $users->count();

            return view('search.search-by-category', compact('q', 'category', 'result_count', 'users'));
        }

        else if($category == "projects"){
            $projects = Project::where('title', 'LIKE', '%'.$q.'%')->get();

            $result_count = $projects->count();

            return view('search.search-by-category', compact('q', 'category', 'result_count', 'projects'));
        }

        else if($category == "houses"){
            $houses = House::where('title', 'LIKE', '%'.$q.'%')->orWhere('description', 'LIKE', '%'.$q.'%')->get();

            $result_count = $houses->count();

            return view('search.search-by-category', compact('q', 'category', 'result_count', 'houses'));
        }

        else if($category == "shops"){
            $shops = Shop::where('name', 'LIKE', '%'.$q.'%')->get();

            $result_count = $shops->count();

            return view('search.search-by-category', compact('q', 'category', 'result_count', 'shops'));
        }

        else if($category == "products"){
            $products = Product::where('name', 'LIKE', '%'.$q.'%')->get();

            $result_count = $products->count();

            return view('search.search-by-category', compact('q', 'category', 'result_count', 'products'));
        }

        else if($category == "homes"){
            $homes = Home::where('name', 'LIKE', '%'.$q.'%')->orWhere('description', 'LIKE', '%'.$q.'%')->get();

            $result_count = $homes->count();

            return view('search.search-by-category', compact('q', 'category', 'result_count', 'homes'));
        }

        else if($category == "rentals"){
            $rentals = Rental::where('name', 'LIKE', '%'.$q.'%')->orWhere('description', 'LIKE', '%'.$q.'%')->get();

            $result_count = $rentals->count();

            return view('search.search-by-category', compact('q', 'category', 'result_count', 'rentals'));
        }

        else if($category == "plots"){
            $plots = Plot::where('name', 'LIKE', '%'.$q.'%')->orWhere('description', 'LIKE', '%'.$q.'%')->get();

            $result_count = $plots->count();

            return view('search.search-by-category', compact('q', 'category', 'result_count', 'plots'));
        }

        else{
            return view('search.search-by-category', compact('q', 'category'));
        }

        // $questions = Question::where('title', 'LIKE', '%'.$q.'%')->orWhere('content', 'LIKE', '%'.$q.'%')->get();

        // $articles = Article::where('title', 'LIKE', '%'.$q.'%')->orWhere('content', 'LIKE', '%'.$q.'%')->get();

         // + $questions->count() + $articles->count();
    }
}
