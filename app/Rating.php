<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;

Relation::morphMap([
	'user' => 'App\User',
	'shop' => 'App\Shop',
]);

class Rating extends Model
{
    protected $fillable = [
        'rating', 'comment', 'user_id'
    ];

//, 'ratable_id', 'ratable_type'

    public function ratable(){
        return $this->morphTo();
    }

    public function user(){
        return $this->belongsTo('App\User')->select('id', 'fname', 'lname', 'dp');
    }
}
