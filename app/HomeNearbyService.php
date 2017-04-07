<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HomeNearbyService extends Model
{
//    protected $table = 'home_utilities';

    protected $fillable = [
        'home_id',
        'nearby_service_id',
        'distance'
    ];
}
