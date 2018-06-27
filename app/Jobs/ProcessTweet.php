<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\DB;
//use SentimentAnalysis;
use Google\Cloud\Core\ServiceBuilder;



class ProcessTweet implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    protected $tweet;
    protected $coin;

    public function __construct($tweet,$coin)
    {
        $this->tweet = $tweet;
        $this->coin = $coin;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $cloud = new ServiceBuilder([
            'keyFile' => str_replace("\\n", "\n",config('googleSentiment')),
            'projectId' => "crypto-analysis-twitter",
        ]);

        $language = $cloud->language();

        // Detect the sentiment of the text
        $annotation = $language->analyzeSentiment($this->tweet['text']);
        $sentiment = $annotation->sentiment();

//        echo 'Sentiment Score: ' . $sentiment['score'] . ', Magnitude: ' . $sentiment['magnitude'];
//        $analysis = new SentimentAnalysis();
//        $analysisResultD = $analysis->decision($this->tweet['text']);
//        $analysisResultS = $analysis->score($this->tweet['text']);
        $date = strtotime($this->tweet['created_at']);
        DB::table('tweets')->insert(
            [
                'user_id' => $this->tweet['id'],
                'dateTime' => $date,
                'text' => $this->tweet['text'],
                //'scoreA' => $analysisResultS,
                'scoreA' => $sentiment['score'],
                'coin' => $this->coin,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );
        //print_r($analysisResult . ' : ' . $this->tweet);

    }
}
