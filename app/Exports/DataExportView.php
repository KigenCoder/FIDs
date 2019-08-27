<?php

	namespace App\Exports;

	use Illuminate\Contracts\View\View;
	use Maatwebsite\Excel\Concerns\FromView;

	class DataExportView implements FromView {
		private $rowItems;


		/** @return View **/
		public function view(): View {
			return view('exports.table', [
				'rowItems' => $this->rowItems
			]);
		}

		/** DataExportView constructor. @param $rowItems **/
		public function __construct($rowItems) {
			$this->rowItems = $rowItems;
		}

		/**
		 * @return mixed
		 */
		public function getRowItems() {
			return $this->rowItems;
		}

		/**
		 * @param mixed $rowItems
		 * @return DataExportView
		 */
		public function setRowItems($rowItems) {
			$this->rowItems = $rowItems;
			return $this;
		}



	}
