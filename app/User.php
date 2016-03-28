<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Request;
use Illuminate\Support\Facades\DB;
use App\Models\Question;
use App\Models\Answer;
use App\Models\User_IP;
use Auth;
use Carbon\Carbon;
use Torann\GeoIP\GeoIPFacade as GeoIP;
use Log;

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

    public function toArray()
    {
        $array = parent::toArray();

        // UPLOADED PIC
        if ($this->picture) {
            $aws_url = env('S3_URL') . 'profile-pictures/';
            $array['picture'] = $aws_url . $this->picture;
        }

        // FACEBOOK PIC
        if (!$this->picture && $this->facebook_id) {
            $array['picture'] = 'https://graph.facebook.com/' . $this->facebook_id . '/picture?type=square';
        }

        // DEFAULT PIC
        if (!$this->picture && !$this->facebook_id) {
            $aws_url = env('S3_URL') . 'images/';
            $array['picture'] = $aws_url . '/default_profile_pic.jpg';
        }
        return $array;
    }

    /***************************************************************************************************
     ** RELATIONS
     ***************************************************************************************************/

    public function profile()
    {
        return $this->hasOne('App\Models\Profile', 'user_id');
    }

    public function topics()
    {
        return $this->hasMany('App\Models\Topic', 'user_id');
    }

    public function questions()
    {
        return $this->hasMany('App\Models\Question', 'to_user_id');
    }

    public function ips()
    {
        return $this->hasMany('App\Models\User_IP', 'user_id');
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

    public function getLastQuestionForRecipient($recipient_id)
    {
        return Question::where('to_user_id', '=', $recipient_id)->where('from_user_id', '=', $this->id)->orderBy('created_at', 'DESC')->first();
    }

    public function getIP($ip_address)
    {
        return $this->ips()->where('ip_address', '=', $ip_address)->first();
    }

    public function getDefaultTopic()
    {
        return $this->topics()->where('default', true)->first();
    }

    public function getTopicByID($topic_id)
    {
        return $this->topics()->where('id', $topic_id)->first();
    }

    public function getTopicBySlug($slug)
    {
        return $this->topics()->where('slug', $slug)->first();
    }

    /***************************************************************************************************
     ** SETTERS
     ***************************************************************************************************/

    public function setIP()
    {
        $ip = Request::ip();
        $ip_obj = $this->getIP($ip);
        if ($ip_obj) {
            return $ip_obj->setLastUsed();
        }
        return User_IP::makeOne($this, $ip);
    }

    /***************************************************************************************************
     ** GENERAL METHODS
     ***************************************************************************************************/

    public function setFrom($from)
    {
        if ($this->from != $from) {
            $this->from = $from;
            $this->save();
        }
    }

    public function isRecipient($id)
    {
        if ($this->id == $id) {
            return true;
        }
        return false;
    }

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

    public function justAsked($recipient_id)
    {
        $question = $this->getLastQuestionForRecipient($recipient_id);
        if ($question && Carbon::now()->subMinute(Question::latencyMinutes()) < $question->created_at->toDateTimeString()) {
            return true;
        }
        return false;
    }

    public function getFeaturedQuestion($question_id)
    {
        $featuredQuestion = null;
        if ($question_id) {
            $featuredQuestion = $this->questions()->with('asker', 'answer')->where('id','=',$question_id)->first();
        }

        return $featuredQuestion;
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

    public function updateDetails($request)
    {
        $this->first_name = $request->first_name;
        $this->last_name = $request->last_name;
        $this->email = $request->email;
        $this->from = $request->from;
        if ($request->password && $request->password != '') {
            $this->password = bcrypt($request->password);
        }
        $this->save();

        return true;
    }

    public function updateProfile($request)
    {
        $this->first_name = $request->first_name;
        $this->last_name = $request->last_name;
        $this->from = $request->from;
        $this->profile->updateProfile($request);
        $this->save();

        return true;
    }

    /**
     * GET VOTE ID && UP or DOWN FOR QUESTION VOTES
     * @param (array) Question IDs
     * @return (array) [KEY: (int) question_id => VALUE: (boolean) up or down vote]
     */
    public function getQuestionVotes($question_ids = [])
    {
        return DB::table('question_votes')->where('user_id', '=', $this->id)->whereIn('question_id', $question_ids)->lists('is_down_vote', 'question_id');
    }

    /**
     * GET VOTE ID && UP or DOWN FOR ANSWER VOTES
     * @param (array) Answer IDs
     * @return (array) [ KEY: (int) answer_id => VALUE: (boolean) up or down vote]
     */
    public function getAnswerVotes($answer_ids = [])
    {
        return DB::table('answer_votes')->where('user_id', '=', $this->id)->whereIn('answer_id', $answer_ids)->lists('is_down_vote', 'answer_id');
    }

    /***************************************************************************************************
     ** LOGGING
     ***************************************************************************************************/

    public static function getLocation()
    {
        $location = GeoIP::getLocation(Request::ip());
        if ($location) {
            return $location['city'] . ', ' . $location['state'];
        }
        return null;
    }
}
