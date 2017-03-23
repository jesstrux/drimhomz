<?php

namespace App;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Message extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'body','status','user_id'
    ];

    public function user(){
        return $this->belongsTo('App\User');
    }



    public function saveMessage($array)
    {

        $body = $array['body'];
        $user_id = $array['user_id'];

        try {

            return Message::create(['body' => $body,'user_id'=>$user_id]);
        } catch (QueryException $e) {
            return back()->withErrors(['error'=> $e]);
        }

    }

}
