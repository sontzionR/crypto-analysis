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

        $settings = array(
            'oauth_access_token' => env('TWITTER_ACCESS_TOKEN'),
            'oauth_access_token_secret' => env('TWITTER_ACCESS_TOKEN_SECRET'),
            'consumer_key' => env('TWITTER_CONSUMER_KEY'),
            'consumer_secret' => env('TWITTER_CONSUMER_SECRET')
        );

        $url = 'https://api.twitter.com/1.1/search/tweets.json';
        $getfield = "?q=#{$this->coin}&exclude_replies=true&include_rts=false&count=2000";
        $requestMethod = 'GET';

        $twitter = new TwitterAPIExchange($settings);
        $response = $twitter->setGetfield($getfield)
            ->buildOauth($url, $requestMethod)
            ->performRequest();
        $decoded = json_decode($response, true);
        //$i = 1;
        foreach ($decoded['statuses'] as $tweet){
            //print_r($tweet);

            //$result = $i ."   ".  $tweet['text'].'CREATED_AT:'.$tweet['created_at'];
            ProcessTweet::dispatch($tweet);
            //ProcessTweet::dispatch($result);
            //$i++;

        }

    }
}
