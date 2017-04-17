<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;

Relation::morphMap([
	'home' => 'App\Home',
    'rental' => 'App\Rental',
    'plot' => 'App\Plot',
    'article' => 'App\Article',
    'question' => 'App\Question'
]);

class Image extends Model
{
    protected $fillable = [
        'url', 'placeholder_color', 'height', 'width'
    ];

    public function imageable(){
        return $this->morphTo();
    }
}
