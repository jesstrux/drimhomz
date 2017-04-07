<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Plot extends Model
{
    protected $fillable = [
        'name',
        'description',
        'user_id',
        'town',
        'street',
        'price',
        'size',
        'plot_number',
        'block',
        'topographical_nature'
    ];

    public function user(){
        return $this->belongsTo('App\User');
    }

    public function images(){
        return $this->hasMany('App\PlotImage');
    }

    public function image(){
        if($this->images()->count() > 0){
            return $this->images->first()->image_url;
        }else{
            return "def.png";
        }
    }

    public function color(){
        if($this->images()->count() > 0){
            return $this->images->first()->placeholder_color;
        }else{
            return "#ddd";
        }
    }
}
