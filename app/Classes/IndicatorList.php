<?php


	namespace App\Classes;


	class IndicatorList {
		public $id;
		public $type;
		public $name;

		/**
		 * IndicatorList constructor.
		 * @param $id
		 * @param $type
		 * @param $name
		 */
		public function __construct($id, $type, $name) {
			$this->id = $id;
			$this->type = $type;
			$this->name = $name;
		}

		/**
		 * @return mixed
		 */
		public function getId() {
			return $this->id;
		}

		/**
		 * @param mixed $id
		 * @return IndicatorList
		 */
		public function setId($id) {
			$this->id = $id;
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
		 * @return IndicatorList
		 */
		public function setType($type) {
			$this->type = $type;
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
		 * @return IndicatorList
		 */
		public function setName($name) {
			$this->name = $name;
			return $this;
		}




	}