<?php namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests;
use App\Models\Question;
use App\Models\Question_Vote;
use App\User;

class QuestionController extends Controller
{
    public function upvote(Request $request)
    {
        $vote = Question_Vote::makeOne($request->question_id);
        if ($vote) {
            $net_votes = Question::updateNetVotes($request->question_id);
            return ['success' => true, 'error' => null, 'data' => ['net_votes' => $net_votes]];
        }
        return ['success' => false, 'error' => null];
    }

    public function downvote(Request $request)
    {
        $vote = Question_Vote::makeOne($request->question_id, true);
        if ($vote) {
            $net_votes = Question::updateNetVotes($request->question_id);
            return ['success' => true, 'error' => null, 'data' => ['net_votes' => $net_votes]];
        }
        return ['success' => false, 'error' => null];
    }

    /**
     * AJAX REQUEST
     * If Validation Fails Json Response w/ Errors
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'recipient_id' => 'required|integer',
            'asker_id' => 'required|integer',
            'question' => 'required|max:255',
        ]);

        $question = Question::makeOne($request);

        if ($question) {
            $recipient = User::find($question->to_user_id);

            return [
                'successs' => true,
                'error' => null,
                'data' => $recipient->listQuestions(20)
            ];
        }

        return [
            'success' => false,
            'error' => 'Failed to submit question',
            'data' => null
        ];
    }

    /*
     * AJAX REQUEST
     * Returns all questions for user
     */
    public function getAll($respondent_id)
    {
        return Question::getForRespondent($respondent_id);
    }
}
