<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class ExpertController extends Controller
{
    public function index()
    {
    	$experts = User::all();
		return view('expert.index', compact('experts'));
    }
}
