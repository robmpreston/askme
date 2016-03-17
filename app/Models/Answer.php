<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use Event;
use App\Events\AnswerWasGiven;

class Answer extends Model
{

    protected $table = 'answers';
    public $timestamps = true;
    protected $guarded = ['id'];
    protected $hidden = ['deleted_at'];
    use SoftDeletes;

    /***************************************************************************************************
     ** RELATIONS
     ***************************************************************************************************/

    public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }

    public function question()
    {
        return $this->belongsTo('App\Models\Question', 'question_id');
    }

    /***************************************************************************************************
     ** GENERAL METHODS
     ***************************************************************************************************/

    /**
     * CREATE AN ANSWER
     * @param (object) Question, (array) Additional parameters depending on the answer type
     * @return (object) Answer
     */
    public static function makeOne(Question $question, $params)
    {
        $answer = new Answer;
        $answer->question()->attach($question);
        $answer->user()->attach($auth->user());
        $answer->text_response = array_get($params, 'text_response');
        $answer->video_url = array_get($params, 'video_url', null);
        $answer->is_video = array_get($params, 'is_video', false);
        $answer->save();

        Event::fire(new AnswerWasGiven($answer));
        return $answer;
    }

    public static function getLikeCount($answer_id)
    {
        return DB::table('answer_votes')->where('answer_id', '=', $answer_id)->where('is_down_vote', '=', false)->count();
    }
}