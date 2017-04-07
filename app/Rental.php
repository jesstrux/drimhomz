<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Rental extends Model
{
    protected $fillable = [
        'name',
        'description',
        'user_id',
        'town',
        'street',
        'price',
        'rental_type',
        'type',
        'floor_count'
    ];

    public function user(){
        return $this->belongsTo('App\User');
    }

    public function images(){
        return $this->hasMany('App\RentalImage');
    }

    public function utilities(){
        return $this->hasMany('App\RentalUtility');
    }

    public function utilities_rooms(){
        $utilities = DB::table('rental_utilities')
            ->join('utilities', 'utilities.id', '=', 'rental_utilities.utility_id')
            ->join('rentals', 'rentals.id', '=', 'rental_utilities.rental_id')
            ->where([
                'rentals.id' => $this->id
            ])
            ->orderBy("utilities.type", "desc")
            ->select("rental_utilities.id", "rental_utilities.count", "utilities.name", "utilities.type")
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
