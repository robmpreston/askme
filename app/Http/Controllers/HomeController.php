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
    public function index($recipient_slug = 'deray-mckesson', $topic_slug = null, $featured_question_id = null)
    {
        if (strpos(url('/'), "askderay")) {
            $featured_question_id = $topic_slug;
            $topic_slug = ($recipient_slug == "deray-mckesson") ? null : $recipient_slug;
            $recipient_slug = 'deray-mckesson';
        }

        $isDeray = self::isForDeRay($recipient_slug);
        // Get Recipient
        $recipient_slug = $isDeray ? 'deray-mckesson' : $recipient_slug;
        $recipient = User::getBySlug($recipient_slug);
        if (!$recipient) {
            return view('errors.404');
        }

        // Get User
        $user = Auth::user();
        if ($user) {
            $user->setIP(); // update ip address
        }

        // Get The Topic
        $topic = $topic_slug ? $recipient->getTopicBySlug($topic_slug) : $recipient->getDefaultTopic();
        if (!$topic) {
            // do something
        }

        // Featured Question
        $featuredQuestion = null;
        if ($featured_question_id && is_numeric($featured_question_id)) {
            $featuredQuestion = $topic->getQuestionByID($featured_question_id);
            if (!$featuredQuestion) {
                return view('errors.404');
            }
        }

        // List Questions
        $isAdmin = $user && $user->isRecipient($recipient->id) ? true : false;

        // set base url
        $baseUrl = url($recipient_slug);
        if ($recipient_slug == 'deray-mckesson') {
            $baseUrl = "http://askderay.com";
        }

        return view('frontend.index', [
            'recipient' => $recipient,
            'logged_in' => Auth::check(),
            'user' => $user,
            'is_admin' => $isAdmin,
            'base_url' => $baseUrl,
            'user_location' => User::getLocation(),
            'topic' => $topic,
            'featured_question' => $featuredQuestion
        ]);
    }

    private static function isForDeRay($recipient_slug)
    {
        if ($recipient_slug == 'deray-mckesson') {
            return true;
        }
        if (is_numeric($recipient_slug)) {
            return true;
        }
        return false;
    }
}
