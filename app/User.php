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
    public function articles(){
        return $this->hasMany("App\Article");
    }

    public function answers(){
        return $this->hasMany("App\Answer");
    }

    public function houses(){
        return $this->hasManyThrough('App\House', 'App\Project');
    }

    public function projects(){
        return $this->hasMany("App\Project");
    }

    public function followers(){
        return $this->hasMany('App\Follows');
    }

    public function following(){
        return $this->hasMany('App\Follows', 'followed_id');
    }

    public function location(){
        return $this->hasMany('App\Location');
    }

    public function location_str(){
        $loc = $this->location()->first();
        return $loc->long . ", " . $loc->lat;
    }

    // public function town(){
    //     $str = $this->location_str();
    //     define("API_KEY", "AIzaSyAQcqitQMDb4pWTudvPoZt6golxzFXrvmI");
    //     $url = "https://maps.googleapis.com/maps/api/geocode/json?latlng=$str&key=".API_KEY;

    //     $response = file_get_contents($url);
    //     $json = json_decode($response,true);
     
    //     $lat = $json['results'][0]['geometry']['location']['lat'];
    //     $lng = $json['results'][0]['geometry']['location']['lng'];
     
    //     return json_encode(array($lat, $lng));
    // }

    public function cover($house_url, $user_url){
        $first_house = $this->houses()->first();

        if($first_house)
            return $house_url . $first_house->image_url;
        else
            return $user_url . $this->dp;
    }
}
