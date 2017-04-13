<?php

namespace App\Http\Controllers;

use Auth;
use App\Shop;
use Image;
use App\Product;
use App\User;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index($id)
    {
        $product = Product::find($id);

        if(!Auth::guest()){
            $authuser = Auth::user();
            $myProduct = $authuser->id == $product->shop->user_id;
        }else{
            $myProduct = false;
        }

        return view('products.single', compact('product', 'myProduct'));
    }

    public function store(Request $request){
//        return $request->file('image_url');
        function saveThumb(Request $request){
            $image = $request->file('image_url');
            $destinationPath = public_path('images/uploads/products/');

            $img = Image::make($image->getRealPath());
            $new_image_name = "product-" .$request->input('shop_id').'-'.time().'.'.$image->getClientOriginalExtension();
            $img->save($destinationPath.$new_image_name);
            return $new_image_name;
        }

        $product_check = [
            'name' => $request->input('name'),
            'shop_id' => $request->input('shop_id')
        ];

        $product_exists = Product::where($product_check)->exists();

        if($product_exists){
            return response()->json([
                'success' => false,
                'msg' => 'You already have a product called ' . $request->input('name')
            ]);
        }

        if($request->file('image_url') != null){
            $image_url = saveThumb($request);
        }else{
            $image_url = "def.png";
        }

        $product = [
            'image_url' => $image_url,
            'name' => $request->input('name'),
            'price' => $request->input('price'),
            'brand' => $request->input('brand'),
            'description' => $request->input('description'),
            'specification' => $request->input('specification'),
            'shop_id' => $request->input('shop_id')
        ];

        $new_product = Product::create($product);

        if($new_product){
            return response()->json([
                'success' => true,
                'product' => $new_product
            ]);
        }else
            return response()->json([
                'success' => false,
                'msg' => 'Failed to create product'
            ]);
    }
}
