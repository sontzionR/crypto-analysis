<?php
/**
 * Created by PhpStorm.
 * User: sontz
 * Date: 6/21/2018
 * Time: 1:20 PM
 */
return[

    'settings' => [
        'oauth_access_token' => env('TWITTER_ACCESS_TOKEN'),
        'oauth_access_token_secret' => env('TWITTER_ACCESS_TOKEN_SECRET'),
        'consumer_key' => env('TWITTER_CONSUMER_KEY'),
        'consumer_secret' => env('TWITTER_CONSUMER_SECRET')
    ],
    'coins' => [
        'BTC','LTC','ETH'
    ]
];
