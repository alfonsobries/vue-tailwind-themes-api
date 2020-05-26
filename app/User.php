<?php

namespace App;

use Illuminate\Support\Arr;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
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

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'initials',
        'just_name',
    ];

    /**
     * User initials
     *
     * @return string
     */
    public function getInitialsAttribute()
    {
        preg_match_all('#(?<=\s|\b)\pL#u', $this->name, $initials);

        return strtoupper(implode('', array_slice($initials[0], 0, 2)));
    }

    /**
     * User name
     *
     * @return string
     */
    public function getJustNameAttribute()
    {
        $pieces = explode(' ', $this->name);

        return trim(Arr::get($pieces, 0));
    }
}
