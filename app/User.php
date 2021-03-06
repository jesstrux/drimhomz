<?php

namespace App;

use App\Follows;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Zizaco\Entrust\Traits\EntrustUserTrait;

class User extends Authenticatable
{
    use Notifiable;
    use EntrustUserTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'fname', 'lname', 'phone','email', 'password', 'gender', 'town', 'dob', 'skills', 'description', 'verification_code', 'verified'
    ];

    public function isOnline()
    {
        return Cache::has('user-is-online-' . $this->id);
    }

    // in the User class
    public function preferredNotificationChannel()
    {
        return $this->isOnline() ? ['broadcast'] : ['database'];
    }

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

    public function unfollow($uid){
        // $uid
         return Follows::where(
            array('user_id' => $uid, 'followed_id' => $this->id)
            )->delete();
    }

    //RELATIONS
	public function ratings(){
        return $this->hasMany('App\ExpertRating', 'expert_id');
	}

	public function rating(){
        if(count($this->ratings()->get()) > 0){
            return DB::table('expert_ratings')
                ->join('ratings', function ($join) {
                    $join->on('ratings.id', '=', 'expert_ratings.rating_id');
                })
                ->where('expert_ratings.expert_id', $this->id)
                ->avg("rating");
        }else{
            return 0.000;
        }
	}

	public function rated($uid){
		return DB::table('expert_ratings')
			->join('ratings', function ($join) {
				$join->on('ratings.id', '=', 'expert_ratings.rating_id');
			})
			->where(['ratings.user_id' => $uid, 'expert_ratings.expert_id' => $this->id])
			->exists();
	}

    public function articles(){
        return $this->hasMany('App\Article');
    }

    public function shops(){
        return $this->hasMany('App\Shop')->orderBy("created_at", "desc");
    }

    public function answers(){
        return $this->hasMany('App\Answer');
    }

    public function houses(){
        return $this->hasManyThrough('App\House', 'App\Project')->orderBy('created_at', 'desc');
    }

    public function projects(){
        return $this->hasMany('App\Project')->orderBy('created_at', 'desc');
    }

    public function messages(){
        return $this->hasMany('App\Message');
    }

    public function following(){
        return $this->hasMany('App\Follows');
    }

    public function followers(){
        return $this->hasMany('App\Follows', 'followed_id');
    }

    public function location(){
        return $this->hasMany('App\Location');
    }

    public function location_str(){
        $loc = $this->location()->first();
        return $loc->long . ", " . $loc->lat;
    }

    public function office(){
        return $this->hasOne('App\Office');
    }

    public function cover($house_url, $user_url){
        $first_house = $this->houses()->first();

        if($first_house)
            return $house_url . $first_house->image_url;
        else
            return $user_url . $this->dp;
    }
}
