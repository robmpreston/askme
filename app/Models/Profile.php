<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Auth;

class Profile extends Model
{

    protected $table = 'profiles';
    public $timestamps = true;
    protected $guarded = ['id'];
    protected $hidden = [
        'created_at', 'updated_at', 'deleted_at',
    ];
    use SoftDeletes;

    /***************************************************************************************************
     ** RELATIONS
     ***************************************************************************************************/

    public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }

    public function updateProfile($request)
    {
        $this->i_am_a = $request->i_am_a;
        $this->description = $request->description;
        $this->save();

        return true;
    }
}
