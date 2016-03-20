<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use Auth;
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
            $loggedIn = Auth::check();
            $user = Auth::user();
            $isAdmin = false;
            if ($user && $user->id == $recipient->id) {
                $isAdmin = true;
            }
            return view('frontend.index', [
                'recipient' => $recipient,
                'questions' => $questions,
                'logged_in' => $loggedIn,
                'user' => $user,
                'is_admin' => $isAdmin,
                'base_url' => url($slug)
            ]);
        }
        // return 404 error
    }
}
