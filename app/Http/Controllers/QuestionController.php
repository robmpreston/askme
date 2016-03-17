<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

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
}
