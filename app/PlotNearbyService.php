<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PlotNearbyService extends Model
{
//    protected $table = 'home_utilities';

    protected $fillable = [
        'plot_id',
        'nearby_service_id',
        'distance'
    ];
}
