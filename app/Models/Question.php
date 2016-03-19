<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Auth;
use Event;

class Question extends Model
{

    protected $table = 'questions';
    public $timestamps = true;
    protected $guarded = ['id'];
    protected $hidden = ['deleted_at'];
    use SoftDeletes;

    /***************************************************************************************************
     ** RELATIONS
     ***************************************************************************************************/

    public function asker()
    {
        return $this->belongsTo('App\User', 'from_user_id');
    }

    public function respondent()
    {
        return $this->belongsTo('App\User', 'to_user_id');
    }

    public function votes()
    {
        return $this->hasMany('App\Models\Question_Votes', 'question_id');
    }

    public function up_votes()
    {
        return $this->hasMany('App\Models\Question_Votes', 'question_id')->where('is_down_vote', '=', false);
    }

    public function down_votes()
    {
        return $this->hasMany('App\Models\Question_Votes', 'question_id')->where('is_down_vote', '=', true);
    }

    public function answer()
    {
        return $this->hasOne('App\Models\Answer', 'question_id');
    }

    /***************************************************************************************************
     ** GENERAL METHODS
     ***************************************************************************************************/

    /**
     * CREATE A QUESTION
     * @param (object) Request
     * @return (object) Question
     */
    public static function makeOne(Request $request)
    {
        $question = new Question;
        $question->to_user_id = $request->recipient_id;
        $question->from_user_id = Auth::user() ? Auth::user()->id : 1;
        $question->text_response = $request->question;
        $question->weight = $question->getWeight();
        $question->save();

        if ($request->user_from && Auth::user()) {
            Auth::user()->setFrom($request->user_from);
        }
        return $question;
    }

    public function getWeight()
    {
        $ups = $this->exists ? $this->up_votes()->count() : 0;
        $downs = $this->exists ? $this->down_votes()->count() : 0;
        $s = $ups - $downs;
        $order = log10(max(abs($s), 1));
        $sign = self::getSign($s);
        $date = $this->exists ? $this->created_at->timestamp : time();
        $seconds = $date - 1134028003;
        return round($sign * $order + $seconds / 45000, 7);
    }

    public static function getSign($s)
    {
        if ($s == 0) {
            return 0;
        }
        return $s > 0 ? 1 : -1;
    }

    public static function getNetVoteCount($question_id)
    {
        $ups = DB::table('question_votes')->where('question_id', '=', $question_id)->where('is_down_vote', '=', false)->count();
        $downs = DB::table('question_votes')->where('question_id', '=', $question_id)->where('is_down_vote', '=', true)->count();
        $net = $ups - $downs;
        return $net;
    }

    public static function updateNetVotes($question_id)
    {
        $net_votes = self::getNetVoteCount($question_id);
        DB::table('questions')->where('id', '=', $question_id)->update(['net_votes' => $net_votes]);
        return $net_votes;
    }

    /***************************************************************************************************
     ** PAGE LIST OPTIMIZATION FUNCTIONS
     ***************************************************************************************************/

    /**
     * LIST IDS FOR GROUP OF QUESTIONS
     * @param (collection) Questions
     * @return (array) Ids of Questions
     */
    public static function listIDsFromQuestions($questions)
    {
        $question_ids = $questions->map(function ($question) { return $question->id; });
        return $question_ids;
    }

    /**
     * LIST IDS OF ANSWERS FOR GROUP OF QUESTIONS
     * @param (collection) Questions
     * @return (array) Ids of Answers (if exist)
     */
    public static function listAnswerIDsFromQuestions($questions)
    {
        $answer_ids = $questions->map(function ($question) { 
            if ($question->answer) {
                return $question->answer->id;
            }
        });
        return $answer_ids;
    }

    /**
     * ADD TO EACH QUESTION WHETHER THE LOGGED IN USER HAS VOTED
     * @param (collection) Questions.Answers, (array) Question IDs w/ Votes, (array) Answer IDs w/ Votes
     * @return (collection) Questions.Answers (with has_voted assigned);
     */
    public static function assignUserVotes($questions, $question_ids, $answer_ids)
    {
        $list = [];

        // User Question Votes ([ 'question_id' => (boolean) is_down_vote ])
        $q_votes = Auth::user()->getQuestionVotes($question_ids);

        $a_votes = Auth::user()->getAnswerVotes($answer_ids);
        foreach ($questions as $question) {
            $question->has_voted = array_has($q_votes, $question->id); // has the user voted
            $question->is_down_vote = (bool) array_get($q_votes, $question->id, null); // if so, is it a down vote?

            if ($question->answer) {
                $question->answer->has_voted = array_has($a_votes, $question->answer->id);
                $question->answer->is_down_vote = (bool) array_get($a_votes, $question->answer->id, null);
            }
            $list[] = $question;
        }
        return $list;
    }



}
