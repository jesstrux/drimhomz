<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Home extends Model
{
    protected $fillable = [
        'name',
        'description',
        'user_id',
        'town',
        'street',
        'price',
        'type',
        'floor_count'
    ];

    public function user(){
        return $this->belongsTo('App\User');
    }

    public function images(){
        return $this->hasMany('App\HomeImage');
    }

    public function utilities(){
        return $this->hasMany('App\HomeUtility');
    }

    public function utilities_rooms(){
        $utilities = DB::table('home_utilities')
            ->join('utilities', 'utilities.id', '=', 'home_utilities.utility_id')
            ->join('homes', 'homes.id', '=', 'home_utilities.home_id')
            ->where([
                'homes.id' => $this->id
            ])
            ->orderBy("utilities.type", "desc")
            ->select("home_utilities.id", "home_utilities.count", "utilities.name", "utilities.type")
            ->get();

        return $utilities;
    }

    public function utilities_features(){
        $utilities = DB::table('home_utilities')
            ->join('utilities', 'utilities.id', '=', 'home_utilities.utility_id')
            ->join('homes', 'homes.id', '=', 'home_utilities.home_id')
            ->where([
                'homes.id' => $this->id,
                'utilities.type' => "feature",
            ])
            ->select("home_utilities.id", "home_utilities.count", "utilities.name")
            ->get();

        return $utilities;
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
//                "#" . dechex(rand(0x000000, 0xFFFFFF));
        }
    }
}
