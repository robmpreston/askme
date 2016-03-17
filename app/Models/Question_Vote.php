<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Question_Vote extends Model
{

    protected $table = 'question_votes';
    public $timestamps = true;
    protected $guarded = ['id'];
    protected $hidden = ['deleted_at'];
    use SoftDeletes;

    public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }

    /**
     * CREATE AN UP OR DOWN VOTE ON Question
     * @param (int) Answer ID, (boolean) Is it a down vote
     * @return (object) Answer_Vote
     */
    public static function makeOne($question_id, $down_vote = false)
    {
        $vote = self::getForUser($question_id);
        if (!$vote) {
            $vote = new Question_Vote;
            $vote->question_id = $question_id;
            $vote->user_id = $auth->user()->id;
        }
        $vote->is_down_vote = $down_vote;
        $vote->save();
        return $vote;
    }

    public static function getForUser($question_id)
    {
        return self::where('question_id', '=', $question_id)->where('user_id', '=', $auth->user()->id)->first();
    }
}