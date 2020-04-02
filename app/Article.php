<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{

    protected $table = 'articles';

    public function user(){
        return $this->belongsTo('App\User');
    }


    public function comments(){
        return $this->hasMany('App\Comment');
    }

    public function upvotes() {
        return $this->hasMany('App\Upvote');
    }

}
