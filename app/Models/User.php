<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'phone', 'type', 'status'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function images() {
        return $this->morphMany(Image::class, "imageable");
    }

    public function roles() {
        return $this->belongsToMany(Role::class);
    }

    public function hasRole($role){
        if(is_string($role))
        {
            return $this->roles->contains('slug',$role);
        }
        foreach($role as $val)
        {
            if($this->hasRole($val->slug))
            {
                return true;
            }
        }
        return false;
    }
}
