<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Auth;
use Carbon\Carbon;
use App\User;

class User_IP extends Model
{

    protected $table = 'user_ips';
    public $timestamps = true;
    protected $guarded = ['id'];
    protected $hidden = [];

    /***************************************************************************************************
     ** RELATIONS
     ***************************************************************************************************/

    public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }

    /***************************************************************************************************
     ** GENERAL METHODS
     ***************************************************************************************************/

    public static function makeOne(User $user, $ip_address)
    {
        $ip_obj = new User_IP;
        $ip_obj->user_id = $user->id;
        $ip_obj->ip_address = $ip_address;
        $ip_obj->last_used = Carbon::now();
        $ip_obj->save();
        return $ip_obj;
    }

    public function setLastUsed()
    {
        $this->last_used = Carbon::now();
        $this->save();
    }

}