<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($slug = 'deray-mckesson')
    {
        $recipient = User::getBySlug($slug);
        if ($recipient) {
            $questions = $recipient->listQuestions(20);
            return view('frontend.index', [
                'recipient' => $recipient,
                'questions' => $questions,
                'logged_in' => Auth::check()
            ]);
        }
        // return 404 error
    }
}
