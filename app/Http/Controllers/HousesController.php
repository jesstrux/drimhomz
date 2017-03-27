<?php

namespace App\Http\Controllers;

use Auth;
use App\User;
use App\Project;
use App\House;
use App\Comment;
use App\Favorite;
use App\FollowPost;
use App\HouseImage;
use ColorThief\ColorThief;
use Image;

use Illuminate\Http\Request;

class HousesController extends Controller
{
    public function index(){
    	return view('houses.index');
    }

    public function randomList($page){
        $houses_per_page = 15;
    	$db_values = House::with('project')->orderBy('created_at', 'desc')->get();
		$len = count($db_values) - 1;
		$values = array();

        if($page > $len/$houses_per_page){
            $fin = $len - $page;
        }else{
            $fin = $houses_per_page * $page;
        }
		for ($i = $page - 1; $i < $fin; $i++) {
            $db_values[$i]->owner = $db_values[$i]->owner();
            
            $db_values[$i]->fav_count = $db_values[$i]->favorites()->count();
            $db_values[$i]->comment_count = $db_values[$i]->comments()->count();
            $image = $db_values[$i]->image;
            if($image != null){
                $db_values[$i]->width = $image->width;
                $db_values[$i]->height = $image->height;
                $db_values[$i]->width_thumb = $image->width_thumb;
                $db_values[$i]->height_thumb = $image->height_thumb;
            }

            if(!Auth::guest()){
                $db_values[$i]->faved = $db_values[$i]->faved(Auth::user()->id);
                $db_values[$i]->followed = $db_values[$i]->followed(Auth::user()->id);
            }
            else{
                $db_values[$i]->faved = false;
                $db_values[$i]->followed = false;
            }

            $values []= $db_values[$i];
        }

        if($page > $len/$houses_per_page){
            return response()->json([
                "houses" => $values,
                "more" => false
            ]);
        }else{
            return response()->json([
                "houses" => $values,
                "more" => true
            ]);
        }
    }

    public function follow_house(Request $request){
        if(Auth::guest()){
            return response()->json([
                'success' => false,
                'msg' => "You must be logged in to follow a house"
            ]);
        }

        $user_id = Auth::user()->id;
        $house_id = $request->input('house_id');
        $house = House::find($house_id);

        $follow = [
            'user_id' => $user_id,
            'house_id' => $house_id
        ];

        if($house->followed($user_id)){
            if(FollowPost::where($follow)->delete()){
                return response()->json([
                    'success' => true,
                    'msg' => "Successfully unfollowed house"
                ]);
            }else{
                return response()->json([
                    'success' => false,
                    'msg' => "Couldn't unfollow house"
                ]);
            }
        }
        else if($house->owner()->id == $user_id){
            return response()->json([
                'success' => false,
                'msg' => "You can't follow your own house!"
            ]);
        }
        else{
            if(FollowPost::create($follow)){
                return response()->json([
                    'success' => true,
                    'msg' => "Successfully followed house"
                ]);
            }else{
                return response()->json([
                    'success' => false,
                    'msg' => "Couldn't follow house"
                ]);
            }
        }
    }

    public function pin_house(Request $request){
        $project = Project::find($request->input('project_id'));
        $houses = $project->houses;
        $cur_house = House::find($request->input('house_id'));
        $image_url = $cur_house -> image_url;
        
        $count = $houses->where("image_url", $image_url)->count();

        if($count > 0){
            return response()->json([
                'success' => false,
                'msg' => "This house was already drimmed to $project->title",
                'request' => $request->all()
            ]);
        }else{
            $house = House::find($request->input('house_id'));
            $house->id = null;
            $house->project_id = $request->input('project_id');

            if(House::create($house->toArray())){
                return response()->json([
                    'success' => true,
                    'msg' => "Successfully drimmed to $project->title"
                ]);
            }else{
                return response()->json([
                    'success' => true,
                    'msg' => "Couldn't drim to $project->title"
                ]);
            }
        }
    }

    public function store(Request $request){
        function saveThumb(Request $request){
            $image = $request->file('image_url');
            $destinationPath = storage_path('app/public/uploads/houses/thumbs/');

            $img = Image::make($image->getRealPath());
            $path = $image->store('public/uploads/houses');
            $exploded_array = explode("/", $path);
            $new_image_name = $exploded_array[count($exploded_array) - 1];
            $thumb_path = $destinationPath.$new_image_name;

            $image_sizes = new \stdClass();
            $image_sizes->width = $img->width();
            $image_sizes->height = $img->height();


            $img->resize(rand (400, 800), null, function ($constraint) {
                $constraint->aspectRatio();
            })->save($thumb_path);

            $image_sizes->width_thumb = $img->width();
            $image_sizes->height_thumb = $img->height();

            return [
                "url" => $new_image_name,
                "image_sizes" => $image_sizes,
                "color" => $img->limitColors(1)->pickColor(0, 0, 'hex')
            ];
        }

        $more_info = saveThumb($request);
        $image_sizes = $more_info["image_sizes"];

        $house = [
            'title' => $request->input('title'),
            // 'description' => $request->input('description'),
            'image_url' => $more_info['url'],
            'placeholder_color' => $more_info["color"],
//            'description' => $faker->realText(),
            'project_id' => $request->input('project_id')
        ];

        $new_house = House::create($house);

        if($new_house){
            $house_image = [
                'house_id' => $new_house->id,
                'width' => $image_sizes->width,
                'height' => $image_sizes->height,
                'width_thumb' => $image_sizes->width_thumb,
                'height_thumb' => $image_sizes->height_thumb
            ];

            $new_house_image = HouseImage::create($house_image);

            if($new_house_image)
                return back()->with('success','House successfully created')
                    ->with('house', House::find($new_house->id));
            else
                return back()->withErrors(['msg','Failed to create house']);
        }else{
            return back()->withErrors(['msg','Failed to create house']);
        }
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
        if(Auth::guest()){
            return response()->json([
                'success' => false,
                'msg' => 'Please login first before liking a house.'
            ]);
        }

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
