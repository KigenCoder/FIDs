<?php

	namespace App\Http\Controllers;


	class ToTController extends Controller {

        public function __construct() {
            //$this->middleware("dataAnalyst");
        }

		public function tot() {
			$data = array();
			return view("analyst.tot-analysis", $data);
		}





	}
