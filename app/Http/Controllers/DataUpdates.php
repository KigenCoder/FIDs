<?php

namespace App\Http\Controllers;

class DataUpdates extends Controller
{

    public function __construct()
    {
        $this->middleware("dataAnalyst");
    }

    public function data_cleaning()
    {
        $data = array();
        return view("analyst.data-cleaning", $data);
    }

    public function data_entry()
    {
        $data = array();
        return view("analyst.data-entry", $data);
    }


}
