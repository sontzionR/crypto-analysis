<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\DB;
use SentimentAnalysis;

class ProcessTweet implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    protected $tweet;

    public function __construct($tweet)
    {
        $this->tweet = $tweet;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $analysis = new SentimentAnalysis();
        $analysisResultD = $analysis->decision($this->tweet['text']);
        $analysisResultS = $analysis->score($this->tweet['text']);
        print_r($analysisResultD);
        print_r($analysisResultS);
        $date = strtotime($this->tweet['created_at']);
//        print_r($analysisResult);
//        print_r($this->tweet);
        DB::table('tweets')->insert(
            [
                'user_id' => $this->tweet['id'],
                'dateTime' => $date,
                'text' => $this->tweet['text'],
                'scoreA' => $analysisResultS,
                'coin' => "BTC",
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );
        //print_r($analysisResult . ' : ' . $this->tweet);

    }
}
