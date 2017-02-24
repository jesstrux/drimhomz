<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'fname', 'lname', 'phone', 'password', 'role', 'gender', 'town', 'dob'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function full_name(){
        echo $this->fname ." ". $this->lname;
    }

    public function birth_date(){
        if(!isset($this->dob))
            echo false;

        $time = strtotime($this->dob);
        return date("F d, Y", $time);
    }

    public function houses(){
        return $this->hasMany("App\House");
    }
}
