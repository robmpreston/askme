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
        $question->user_from = $request->user_from;
        $question->text_response = $request->question;
        $question->weight = $question->getWeight();
        $question->save();
        return $question;
    }

    /**
     * GET QUESTIONS FOR RESPONDENT
     * @param (int) Respondent Id
     * @return (array of objects) Question
     */
    public static function getForRespondent($respondent_id)
    {
        return self::with('votes', 'asker', 'answer')->where('to_user_id', '=', $respondent_id)->get();
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

}
