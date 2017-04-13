<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{

    protected $fillable = [
        'name', 'price', 'brand', 'description', 'specification', 'amount', 'rate', 'image_url', 'shop_id',
    ];

    public function shop(){
        return $this->belongsTo('App\Shop');
    }

    public function owner(){
        return $this->shop->user;
    }
}
