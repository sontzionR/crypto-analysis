<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\DailyScore;
use Charts;
use Illuminate\Support\Carbon;

class ChartsDisplayController extends Controller
{
    protected $coins;

    public function displayChart()
    {
        $this->coins = config('twitter.coins');

        $daysBack= Carbon::today()->subDays(62);
        $daily = DailyScore::whereDate('created_at', '>=', $daysBack)->get();

        $chart = Charts::multi('line', 'highcharts')
            ->title("Crypto Sentiment Analysis")
            ->elementLabel('score')
            ->labels($daily->unique('created_at')->sortBy('created_at')->pluck('created_at'));
            foreach ($this->coins as $coin){
                $chart->dataset($coin, $daily->where('coin', 'like', $coin)->sortBy('created_at')->pluck('score'));
            };
            $chart->responsive(true);

        return view('chart', ['chart' => $chart]);
    }
}
