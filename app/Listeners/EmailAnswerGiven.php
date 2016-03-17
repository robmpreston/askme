<?php

namespace App\Listeners;

use App\Events\QuestionWasAnswered;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

// models
use Askme\Models\Answer;

class EmailAnswerGiven implements ShouldQueue
{   
    public $answer;

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(Answer $answer)
    {
        $this->answer = $answer;
    }

    /**
     * Handle the event.
     *
     * @param  SomeEvent  $event
     * @return void
     */
    public function handle(QuestionWasAnswered $event)
    {
        //
    }
}
