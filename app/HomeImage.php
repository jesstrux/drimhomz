<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HomeImage extends Model
{
    protected $fillable = [
        'image_url',
        'placeholder_color',
        'caption',
        'house_id'
    ];
}
