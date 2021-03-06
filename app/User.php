<?php

namespace App;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;
    protected $table = 'users';
    public $timestamps = true;


    protected $dates = ['deleted_at'];
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function getUploads()
    {
        return $this->hasMany('Upload', 'user_id');
    }

    public function getGameRoles()
    {
        return $this->hasMany('App\GameRole', 'user_id');
    }
    public function getStoryRoles()
    {
        return $this->hasMany(StoryRole::class, 'user_id');
    }

}
