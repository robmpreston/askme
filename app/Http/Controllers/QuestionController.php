<?php namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests;
use App\Models\Question;
use App\Models\Question_Vote;
use App\Models\Topic;
use App\User;
use Log;

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

    public function hideQuestion(Request $request)
    {
        $user = Auth::user();
        if ($user->respondant) {
            $question = Question::find($request->question_id);
            if ($user->id = $question->to_user_id) {
                $question->hide();
                return [
                    'success' => true,
                    'error' => null,
                    'data' => $user->listQuestions(20),
                ];
            }
        }
        return ['success' => false, 'error' => 'Action not allowed', 'data' => null];
    }

    public function showQuestion(Request $request)
    {
        $user = Auth::user();
        if ($user->respondant) {
            $question = Question::find($request->question_id);
            if ($user->id = $question->to_user_id) {
                $question->show();
                return [
                    'success' => true,
                    'error' => null,
                    'data' => $user->listQuestions(20),
                ];
            }
        }
        return ['success' => false, 'error' => 'Action not allowed', 'data' => null];
    }

    /**
     * AJAX REQUEST
     * If Validation Fails Json Response w/ Errors
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'recipient_id' => 'required|integer',
            'topic_id' => 'required|integer',
            'asker_id' => 'required|integer',
            'question' => 'required|max:255',
        ]);

        if (Auth::user()->justAsked($request->topic_id)) {
            return [
                'successs' => false,
                'error' => 'To prevent spam. You have to wait ' . Question::latencyMinutes() . ' minutes between posting questions.',
                'data' => null,
            ];
        }

        $topic = Topic::find($request->topic_id);
        if (!$topic || !$topic->isLive()) {
            return [
                'successs' => false,
                'error' => 'You cannot post a question yet for this topic.',
                'data' => null,
            ];
        }


        $question = Question::makeOne($request);
        if ($question) {
            $recipient = User::find($question->to_user_id);
            $list = $recipient->listQuestions(20, [$question->id]);
            array_unshift($list, $question);
            return [
                'success' => true,
                'error' => null,
                'data' => $list,
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

    public function getQuestions(Request $request)
    {
        $user = Auth::user();
        $recipient = User::find($request->input('recipient_id'));
        $topic = $request->input('topic_id') ? $recipient->getTopicByID($request->input('topic_id')) : $recipient->getDefaultTopic();
        if ($recipient) {
            $show_hidden = $user && $user->isRecipient($recipient->id) ? true : false;
            return response()->json($recipient->listQuestions(20, [], $show_hidden, $request->input('sort'), $request->input('offset')));
        }
    }
}
