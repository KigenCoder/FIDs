<?php

	namespace App\Exports;

	use Illuminate\Contracts\View\View;
	use Maatwebsite\Excel\Concerns\FromView;
	use Maatwebsite\Excel\Concerns\WithHeadings;

	class DataExportView implements FromView, WithHeadings{
		private $rowItems;
		private $columnHeaders;

		/**
		 * DataExportView constructor.
		 * @param $rowItems
		 * @param $columnHeaders
		 */
		public function __construct($rowItems, $columnHeaders) {
			$this->rowItems = $rowItems;
			$this->columnHeaders = $columnHeaders;
		}


		/** @return View **/
		public function view(): View {
			return view('exports.table', [
				'rowItems' => $this->rowItems,
				'columnHeaders'=>$this->columnHeaders
			]);
		}
		
		/* @return array */
		public function headings(): array {
			return  $this->columnHeaders;
		}

	}
