<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\DB;
use App\Models\Question;
use App\Models\Answer;
use Auth;
use Carbon\Carbon;

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
            $aws_url = env('S3_URL') . 'profile-pictures/'; // ?
            $array['picture'] = $aws_url . $this->picture;
        }

        // FACEBOOK PIC
        if (!$this->picture && $this->facebook_id) {
            $array['picture'] = 'https://graph.facebook.com/' . $this->facebook_id . '/picture?type=square';
        }

        // DEFAULT PIC
        if (!$this->picture && !$this->facebook_id) {
            $aws_url = ''; // ?
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

    public function getLastQuestionForRecipient($recipient_id)
    {
        return Question::where('to_user_id', '=', $recipient_id)->where('from_user_id', '=', $this->id)->orderBy('created_at', 'DESC')->first();
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

    public function listQuestions($limit, $skip_ids = [])
    {
        // Collect the Questions w/ Answers By Weight
        $questions = $this->questions()->with('asker', 'answer');
        if (count($skip_ids)) {
            $questions->whereNotIn('id', $skip_ids);
        }
        $questions = $questions->orderBy('weight', 'DESC')->take($limit)->get();

        // Assign Whether and How The Logged In User Has Voted On Each Question && Answer
        if (Auth::check()) {
            $question_ids = Question::listIDsFromQuestions($questions);
            $answer_ids = Question::listAnswerIDsFromQuestions($questions);
            $questions = Question::assignUserVotes($questions, $question_ids, $answer_ids);
        }
        return $questions;
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
}
