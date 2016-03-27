<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Auth;
use App\User;
use App\Models\Question;
use Log;

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
     * MAIN LIST OF QUESTIONS OR SINGLE QUESTION
     */
    public function index($slug = 'deray-mckesson', $question = null)
    {
        // SINGLE QUESTION
        $featuredQuestion = null;
        if (is_numeric($slug)) {
            $question_id = $slug;
            $featuredQuestion = Question::find($question_id);
            if (!$featuredQuestion) {
                return view('errors.404');
            }
            $recipient = $featuredQuestion->getRecipient();
            $slug = $recipient->slug;
        }

        // GET THE QUESTION RECIPIENT
        $recipient = $featuredQuestion ? $recipient : User::getBySlug($slug);
        if ($recipient) {

            // get user
            $loggedIn = Auth::check();
            $user = Auth::user();

            // show hidden for the recipient
            $isAdmin = $user && $user->isRecipient($recipient->id) ? true : false; 
            $show_hidden = $isAdmin ? true : false;

            // get questions list
            $limit = 20;
            $questions = $recipient->listQuestions($limit, [], $show_hidden, Input::get('sort'));
         
            // set base url
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
                'location' => User::getLocation(),
                'featured_question' => $featuredQuestion
            ]);
        }
        // return 404 error
    }
}
