<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /***************************************************************************************************
     ** RELATIONS
     ***************************************************************************************************/

    public function profile()
    {
        return $this->hasOne('App\Models\Profile', 'user_id');
    }

    public function questions()
    {
        return $this->hasMany('App\Models\Question', 'to_user_id');
    }

    /***************************************************************************************************
     ** GETTERS
     ***************************************************************************************************/

    public static function getBySlug($slug)
    {
        return User::with('profile')->where('slug', '=', $slug)->first();
    }

    /***************************************************************************************************
     ** GENERAL METHODS
     ***************************************************************************************************/

    public function listQuestions($limit)
    {
        return $this->questions()->with('answer')->orderBy('weight', 'DESC')->take($limit)->get();
    }
}
