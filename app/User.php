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
        'password', 'remember_token', 'created_at', 'updated_at', 'deleted_at',
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

    public static function getByEmail($email)
    {
        return User::where('email', '=', $email)->first();
    }

    /***************************************************************************************************
     ** GENERAL METHODS
     ***************************************************************************************************/

    public static function createSlug($first_name, $last_name)
    {
        $slug = substr($first_name . '-' . $last_name, 0, 20);
        if (self::slugExists($slug)) {
            $slug = $slug . rand(111, 99999);
        }
        return $slug;
    }

    public static function slugExists($slug)
    {
        return User::where('slug', '=', $slug)->exists();
    }

    public function listQuestions($limit)
    {
        return $this->questions()->with('asker', 'answer')->orderBy('weight', 'DESC')->take($limit)->get();
    }
}
