<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HouseImage extends Model
{
    //
    protected $fillable = [
        'house_id', 'width', 'height', 'width_thumb', 'height_thumb'
    ];

    public function house(){
        return $this->belongsTo("App\House");
    }
}
