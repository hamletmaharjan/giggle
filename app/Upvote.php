<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Upvote extends Model
{
    protected $table = 'upvotes';
    public $timestamps = false;
    
    public function article() {
        return $this->belongsTo('App\Article');
    }
}
