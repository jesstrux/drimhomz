<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HomeImage extends Model
{
    protected $fillable = [
        'image_url',
        'placeholder_color',
        'caption',
        'home_id'
    ];
}
