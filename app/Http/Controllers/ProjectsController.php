<?php

namespace App\Http\Controllers;

use App\Project;
use Auth;
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

        if($new_project)
            return back()->with('success','Project successfully created')
            ->with('project', Project::find($new_project->id));
        else
            return back()->withErrors(['msg','Failed to create project']);
            // return response()->json([
            //     'success' => 'false'
            // ]);
    }

    function showprofile($id){
        $project = Project::with('houses')->find($id);

        if(!Auth::guest()){
            $authuser = Auth::user();
            $myProject = $authuser->id == $project->user->id;
        }else{
            $myProject = false;
        }

        return view('project.index', compact('project', 'myProject'));
    }
}
