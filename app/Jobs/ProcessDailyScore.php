<?php

namespace App\Jobs;

use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
//use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class ProcessDailyScore implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
//        $this->coin = $coin;

    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $totals = DB::table('tweets')
                ->whereDate('created_at', today())
                ->avg('scoreA');

      //  foreach ($totals as $total) {
            echo $totals;
            DB::table('daily_scores')->insert(
                [
                    'date' => today(),
                    'coin' => 'BTC',
                    'score' => $totals,
                ]
            );


    }

}
