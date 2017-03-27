<?php

namespace App\Http\Controllers;
use App\Advertisement;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function create_ad(Request $request){
        $image = $request->file('image');
        $path = $image->store('public/uploads/banners');
        $sub_paths = explode("/", $path);
        $file_name = $sub_paths[count($sub_paths) - 1];

//        return response()->json([$path, $sub_paths, $file_name, $request->input("title"), $request->input("link")]);

        $ad = [
            'image_url' => $file_name,
            'title' => $request->input('title'),
            'link' => $request->input('link')
        ];
//        $ad_exists = Advertisement::where("title", $request->input('title'))->exists();

        if(Advertisement::create($ad))
            return back()->with('success','Advertisement successfully created');
        else
            return back()->withErrors(['msg','Failed to create Advertisement']);
    }
}
