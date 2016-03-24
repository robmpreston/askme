<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
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
    public function index($slug = 'deray-mckesson', $question = null)
    {
        if (is_numeric($slug)) {
            $question = $slug;
            $slug = 'deray-mckesson';
        }
        $recipient = User::getBySlug($slug);
        if ($recipient) {
            $loggedIn = Auth::check();
            $user = Auth::user();
            $show_hidden = false; //$user && $user->isRecipient($recipient->id) ? true : false;
            $questions = $recipient->listQuestions(20, [], $show_hidden, Input::get('sort'));
            $featuredQuestion = null;
            if ($question) {
                $featuredQuestion = $recipient->getFeaturedQuestion($question);
            }
            $isAdmin = false;
            if ($user && $user->id == $recipient->id) {
                $isAdmin = true;
            }

            $baseUrl = url($slug);
            if ($slug == 'deray-mckesson') {
                $baseUrl = "http://askderay.com";
            }

            return view('frontend.index', [
                'recipient' => $recipient,
                'questions' => $questions,
                'logged_in' => $loggedIn,
                'user' => $user,
                'is_admin' => $isAdmin,
                'base_url' => $baseUrl,
                'featured_question' => $featuredQuestion
            ]);
        }
        // return 404 error
    }
}
