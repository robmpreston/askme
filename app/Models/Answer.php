<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use Auth;
use App\User;
use Event;
use App\Events\AnswerWasGiven;

class Answer extends Model
{

    protected $table = 'answers';
    public $timestamps = true;
    protected $guarded = ['id'];
    protected $hidden = ['deleted_at'];
    use SoftDeletes;

    public function toArray()
    {
        $array = parent::toArray();

        if (!array_has($array, 'has_voted')) {
            $array['has_voted'] = false;
        }
        if (!array_has($array, 'upvoted')) {
            $array['upvoted'] = false;
        }
        if (!array_has($array, 'upvoted')) {
            $array['downvoted'] = false;
        }
        return $array;
    }

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

    public function likes()
    {
        return $this->hasMany('App\Models\Answer_Vote')->where('is_down_vote', '=', false);
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
        if ($question->answer) {
            return false; // prevent duplicates
        }
        $answer = new Answer;
        $answer->question_id = $question->id;
        $answer->user_id = Auth::user() ? Auth::user()->id : 5;
        $answer->text_response = array_get($params, 'text_response');
        $videoUrl = array_get($params, 'video_url', null);
        $answer->is_video = ($videoUrl !== null && $videoUrl !== false);
        $answer->video_url = self::getIdFromUrl($videoUrl);
        $answer->save();

        //Event::fire(new AnswerWasGiven($answer));
        return $answer;
    }

    public static function getLikeCount($answer_id)
    {
        return DB::table('answer_votes')->where('answer_id', '=', $answer_id)->where('is_down_vote', '=', false)->count();
    }

    public static function updateLikeCount($answer_id)
    {
        $count = self::getLikeCount($answer_id);
        DB::table('answers')->where('id', '=', $answer_id)->update(['net_votes' => $count]);
        return $count;
    }

    private static function getIdFromUrl($url)
    {
        $parts = parse_url($url);
        if(isset($parts['query'])){
            parse_str($parts['query'], $qs);
            if(isset($qs['v'])){
                return $qs['v'];
            } else if(isset($qs['vi'])){
                return $qs['vi'];
            }
        }
        if(isset($parts['path'])){
            $path = explode('/', trim($parts['path'], '/'));
            return $path[count($path)-1];
        }
        return false;
    }
}
