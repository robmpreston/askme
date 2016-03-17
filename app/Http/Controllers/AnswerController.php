<?php

namespace App\Http\Controllers;

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
}
