<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RentalUtility extends Model
{
    protected $table = 'rental_utilities';

    protected $fillable = [
        'rental_id',
        'utility_id',
        'count'
    ];
}
