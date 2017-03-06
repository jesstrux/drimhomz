<?php

namespace App;

use App\Follows;
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

    public function followed($uid){
        return Follows::where(
            array('user_id' => $uid, 'followed_id' => $this->id))->exists();
    }

    public function follow($uid){
        // $uid
    }

    public function unfollow($uid){
        // $uid
         return Follows::where(
            array('user_id' => $uid, 'followed_id' => $this->id)
            )->delete();
    }


    //RELATIONS
    public function houses(){
        return $this->hasManyThrough('App\House', 'App\Project');
    }

    public function projects(){
        return $this->hasMany("App\Project");
    }

    public function followers(){
        return $this->hasMany('App\Follows', 'followed_id');
    }

    public function following(){
        return $this->hasMany('App\Follows');
    }
}
