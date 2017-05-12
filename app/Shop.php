<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Shop extends Model
{
    protected $fillable = [
        'user_id', 'name', 'image_url', 'type', 'town', 'street', 'country', 'quality_statement', 'service_statement'
    ];

    public function user(){
        return $this->belongsTo('App\User')->select('id', 'fname', 'lname', 'dp', 'phone');
    }

    public function products(){
        return $this->hasMany('App\Product');
    }

    public function ratings(){
        return $this->hasMany('App\ShopRating');
    }

    public function rating(){
        if(count($this->ratings()->get()) > 0){
            return DB::table('shop_ratings')
                ->join('ratings', function ($join) {
                    $join->on('ratings.id', '=', 'shop_ratings.rating_id');
                })
                ->where('shop_ratings.shop_id', $this->id)
                ->avg("rating");
        }else{
            return 0.000;
        }
    }

    public function rated($uid){
        return DB::table('shop_ratings')
            ->join('ratings', function ($join) {
                $join->on('ratings.id', '=', 'shop_ratings.rating_id');
            })
            ->where(['ratings.user_id' => $uid, 'shop_ratings.shop_id' => $this->id])
            ->exists();
    }
}
