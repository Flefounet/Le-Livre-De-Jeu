<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class GameSessionComment extends Model 
{

    protected $table = 'gamesessions_comments';
    public $timestamps = true;


    protected $dates = ['deleted_at'];

}