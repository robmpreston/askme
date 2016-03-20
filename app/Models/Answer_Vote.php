<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Auth;
use App\User;

class Answer_Vote extends Model
{

    protected $table = 'answer_votes';
    public $timestamps = true;
    protected $guarded = ['id'];
    protected $hidden = ['deleted_at'];

    /***************************************************************************************************
     ** RELATIONS
     ***************************************************************************************************/

    public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }

    /**
     * CREATE AN UP OR DOWN VOTE ON ANSWER
     * @param (int) Answer ID, (boolean) Is it a down vote
     * @return (object) Answer_Vote
     */
    public static function makeOne($answer_id, $down_vote = false)
    {
        $vote = self::getForUser($answer_id);
        if ($vote && $vote->is_down_vote == $down_vote) {
            $vote->delete();
            return true;
        } 
        if (!$vote) {
            $vote = new Answer_Vote;
            $vote->answer_id = $answer_id;
            $vote->user_id = Auth::user() ? Auth::user()->id : 1;
        }
        $vote->is_down_vote = $down_vote;
        $vote->save();
        return $vote;
    }

    public static function getForUser($answer_id)
    {
        return self::where('answer_id', '=', $answer_id)->where('user_id', '=', Auth::user() ? Auth::user()->id : 1)->first();
    }
}