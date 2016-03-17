<?php namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Models\Question;

class QuestionController extends Controller
{
    public function upvote()
    {
        return [
            'data' => null,
            'success' => true,
            'error' => null
        ];
    }

    public function downvote()
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
            'question' => 'required|max:255',
            'user-from' => 'required|max:100',
        ]);
        $question = Question::makeOne($request);
        
        // return view
    }

}
