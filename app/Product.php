<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'name', 'image_url', 'shop_id'
    ];

    public function shop(){
        return $this->belongsTo('App\Shop');
    }

    public function owner(){
        return $this->shop->user;
    }
}
