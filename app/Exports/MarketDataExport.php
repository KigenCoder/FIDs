<?php

	namespace App\Exports;

	use Illuminate\Contracts\Queue\ShouldQueue;
	use Illuminate\Contracts\View\View;
	use Maatwebsite\Excel\Concerns\Exportable;
	use Maatwebsite\Excel\Concerns\FromView;


	class MarketDataExport implements FromView, ShouldQueue {
		use Exportable;

		private $rowItems;
		private $columnHeaders;


		/**
		 * DataExportView constructor.
		 * @param $rowItems
		 * @param $columnHeaders
		 */
		public function __construct($columnHeaders, $rowItems) {
			$this->columnHeaders = $columnHeaders;
			$this->rowItems = $rowItems;
		}


		/** @return View **/
		public function view(): View {
			return view('exports.table', [
				'rowItems' => $this->rowItems,
				'columnHeaders'=>$this->columnHeaders
			]);
		}

		/* @return array */
		/*
		public function headings(): array {
			return  $this->columnHeaders;
		}
		*/

	}
