<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
	protected $fillable = [
        'user_id', 'house_id', 'content'
    ];
    
    public function house(){
        return $this->belongsTo("App\House");
    }

    public function user(){
        return $this->belongsTo("App\User")->select('id', 'fname', 'lname', 'dp');
    }
}
