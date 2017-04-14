<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

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
        return $this->morphMany('App\Rating', 'ratable');
    }

    public function rating(){
        $ratings = $this->ratings;
        if($ratings->count() > 0){
            return $ratings->avg("rating");
        }else{
            return 0.000;
        }
    }

	public function rated($uid){
		return $this->ratings()->where(
			'user_id', $uid)->exists();
	}
}
