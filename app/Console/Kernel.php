<?php

namespace App\Console;

use App\Jobs\GetCoinsForDaily;
use App\Jobs\GetCoinsForTweet;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Jobs\ProcessDailyScore;


class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
//        $schedule->call(function () {
//            GetTweet::dispatch('btc');
//        })->everyMinute();

        $schedule->call(function () {
            GetCoinsForDaily::dispatch();
        })->dailyAt('21:40');

        $schedule->call(function () {
            GetCoinsForTweet::dispatch();
        })->everyThirtyMinutes();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
