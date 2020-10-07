<?php

namespace App\Http\Controllers;


class MarketAnalysis extends Controller{

    public function __construct() {
        //$this->middleware("dataAnalyst");
    }

    public function monthly_analysis(){
        $data = array();
        return view("analyst.monthly-analysis", $data);
    }

}
