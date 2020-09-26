<?php

namespace App\Http\Controllers;

use DB;
use App\MarketData;
use Illuminate\Http\Request;

class DataEntry extends Controller
{

    public function __construct()
    {
        //$this->middleware("dataAnalyst");
    }

    public function data_entry()
    {
        $data = array();
        return view("analyst.data-entry", $data);
    }




    public function save_data(Request $request)
    {
        $response = null;
        if ($request->has('year_name') && $request->has('month_id')
            && $request->has('week') && $request->has('market_id')
            && $request->has('indicator_id') && $request->has('price')) {

            $input = $request->all();
            $data = array();
            $data['year_name'] = $input['year_name'];
            $data['month_id'] = $input['month_id'];
            $data['week'] = $input['week'];
            $data['market_id'] = $input['market_id'];
            $data['indicator_id'] = $input['indicator_id'];
            $data['price'] = $input['price'];
            $supply_id = is_null($input['supply_id']) ? '3' : $input['supply_id'];
            $data['supply_id'] = $supply_id;

            //return json_encode($data);
            $savedPrice = $this->savedPrice($data);

            if (!$savedPrice) {
                //Price does not exist so save it

                MarketData::create($data);
                $message = "Record saved..!";
            } else {
                $message = "Record exists..!";
            }
            $response = array("message" => $message, "data" => $data);
        }
        return json_encode($response);
    }




    public function supply_update(Request $request)
    {
        $response = null;
        if ($request->has('year_name') && $request->has('month_id')
            && $request->has('market_id') && $request->has('indicator_id')
            && $request->has('supply_id')) {
            $input = $request->all();
            $data = array();
            $data['year_name'] = $input['year_name'];
            $data['month_id'] = $input['month_id'];
            $data['week'] = "";
            $data['market_id'] = $input['market_id'];
            $data['indicator_id'] = $input['indicator_id'];
            $savedData = $this->savedPrice($data);
            $updated = 0;
            //$update_ids = array();
            for ($i = 0; $i < count($savedData); $i++) {
                $fetched = MarketData::findOrFail($savedData[$i]->id);
                $fetched->supply_id = $input['supply_id'];
                $fetched->save();
                $updated++;
            }
            $response = array("Message" => "Records updated: $updated");
        }
        return json_encode($response);

    }

    public function savedPrice(array $data)
    {
        $year_name = $data['year_name'];
        $month_id = $data['month_id'];
        $week = $data['week'];
        $market_id = $data['market_id'];
        $indicator_id = $data['indicator_id'];
        $week_filter = strcasecmp($week, "") == 0 ? "" : "AND m.week = $week ";

        $query = "SELECT * FROM market_data m ";
        $query .= "WHERE m.year_name = $year_name AND m.month_id = $month_id ";
        $query .= "AND m.market_id = $market_id AND m.indicator_id = $indicator_id ";
        $query .= "$week_filter ";
        return DB::select(DB::raw($query));
    }
}
