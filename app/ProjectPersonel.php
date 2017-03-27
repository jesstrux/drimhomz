<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProjectPersonel extends Model
{
    protected $fillable = [
        'project_id', 'user_id', 'position'
    ];

    public function project(){
        return $this->belongsTo("App\Project");
    }

    public function user(){
        return $this->belongsTo("App\User");
    }
}
