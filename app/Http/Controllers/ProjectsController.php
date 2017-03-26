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

        $project_exists = Project::where("title", $request->input('title'))->where("user_id", $request->input('user_id'))->exists();

        if($project_exists){
            return response()->json([
                'success' => false,
                'msg' => 'You already have a project called ' . $request->input('title') 
            ]);
        }

        $new_project = Project::create($project);

        if($new_project){
            // return back()->with('success','Project successfully created')
            // ->with('project', Project::find($new_project->id));
            $new_project->cover = $new_project->cover();
            return response()->json([
                'success' => true,
                'project' => $new_project
            ]);
        }else
            // return back()->withErrors(['msg','Failed to create project']);
            return response()->json([
                'success' => false,
                'msg' => 'Failed to create project'
            ]);
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

    function edit_project(Request $request){
        if(Auth::guest()){
            return back()->withErrors(['msg','Please login first']);
        }

        if($request->input('coords') !== null){
            $coords = $request->input('coords');
        }else{
            $coords = "";
        }

        $project = Project::find($request->input('id'));
        $project->title = $request->input('title');
        $project->location = $request->input('location');
        $project->coords = $coords;
        $project->budget = $request->input('budget');
        $time_start = strtotime($request->input('time_start'));
        $time_finish = strtotime($request->input('time_finish'));
        $project->time_start = strftime("%Y-%m-%d %H:%M:%S", $time_start);
        $project->time_finish = strftime("%Y-%m-%d %H:%M:%S", $time_finish);

        if($project->save()){
            return "success";
        }
        else {
            return response("error: Can\'t save project!");
        }
    }
}
