<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $fillable = [
        'user_id', 'title'
    ];

    public function user(){
        return $this->belongsTo("App\User")->select('id', 'fname', 'lname', 'dp');
    }

    public function houses(){
        return $this->hasMany("App\House");
    }
}
