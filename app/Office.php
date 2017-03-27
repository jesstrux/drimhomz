<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Office extends Model
{
    protected $fillable = [
        'name', 'logo', 'location', 'user_id'
    ];

    public function user(){
        return $this->belongsTo('App\User');
    }
}
