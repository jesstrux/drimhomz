<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Shop extends Model
{
    protected $fillable = [
        'user_id', 'image_url', 'name', 'location', 'coords'
    ];

    public function user(){
        return $this->belongsTo("App\User")->select('id', 'fname', 'lname', 'dp');
    }

    public function products(){
        return $this->hasMany("App\Product");
    }
}
