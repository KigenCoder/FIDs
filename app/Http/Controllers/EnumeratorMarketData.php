<?php

namespace App\Http\Controllers;
use Auth;
use App\Market;
use App\UserMarket;
use App\MarketData;
use App\Indicator;
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

        $indicatorQuery = "SELECT distinct(m.indicator_id), i.indicator_business_name FROM market_data m ";
        $indicatorQuery .= "JOIN indicators i ON i.id = m.indicator_id ";
        $indicatorQuery .= " WHERE m.market_id = $enumeratorMarketId AND m.year_name = $year_name AND m.month_id = $month_id ";
        $indicators = DB::select(DB::raw($indicatorQuery));
        $marketData = array();
       
        foreach($indicators as $indicator){
            $indicatorId = $indicator->indicator_id;
            $indicator_business_name = $indicator->indicator_business_name;
                     $indicatorData = MarketData::where("year_name", $year_name)
                     ->where('month_id', $month_id)
                     ->where('indicator_id', $indicatorId) 
                     ->where('market_id', $enumeratorMarketId)
                     ->get(["week", "price"]);
                     $marketData[$indicator_business_name] = $indicatorData;
                     }

                     $priceData = array();

                     //Prep Market data
                     foreach($marketData as $indicator => $data){
                        
                        $temp = array();
                              for($i=0; $i<count($data); $i++){
                                  $currentData = $data[$i];
                                $temp[$currentData->week]= $currentData->price;
                              }
                              $priceData[$indicator] = $temp;
                     }
        $displayData["marketInfo"] = $marketInfo;
        $displayData["priceData"] = $priceData;  
        

        return view('enumerators.data.display', $displayData);

    }

    

}
