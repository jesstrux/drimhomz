<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
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

//        $destinationPath = public_path('images/uploads/houses/test/thumbs');
        $destinationPath = storage_path('app/public/uploads/housesIsh/thumbs/');

        $img = Image::make($image->getRealPath());
        $path = $image->store('public/uploads/housesIsh');
        $exploded_array = explode("/", $path);
        $thumb_path = $destinationPath.$exploded_array[count($exploded_array) - 1];

        $image_sizes = new \stdClass();
        $image_sizes->width = $img->width();
        $image_sizes->height = $img->height();

        $img->resize(400, 800, function ($constraint) {
		    $constraint->aspectRatio();
		})->save($thumb_path);
        $image_sizes->width_thumb = $img->width();
        $image_sizes->height_thumb = $img->height();

//        return back()
//        	->with('success','Image Upload successful')
//        	->with('imageName',$input['imagename'])
//            ->with('imageSizes', $image_sizes);
        return response()->json([
            'path' => $img->basePath(),
            'thumb_path' => $thumb_path,
            'imageSizes' => $image_sizes,
            'color' => $img->limitColors(1)->pickColor(0, 0, 'hex')
        ]);
    }
}