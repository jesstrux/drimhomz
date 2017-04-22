<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ShopRating extends Model
{
    protected $fillable = [
        'rating_id', 'shop_id'
    ];

    public function rating(){
        return $this->belongsTo('App\Rating');
    }

    public function user(){
        return $this->rating->user();
    }

    public function shop(){
        return $this->belongsTo('App\Shop');
    }
}
