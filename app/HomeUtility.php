<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HomeUtility extends Model
{
    protected $table = 'home_utilities';

    protected $fillable = [
        'home_id',
        'utility_id',
        'count'
    ];
}
