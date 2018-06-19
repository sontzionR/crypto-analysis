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
        //$btc = DailyScore::all()->where('coin',"BTC");
//        $chart = Charts::multiDatabase('line', 'google')
//            ->dataset('BTC', DailyScore::all()->pluck('score')->where('coin',"BTC"))
//            //->dataset('LTC', DailyScore::all()->pluck('score')->where('coin',"LTC"))
//            ->groupByDay();

        $btc = DailyScore::all()->where('coin', 'like' ,'BTC');
        $ltc = DailyScore::all()->where('coin', 'like' ,'LTC');
        $eth = DailyScore::all()->where('coin', 'like' ,'ETH');
        $chart =Charts::multi('line', 'highcharts')
            ->title("Crypto Sentiment Analysis")
            ->dimensions(1000, 500)
            //->values($data->pluck('score'))
            ->labels($btc->pluck('created_at'),true)
            ->dataset('BTC',$btc->pluck('score'))
            ->dataset('LTC',$ltc->pluck('score'))
            ->dataset('ETH',$eth->pluck('score'))
            ->responsive(true);;

//            ->responsive(true);
//        $data = DailyScore::all();
//        $chart = Charts::create('line', 'highcharts')
//            //->values($data->pluck('score'))
//            ->dimensions(1000, 500)
//            ->labels($data->pluck('created_at'))
//            ->values($data->pluck('score'))
//            ->responsive(true);


//        $data = DailyScore::all();
//        $coin = DB::table('daily_scores')->where('coin', 'BTC')->value('coin');
//       $chart = Charts::multi('line', 'material')
//            ->dataset($coin, $data->pluck('score'))
//            ->dataset('Element 2', $data->pluck('date'))
//            ->labels($data->pluck('created_at'));

//        $data = DailyScore::all();
//        $chart =Charts::create('line', 'highcharts')
//            ->title("My great nice Chart")
//            ->elementLabel('BTC')
//            ->dimensions(1000, 500)
//            ->labels($data->pluck('created_at'))
//            ->values($data->pluck('score'))
//            ->responsive(true);

        return view('home',['chart' => $chart]);

    }
}
