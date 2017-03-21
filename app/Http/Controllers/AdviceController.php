<?php

namespace App\Http\Controllers;
use App\Question;
use App\Article;
use Auth;
use Illuminate\Http\Request;

class AdviceController extends Controller
{
    public function index($page = "questions")
    {
    	if($page == "questions"){
    		$questions = Question::with('answers')->get();
    		return view('advice.index', compact('page', 'questions'));
    	}else{
    		$articles = Article::with('comments')->get();
    		return view('advice.index', compact('page', 'articles'));
    	}
    }
}
