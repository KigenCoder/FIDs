<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class WeeklyData extends Controller{

    public function __construct() {
        //$this->middleware("dataAnalyst");
    }


    public function weekly_data(){
       return view('analyst.weekly-data');
    }


    public function download_data(){

    }
}
