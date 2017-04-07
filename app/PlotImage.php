<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PlotImage extends Model
{
    protected $fillable = [
        'image_url',
        'placeholder_color',
        'caption',
        'plot_id'
    ];
}
