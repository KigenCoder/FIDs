<?php


	namespace App\Classes;


	class TimePeriod {
		public $year;
		public $month_id;

		/**
		 * TimePeriod constructor.
		 * @param $year
		 * @param $month_id
		 */
		public function __construct($year, $month_id) {
			$this->year = $year;
			$this->month_id = $month_id;
		}

		/**
		 * @return mixed
		 */
		public function getYear() {
			return $this->year;
		}

		/**
		 * @param mixed $year
		 * @return TimePeriod
		 */
		public function setYear($year) {
			$this->year = $year;
			return $this;
		}

		/**
		 * @return mixed
		 */
		public function getMonthId() {
			return $this->month_id;
		}

		/**
		 * @param mixed $month_id
		 * @return TimePeriod
		 */
		public function setMonthId($month_id) {
			$this->month_id = $month_id;
			return $this;
		}


	}