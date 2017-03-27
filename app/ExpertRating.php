<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ExpertRating extends Model
{
    protected $fillable = [
        'rating', 'comment', 'user_id', 'expert_id'
    ];

    public function expert(){
        return $this->belongsTo('App\User', 'expert_id');
    }

    public function user(){
        return $this->belongsTo('App\User');
    }
}
