<?php namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;

class AnswerController extends Controller
{
    public function like()
    {
        return [
            'data' => null,
            'success' => true,
            'error' => null
        ];
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
