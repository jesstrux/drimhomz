<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class ExpertController extends Controller
{
    public function index()
    {
    	$experts = User::where("role", "<>" , "user")->where("role", "<>" , "admin")->get();
		return view('expert.index', compact('experts'));
    }
}
