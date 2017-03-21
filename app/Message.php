<?php

namespace App;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;

class Message extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'body', 'phone', 'status', 'verification_code'
    ];


    public function saveMessage($array)
    {

        $body = $array['body'];
        $phone = $array['phone'];
        $verification_code = $array['verification_code'];

        try {
            return Message::create(['body' => $body, 'phone' => $phone, 'verification_code' => $verification_code]);
        } catch (QueryException $e) {
            return back()->with('error', $e);
        }

    }

}
