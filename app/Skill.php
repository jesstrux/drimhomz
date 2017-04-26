<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Skill extends Model
{
    protected $fillable = [
        'name'
    ];


    public function user(){
        return $this->belongsTo('App\User')->select('id', 'fname', 'lname', 'dp');
    }
}
