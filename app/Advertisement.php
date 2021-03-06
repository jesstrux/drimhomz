<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Advertisement extends Model
{
    protected $fillable = [
        'title', 'image_url', 'link', 'priority', 'description'
    ];

    public function views(){
        return $this->hasMany('App\AdView');
    }

    public function viewers(){
        return $this->hasManyThrough('App\User', 'App\AdView');
    }
}
