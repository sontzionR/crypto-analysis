<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
use App\Jobs\GetTweet;
use App\Jobs\ProcessDailyScore;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/tweets',function(){
    GetTweet::dispatch('btc');
});

Route::get('/daily',function(){
    ProcessDailyScore::dispatch();
});

Route::get('/time', function (){
    echo(now());
});
