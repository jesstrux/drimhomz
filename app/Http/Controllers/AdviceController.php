<?php

namespace App\Http\Controllers;
use App\Question;
use Auth;
use Illuminate\Http\Request;

class AdviceController extends Controller
{
    public function index()
    {
    	$questions = Question::with('answers')->get();
    	return view('advice.index', compact('questions'));
    }
}
