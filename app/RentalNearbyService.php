<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RentalNearbyService extends Model
{
//    protected $table = 'home_utilities';

    protected $fillable = [
        'rental_id',
        'nearby_service_id',
        'distance'
    ];
}
