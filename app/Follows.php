<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Follows extends Model
{
    protected $fillable = [
        'user_id', 'followed_id'
    ];

    public function follower(){
        return $this->belongsTo('App\User', 'followed_id');
    }

    public function user(){
        return $this->belongsTo('App\User');
    }
}
