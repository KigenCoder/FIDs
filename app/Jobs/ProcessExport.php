<?php

	namespace App\Jobs;
	use Box\Spout\Writer\Common\Creator\WriterEntityFactory;
	use Illuminate\Bus\Queueable;
	use Illuminate\Queue\SerializesModels;
	use Illuminate\Queue\InteractsWithQueue;
	use Illuminate\Contracts\Queue\ShouldQueue;
	use Illuminate\Foundation\Bus\Dispatchable;
	use Maatwebsite\Excel\Facades\Excel;
	use App\Exports\MarketDataExport;


	class ProcessExport implements ShouldQueue {
		use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

		protected $columnHeaders;
		protected $rowItems;


		/**
		 * Create a new job instance.
		 *
		 * @param array $columnHeaders
		 * @param array $rowItems
		 */
		public function __construct(array $columnHeaders, array $rowItems) {
			$this->columnHeaders = $columnHeaders;
			$this->rowItems = $rowItems;
		}

		/**
		 * Execute the job.
		 *
		 * @return void
		 */
		public function handle() {
			/*
			$writer = WriterEntityFactory::createCSVWriter();
			$timestamp = time();
			$fileName = "market-data-" . $timestamp . ".csv";
			$filePath = public_path("downloads/" . $fileName);
			$writer->openToFile($filePath);
			//$writer->openToBrowser('market_data.csv');
			//Column headers
			$headerCells = array();
			foreach ($this->columnHeaders as $columnHeader) {
				$headerCells[] = WriterEntityFactory::createCell($columnHeader);
			}
			$headerRow = WriterEntityFactory::createRow($headerCells);
			$writer->addRow($headerRow);

			//Row items
			for ($i = 0; $i < count($this->rowItems); $i++) {
				//Rows
				foreach ($this->rowItems[$i] as $rowItem) {
					$rowCells = array();
					$rowCells[] = WriterEntityFactory::createCell($rowItem->region);
					$rowCells[] = WriterEntityFactory::createCell($rowItem->district);
					$rowCells[] = WriterEntityFactory::createCell($rowItem->market);
					$rowCells[] = WriterEntityFactory::createCell($rowItem->marketType);
					$rowCells[] = WriterEntityFactory::createCell($rowItem->year);
					$rowCells[] = WriterEntityFactory::createCell($rowItem->month);
					foreach ($rowItem->rowCellItems as $rowCellItem) {
						$cellText = WriterEntityFactory::createCell($rowCellItem->price > 0 ? number_format(round($rowCellItem->price)) : "");
						$rowCells[] = $cellText;
					}

					//dd($rowCells);

					$row = WriterEntityFactory::createRow($rowCells);
					$writer->addRow($row);
				}
			}

			$writer->close();
			*/
			//dd($this->columnHeaders);
		 Excel::download(new MarketDataExport ($this->columnHeaders, $this->rowItems), 'market_data.xlsx');
		}
	}
