<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\DailyScore;
use Charts;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $daily =DailyScore::all();

        $chart =Charts::multi('line', 'fusioncharts')
            ->title("Crypto Sentiment Analysis")
            ->elementLabel('score')
            ->labels($daily->where('coin', 'like' ,'BTC')->pluck('date'))
            ->dataset('BTC',$daily->where('coin', 'like' ,'BTC')->pluck('score'))
            ->dataset('LTC',$daily->where('coin', 'like' ,'LTC')->pluck('score'))
            ->dataset('ETH',$daily->where('coin', 'like' ,'ETH')->pluck('score'))
            ->responsive(true);

        $chart2 =Charts::multi('bar', 'highcharts')
            ->title("Crypto Sentiment Analysis")
            ->elementLabel('score')
            ->labels($daily->where('coin', 'like' ,'BTC')->pluck('date'))
            ->dataset('BTC',$daily->where('coin', 'like' ,'BTC')->pluck('score'))
            ->dataset('LTC',$daily->where('coin', 'like' ,'LTC')->pluck('score'))
            ->dataset('ETH',$daily->where('coin', 'like' ,'ETH')->pluck('score'))
            ->responsive(true);

        $chart3 =Charts::multi('area', 'highcharts')
            ->title("Crypto Sentiment Analysis")
            ->elementLabel('score')
            ->labels($daily->where('coin', 'like' ,'BTC')->pluck('date'))
            ->dataset('BTC',$daily->where('coin', 'like' ,'BTC')->pluck('score'))
            ->dataset('LTC',$daily->where('coin', 'like' ,'LTC')->pluck('score'))
            ->dataset('ETH',$daily->where('coin', 'like' ,'ETH')->pluck('score'))
            ->responsive(true);

        return view('home',['chart' => $chart, 'chart2' => $chart2, 'chart3' => $chart3]);

    }
}
