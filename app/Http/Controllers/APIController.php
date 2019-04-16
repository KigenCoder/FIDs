<?php

namespace App\Http\Controllers;
use App\Market;
use DB;
use App\Indicator;
use App\Region;
use App\Zone;


class APIController extends Controller{
   public function indicators(){
       return json_encode(Indicator::all());
   }

   public function zones(){
       return json_encode(Zone::orderBy('ipc_zone_name')->get());
   }

   public function regions(){
       return json_encode(Region::orderBy('region_name')->get());
   }

   public function years(){
       $query = "select distinct(year_name) from market_data ";
       $query .= "ORDER BY year_name ASC";
       $year_list = DB::select(DB::raw($query));
       return json_encode($year_list);
   }

   public function markets(){
       return json_encode(Market::orderBy('market_name')->get());
   }





}
