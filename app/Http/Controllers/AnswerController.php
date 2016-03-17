<?php namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Models\Answer;
use App\Models\Answer_Vote;

class AnswerController extends Controller
{
    public function like(Request $request)
    {
        $vote = Answer_Vote::makeOne($request->answer_id);
        if ($vote) {
            $likes = Answer::getLikeCount($request->answer_id);
            return ['success' => true, 'error' => null, 'data' => ['count' => $likes]];
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
            'respondent_id' => 'required|integer',
            'question_id' => 'required|integer',
            'video_url' => 'max:255',
        ]);

        $question = Question::find($request->question_id);
        $answer = Answer::makeOne($question, [
        	'text_response' => $request->text_response,
        	'is_video' => $request->video_url ? true : false,
        	'video_url' => $request->video_url,
        ]);
        // return view
    }
}
