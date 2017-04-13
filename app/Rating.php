<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
    protected $fillable = [
        'rating', 'comment', 'user_id'
    ];

    public function user(){
        return $this->belongsTo('App\User')->select('id', 'fname', 'lname', 'dp');
    }
}
