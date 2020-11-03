<?php

namespace App\Http\Controllers;

class WeeklyData extends Controller
{

    public function __construct()
    {
        $this->middleware("dataAnalyst");
    }

    public function data_entry(){
        $data = array();
        return view("analyst.weekly-data-entry", $data);
    }
    public function weekly_data(){
        return view('analyst.weekly-data');
    }




}
