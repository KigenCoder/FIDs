<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DataCleaningController extends Controller{

    public function __construct() {
        $this->middleware("dataAnalyst");
    }

    public function data_entry(){
        $data = array();
        return view("analyst.data-cleaning", $data);
    }
}
