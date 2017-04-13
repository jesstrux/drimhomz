<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ShopRating extends Model
{
    protected $fillable = [
        'shop_id', 'rating_id'
    ];

    public function shop(){
        return $this->belongsTo('App\Shop');
    }

    public function rating(){
        return $this->belongsTo('App\Rating');
    }

    public function user(){
        return $this->rating->user;
    }
}
