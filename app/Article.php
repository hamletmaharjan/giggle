<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{

    protected $table = 'articles';

    public function user(){
        return $this->belongsTo('App\User');
    }
}
