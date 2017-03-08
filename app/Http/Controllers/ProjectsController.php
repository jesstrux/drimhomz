<?php

namespace App\Http\Controllers;

use App\Project;
use Illuminate\Http\Request;

class ProjectsController extends Controller
{
    public function index(){
    	// return view('houses.index');
    }

    public function store(Request $request){
    	$project = [
            'user_id' => $request->input('user_id'),
            'title' => $request->input('title')
        ];
        $new_project = Project::create($project);
        
        if($new_project){
        	return response()->json(["success" => true, "project" => Project::find($new_project->id)]);
        }else{
        	return response()->json(["success" => false]);
        }
    }
}
