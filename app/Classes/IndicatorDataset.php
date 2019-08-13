<?php


	namespace App\Classes;


	class IndicatorDataset {
		public $id;
		public $name;
		public $type;
		public $dataSet;
		public $lastMonthAverage;

		/**
		 * IndicatorDataset constructor.
		 * @param $id
		 * @param $name
		 * @param $type
		 * @param $dataSet
		 * @param $lastMonthAverage
		 */
		public function __construct($id, $name, $type, array $dataSet, $lastMonthAverage) {
			$this->id = $id;
			$this->name = $name;
			$this->type = $type;
			$this->dataSet = $dataSet;
			$this->lastMonthAverage = $lastMonthAverage;
		}

		/**
		 * @return mixed
		 */
		public function getId() {
			return $this->id;
		}

		/**
		 * @param mixed $id
		 * @return IndicatorDataset
		 */
		public function setId($id) {
			$this->id = $id;
			return $this;
		}

		/**
		 * @return mixed
		 */
		public function getName() {
			return $this->name;
		}

		/**
		 * @param mixed $name
		 * @return IndicatorDataset
		 */
		public function setName($name) {
			$this->name = $name;
			return $this;
		}

		/**
		 * @return mixed
		 */
		public function getType() {
			return $this->type;
		}

		/**
		 * @param mixed $type
		 * @return IndicatorDataset
		 */
		public function setType($type) {
			$this->type = $type;
			return $this;
		}

		/**
		 * @return array
		 */
		public function getDataSet(): array {
			return $this->dataSet;
		}

		/**
		 * @param array $dataSet
		 * @return IndicatorDataset
		 */
		public function setDataSet(array $dataSet): IndicatorDataset {
			$this->dataSet = $dataSet;
			return $this;
		}

		/**
		 * @return mixed
		 */
		public function getLastMonthAverage() {
			return $this->lastMonthAverage;
		}

		/**
		 * @param mixed $lastMonthAverage
		 * @return IndicatorDataset
		 */
		public function setLastMonthAverage($lastMonthAverage) {
			$this->lastMonthAverage = $lastMonthAverage;
			return $this;
		}




	}