<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ExpertRating extends Model
{
    protected $fillable = [
        'rating_id', 'expert_id'
    ];

    public function rating(){
        return $this->belongsTo('App\Rating');
    }

    public function user(){
        return $this->rating->user();
    }

    public function expert(){
        return $this->belongsTo('App\User', 'expert_id')->select('id', 'fname', 'lname', 'dp');
    }
}
