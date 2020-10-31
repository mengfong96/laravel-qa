<?php

namespace App;

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
     * One user can have many questions.
     */
    public function questions()
    {
        return $this->hasMany(Question::class);
    }

    /**
     * Inside index.blade.php file, there is a anchor tag with href="$question->user->url", actually will get the url attribute from here
     * This is the accessor, so the format: get[field]Attribute()
     * this will point to the route and pass the question id into the show method.
     */
    public function getUrlAttribute()
    {
        // return route("questions.show", $this->id);
        return '#';
    }

}
