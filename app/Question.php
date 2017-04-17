<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    protected $fillable = [
        'title', 'content', 'user_id'
    ];

    public function answers(){
        return $this->hasMany('App\Answer');
    }

    public function user(){
        return $this->belongsTo('App\User');
    }

    public function images(){
        return $this->morphMany('App\Image', 'imageable');
    }

    public function image(){
        if($this->images()->count() > 0){
            return $this->images->first()->url;
        }else{
            return "def.png";
        }
    }

    public function color(){
        if($this->images()->count() > 0 && $this->images->first()->placeholder_color != null){
            return $this->images->first()->placeholder_color;
        }else{
            return "#ddd";
//                "#" . dechex(rand(0x000000, 0xFFFFFF));
        }
    }
}
