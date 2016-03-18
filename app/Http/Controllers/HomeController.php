<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $slug = 'deray-mckesson';
        $recipient = User::getBySlug($slug);
        if ($recipient) {
            $questions = $recipient->listQuestions(20);
            return response()->json([
                'recipient' => $recipient,
                'questions' => $questions,
            ]);
        }
        // return 404 error
    }
}
