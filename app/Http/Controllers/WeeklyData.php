<?php

namespace App\Http\Controllers;

use DB;
use App\MarketData;
use Illuminate\Http\Request;

class WeeklyData extends Controller
{

    public function __construct()
    {
        //$this->middleware("dataAnalyst");
    }


    public function weekly_data()
    {
        return view('analyst.weekly-data');
    }

    public function data_entry()
    {
        $data = array();
        return view("analyst.weekly-data-entry", $data);

    }


    public function save_weekly(Request $request)
    {

        $marketData = json_decode($request->all()["market_data"]);
        $savedRecords = 0;
        $existingRecords = 0;

        for ($i = 0; $i < count($marketData); $i++) {
            $priceObject = $marketData[$i];
            $data['market_id'] = $priceObject->market_id;
            $data['year_name'] = $priceObject->year_name;
            $data['month_id'] = $priceObject->month_id;
            $data['week'] = $priceObject->week_id;
            $data['indicator_id'] = $priceObject->indicator_id;
            $data['price'] = $priceObject->price;

            //Check for saved data
            $savedPrice = $this->savedPrice($data);

            if (!$savedPrice) {
               MarketData::create($data); //Price does not exist so save it
                $savedRecords++;
            } else {
                $existingRecords++; //Price exists so notify user
            }
        }

        return json_encode(array("saved" => $savedRecords, "existing" => $existingRecords));


    }


    public function savedPrice(array $data)
    {
        $year_name = $data['year_name'];
        $month_id = $data['month_id'];
        $market_id = $data['market_id'];
        $indicator_id = $data['indicator_id'];
        $week = $data['week'];

        $query = "SELECT * FROM market_data m ";
        $query .= "WHERE m.year_name = $year_name AND m.month_id = $month_id ";
        $query .= "AND m.market_id = $market_id AND m.indicator_id = $indicator_id ";
        $query .= "AND week = $week ";
        return DB::select(DB::raw($query));

    }
}
