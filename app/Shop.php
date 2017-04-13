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
}
