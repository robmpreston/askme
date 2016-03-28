<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use Auth;
use App\User;
use Carbon\Carbon;

class Topic extends Model
{

    protected $table = 'topics';
    public $timestamps = true;
    protected $guarded = ['id'];
    protected $hidden = ['created_at', 'updated_at', 'deleted_at'];
    use SoftDeletes;

    /***************************************************************************************************
     ** RELATIONS
     ***************************************************************************************************/

    public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }

    public function questions()
    {
        return $this->hasMany('App\Models\Question', 'topic_id');
    }

    /***************************************************************************************************
     ** CRUD
     ***************************************************************************************************/

    /**
     * CREATE AN UP OR DOWN VOTE ON ANSWER
     * @param (int) Answer ID, (boolean) Is it a down vote
     * @return (object) Answer_Vote
     */
    public static function makeOne(User $user, $params = [])
    {
        $topic = new Topic;
        $topic->user()->associate($user);
        $topic->name = $params['name'];
        $topic->slug = self::getSlug($user, $params['slug']);
        $topic->setStartTime($params);
        $topic->setDefault(array_get($params, 'default', true));
        $topic->closed = false;
        $topic->save();
    }

    /***************************************************************************************************
     ** GETTERS
     ***************************************************************************************************/

    public function getQuestionByID($question_id)
    {
        return $this->questions()->where('id', $question_id)->where('hide', false)->first();
    }

    public function listQuestions($limit, $skip_ids = [], $show_hidden = false, $sort = 'trending', $offset = false)
    {
        // Collect the Questions w/ Answers By Weight
        $questions = $this->questions()->with('asker', 'answer');
        if (count($skip_ids)) {
            $questions->whereNotIn('id', $skip_ids);
        }
        if (!$show_hidden) {
            $questions->where('hide', '=', false);
        }
        switch ($sort) {
            case 'trending':
                $questions->orderBy('weight', 'DESC');
                break;
            case 'date':
                $questions->orderBy('created_at', 'DESC');
                break;
            case 'answered':
                $questions->join('answers', 'questions.id', '=', 'answers.question_id')->select('questions.*')->orderBy('created_at', 'DESC');
                break;
            case 'rank':
                $questions->orderBy('net_votes', 'DESC');
                break;
            default: 
                $questions->orderBy('weight', 'DESC');
        }

        if ($offset) {
            $questions->skip($offset);
        }
        
        $questions = $questions->take($limit)->get();

        // Assign Whether and How The Logged In User Has Voted On Each Question && Answer
        if (Auth::check()) {
            $question_ids = Question::listIDsFromQuestions($questions);
            $answer_ids = Question::listAnswerIDsFromQuestions($questions);
            $questions = Question::assignUserVotes($questions, $question_ids, $answer_ids);
        }
        return $questions;
    }

    /***************************************************************************************************
     ** HELPERS
     ***************************************************************************************************/

    public function setStartTime($params)
    {
        // set timezone
        $this->timezone = array_get($params, 'timezone', 'America/New_York');

        // starts now
        $starts_now = array_get($params, 'starts_now', false);
        if ($starts_now) {
            $this->opens_at = Carbon::now($this->timezone);
            return;
        }

        $start_date = array_get($params, 'start_date');
        $start_time = array_get($params, 'start_time');

        $this->opens_at = Carbon::createFromFormat('Y-m-d H:i', $start_date . ' ' . $start_time, $this->timezone);
        return;
    }

    public function setDefault($default, $save = false)
    {
        // Clear out the previous default topic
        if ($default) {
            self::clearDefaultTopic($this->user);
        }
        $this->default = $default;
        if ($save) {
            $this->save();
        }
    }

    public static function clearDefaultTopic(User $user)
    {
        DB::table('topics')->where('user_id', $user->id)->update(['default' => 0]);
    }

    /**
     * STRIP THE SLUG OF BAD CHARACTERS
     * MAKE SURE IT'S UNIQUE
     */
    public static function getSlug(User $user, $slug)
    {
        $slug = self::cleanSlug($slug);
        if (!self::slugExists($user, $slug)) {
            return $slug;
        }
        return $slug . '-' . rand(3,999);
    }

    public static function cleanSlug($slug)
    {
        // remove anything containing that's not alphanumeric, underscore, dash
        $slug = preg_replace('/[^\w-]/', '', $slug);

        // replace underscore with hyphen
        $slug = str_replace('_', '-', $slug);

        return $slug;
    }

    public static function slugExists(User $user, $slug)
    {
        return self::where('user_id', $user->id)->where('slug', $slug)->exists();
    }
}