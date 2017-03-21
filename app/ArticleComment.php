<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ArticleComment extends Model
{
    protected $fillable = [
        'user_id', 'article_id', 'content'
    ];

    public function article(){
        return $this->belongsTo("App\Article");
    }

    public function user(){
        return $this->belongsTo("App\User");
    }
}
