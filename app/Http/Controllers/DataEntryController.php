<?php

namespace App\Http\Controllers;

use App\User;

class DataEntryController extends Controller{

    public function __construct() {
        $this->middleware("dataAnalyst");
    }

    public function data_entry(){
        $data = array();
        return view("analyst.data-entry", $data);
    }
}
