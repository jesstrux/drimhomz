<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RentalImage extends Model
{
    protected $fillable = [
        'image_url',
        'placeholder_color',
        'caption',
        'rental_id'
    ];
}
