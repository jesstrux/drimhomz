<?php

namespace App\Http\Controllers;
use App\Advertisement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Facades\Image;
class AdminController extends Controller
{
    public function create_ad(Request $request){
        $image = $request->file('image');
        $img = Image::make($image->getRealPath());
        $file_name = time().'.'.$image->getClientOriginalExtension();
        $destinationPath = public_path('images/uploads/banners/');
        $img->save($destinationPath.$file_name);
//        $path = $image->store('public/uploads/banners');
//        $sub_paths = explode("/", $path);
//        $file_name = $sub_paths[count($sub_paths) - 1];

//        return response()->json([$path, $sub_paths, $file_name, $request->input("title"), $request->input("link")]);

        $ad = [
            'image_url' => $file_name,
            'title' => $request->input('title'),
            'link' => $request->input('link'),
            'priority' => $request->input('priority'),
            'description' => $request->input('description')
        ];
//        $ad_exists = Advertisement::where("title", $request->input('title'))->exists();

        if(Advertisement::create($ad))
            return back()->with('success','Advertisement successfully created');
        else
            return back()->withErrors(['msg','Failed to create Advertisement']);
    }

    public function delete_ad(Request $request){
        if(Auth::guest()){
            return back()->withErrors(['msg','You have no required permission']);
        }else if(Auth::user()->role !== 'admin'){
            return back()->withErrors(['msg','You have no required permission']);
        }

        $ad = Advertisement::find($request->input("id"));
        if($ad->delete())
            return back()->with('success','Advertisement successfully deleted');
        else
            return back()->withErrors(['msg','Failed to delete Advertisement']);
    }
}
