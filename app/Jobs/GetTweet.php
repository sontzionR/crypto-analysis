<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use TwitterAPIExchange;


class GetTweet implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    protected $coin;

    public function __construct($coin)
    {
        $this->coin = $coin;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $settings = config('twitter.settings');
        $url = 'https://api.twitter.com/1.1/search/tweets.json';
        $getfield = "?q=#{$this->coin}&result_type=recent&exclude_replies=true&include_rts=false&count=10";
        $requestMethod = 'GET';

        $twitter = new TwitterAPIExchange($settings);
        $response = $twitter->setGetfield($getfield)
            ->buildOauth($url, $requestMethod)
            ->performRequest();
        $decoded = json_decode($response, true);

        foreach ($decoded['statuses'] as $tweet){
            ProcessTweet::dispatch($tweet,$this->coin);
        }
    }
}
