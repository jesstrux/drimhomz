<?php

namespace App\Http\Controllers;

use Auth;
use App\User;
use App\Project;
use App\House;
use App\Comment;
use App\Favorite;
use ColorThief\ColorThief;

use Illuminate\Http\Request;

class HousesController extends Controller
{
    public function index(){
    	return view('houses.index');
    }

    public function randomList($page){
        $houses_per_page = 15;
    	$db_values = House::with('project')->get();
		$len = count($db_values) - 1;
		$values = array();

        if($page > $len/$houses_per_page)
            return "No more";

		for ($i = $page - 1; $i < $houses_per_page * $page; $i++) {
            $db_values[$i]->owner = $db_values[$i]->owner();
            
            $db_values[$i]->fav_count = $db_values[$i]->favorites()->count();
            $db_values[$i]->comment_count = $db_values[$i]->comments()->count();

            if(!Auth::guest())
                $db_values[$i]->faved = $db_values[$i]->faved(Auth::user()->id);
            else
                $db_values[$i]->faved = false;

            $values []= $db_values[$i];
        }

		return $values;
    }

    public function store(Request $request){
        function createProject($title, $user_id){
            $project = [
                'user_id' => $user_id,
                'title' => $title
            ];

            return Project::create($project)->id;
        }

        function getColor($image_url){
            try{
                $dominantColor = ColorThief::getColor($image_url);
            }
            catch (Exception $e) {
                $dominantColor = array(0,0,0);
            }

            return "rgb(".implode(", ", $dominantColor).")";
        }

        $photoName = $request->file('image_url')->getClientOriginalName();
        $destination = base_path()."/public/images/uploads/houses/";
        $request->file('image_url')->move($destination, $photoName);

        $project_id = $request->input('project_id') ?: createProject($request->input('project_title'));
        $placeholder_color = getColor($destination.$photoName);

    	$house = [
            'title' => $request->input('title'),
            // 'description' => $request->input('description'),
        	'image_url' => $photoName,
        	'placeholder_color' => $placeholder_color,
        	'project_id' => $project_id
        ];

        $new_house = House::create($house);
        if($new_house)
            return back()->with('success','House successfully create')
            ->with('house', House::find($new_house->id));
        else
            return back()->withErrors(['msg','Failed to create house']);
    }

    public function get_comments($house){
        return Comment::with('user')->where('house_id', $house)->get();
    }

    public function submit_comment(Request $request){
        if(Auth::guest())
            return response()->json(["success" => false]);
        else{
            $comment = [
                'user_id' => Auth::user()->id,
                'house_id' => $request->input('house_id'),
                'content' => $request->input('content')
            ];
            $new_comment = Comment::create($comment);
            
            if($new_comment->id){
                return response()->json([
                    'success' => true,
                    'id' => $new_comment->id,
                    'comment' => $new_comment
                ]);
            }else{
                return response()->json([
                    'success' => false
                ]);
            }
        }
    }

    public function delete_comment(Request $request){
        // return $request->all();

        if(Auth::guest())
            return response()->json(["success" => false]);
        else{
            $comment = Comment::find($request->input('id'));

            if(!$comment->exists())
                return response()->json([
                    'success' => false
                ]);

            if($comment->delete()){
                return response()->json([
                    'success' => true
                ]);
            }else{
                return response()->json([
                    'success' => false
                ]);
            }
        }
    }

    public function favorite_house(Request $request){
        $authuser = Auth::user();
        $house_id = $request->input('house_id');
        $house = House::find($house_id);
        $faved = $house->faved($authuser->id) ? true : false;
        
        $fav = [
            'user_id' => $authuser->id,
            'house_id' => $house_id
        ];

        if(!$faved){
            if(Favorite::create($fav)){
                return response()->json([
                    'success' => 'true'
                ]);
            }else{
                return response()->json([
                    'success' => 'false'
                ]);
            }
        }else{
            $to_unfav = Favorite::where($fav);
            if(!$to_unfav->exists()){
                return response()->json([
                    'success' => 'false',
                    'reason' => 'non existent'
                ]);
            }

            if($to_unfav->delete()){
                return response()->json([
                    'success' => 'true'
                ]);
            }else{
                return response()->json([
                    'success' => 'false'
                ]);
            }
        }
    }
}
