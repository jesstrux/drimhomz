<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Image;

class ImageController extends Controller
{
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function resizeImage()
    {
    	return view('fileup');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function resizeImagePost(Request $request)
    {
	    $this->validate($request, [
	    	'title' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:3072',
        ]);

        $image = $request->file('image');
        $input['imagename'] = time().'.'.$image->getClientOriginalExtension();
     
   
        $destinationPath = public_path('images/uploads/houses/test/thumbs');
        $img = Image::make($image->getRealPath());
        $img->resize(800, 800, function ($constraint) {
		    $constraint->aspectRatio();
		})->save($destinationPath.'/'.$input['imagename']);

        $destinationPath = public_path('/images/uploads/houses/test/');
        $image->move($destinationPath, $input['imagename']);

        // $this->postImage->add($input);

        return back()
        	->with('success','Image Upload successful')
        	->with('imageName',$input['imagename']);
    }

}