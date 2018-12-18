<?php

namespace App\Http\Controllers;
use Auth;
use App\Market;
use App\UserMarket;
use App\MarketData;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests\EnumeratorDataRequest;
use Symfony\Component\HttpFoundation\Session\Session;

class EnumeratorMarketData extends Controller{

    public function __construct() {
        $this->middleware("dataTeam");
    }
    
     public function filter(){
        $data = array();
        $months = array();
        $months[1] = "January";
        $months[2] = "February";
        $months[3] = "March";
        $months[4] = "April";
        $months[5] = "May";
        $months[6] = "June";
        $months[7] = "July";
        $months[8] = "August";
        $months[9] = "September";
        $months[10] = "October";
        $months[11] = "November";
        $months[12] = "December";
        $data["months"] = $months;
        return view("enumerators.data.filter", $data);

    }



    
    public function fetch(EnumeratorDataRequest $request){
        $displayData = array();

        $input = $request->all();
        $year_name = $input['year_name'];
        $month_id = $input['month_id'];

        //Market Info
        $enumerator = Auth::user();
        $enumeratorMarketId = UserMarket::where("user_id",  $enumerator->id)->first()->market_id;
        $marketInfo = Market::where("id", $enumeratorMarketId)->first();

       
        //Market data
        $marketData = MarketData::join("indicators", "indicators.id", "=", "market_data.indicator_id")
        ->where("year_name", $year_name)
        ->where("month_id", $month_id)
        ->where("market_id", $enumeratorMarketId)
        ->get(["market_data.*", "indicators.indicator_business_name"]);
       
        $displayData["marketInfo"] = $marketInfo;
        $displayData["marketData"] = $marketData;
               
        return view('enumerators.data.display', $displayData);

    }

    

}
