<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Foundation\Inspiring;
use App\Models\Question;

class CalculateWeight extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'calculate_weight';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update the weights for each question';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        foreach (Question::get() as $question) {
            $question->weight = $question->getWeight();
            $question->save();
        }
    }
}
