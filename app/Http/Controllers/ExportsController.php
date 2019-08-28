<?php

	namespace App\Http\Controllers;

	use App\Exports\TestExportView;
	use DB;
	use stdClass;
	use DateTime;
	use Illuminate\Http\Request;
	use App\Exports\DataExportView;
	use Maatwebsite\Excel\Facades\Excel;
	use App\Http\Requests\ExportRequest;

	class ExportsController extends Controller {
		/**
		 * Display a listing of the resource.
		 *
		 * @return \Illuminate\Http\Response
		 */
		public function index() {
			$data = array();
			$data['months'] = $this->getMonths();
			$data['years'] = $this->getYears();
			$data['market_types'] = $this->getMarketTypes();
			return view('exports.index', $data);
		}

		private function getYears() {
			$query = "SELECT distinct(m.year_name) from market_data m ORDER BY m.year_name DESC ";
			$result = DB::SELECT(DB::raw($query));
			return $result;
		}

		private function getMonths() {
			$months = [
				"January", "February", "March", "April", "May", "June",
				"July", "August", "September", "October", "November", "December"
			];
			return $months;
		}

		private function getMarketTypes() {
			//Main Markets
			$mainMarkets = new stdClass();
			$mainMarkets->id = 1;
			$mainMarkets->name = "Main Markets";

			//SLIMS I
			$slimsOneMarkets = new stdClass();
			$slimsOneMarkets->id = 2;
			$slimsOneMarkets->name = "SLIMS I";

			//SLIMS II
			$slimsTwoMarkets = new stdClass();
			$slimsTwoMarkets->id = 3;
			$slimsTwoMarkets->name = "SLIMS II";

			return [$mainMarkets, $slimsOneMarkets, $slimsTwoMarkets];
		}


		public function create() {
			//
		}


		public function store(ExportRequest $request) {
			$input = $request->all();

			//Get markets
			$system_id = NULL;
			if ($request->has('marketType')) {
				switch ($input['marketType']) {
					case 1:
						$system_id = 1;
						break;
					case 2:
					case 3:
						$system_id = 2;
						break;
				}
			}

			$markets = $this->getMarkets($system_id);
			$startMonth = $request->all()['startMonth'];
			$startYear = $request->all()['startYear'];
			$endYear = $request->has('endYear') ? $input['endYear'] : NULL;
			$endMonth = $request->has('endMonth') ? $input['endMonth'] : NULL;

			$rowItems = array();

			foreach ($markets as $market) {
				//Get data for the given month
				$marketData = $this->getMarketData($market, $startMonth, $startYear, $endMonth, $endYear);
				if (count($marketData) > 0) {
					$rowItems[] = $marketData;
				}
			}

			//dd($rowItems);
			$data = array();
			$columnHeaders = array("Region", "District", "Market", "Year", "Month");
			$indicators = $this->getIndicatorList();
			foreach ($indicators as $indicator) {
				array_push($columnHeaders, $indicator->indicator_business_name);
			}

			$data['rowItems'] = $rowItems;
			$data['columnHeaders'] = $columnHeaders;

			//return view('exports.table', $data);
			return Excel::download(new DataExportView($rowItems, $columnHeaders), 'market_data.xlsx');
		}


		function getMarkets($system_id = NULL) {
			$query = "select r.region_name, d.district_name, m.market_name, m.id as market_id ";
			$query .= "FROM markets m ";
			$query .= "JOIN district d on d.id = m.district_id ";
			$query .= "JOIN region r ON r.id = d.region_id ";
			$query .= !is_null($system_id) ? "WHERE system_id = $system_id " : " ";
			$markets = DB::SELECT(DB::raw($query));
			return $markets;
		}

		function getMarketData($market, $startMonth, $startYear, $endMonth = NULL, $endYear = NULL) {
			$marketId = $market->market_id;
			$timePeriods = array();
			//Process the time periods create new variables
			//that will change over time
			$startYearPeriod = $startYear;
			$startMonthPeriod = $startMonth;

			if (is_null($endMonth) || is_null($endYear)) {
				//Means we only have one month data to process
				$timePeriod = new stdClass();
				$timePeriod->month = $startMonth;
				$timePeriod->year = $startYear;
				$timePeriods[] = $timePeriod;
			} else {
				while ($startYearPeriod <= $endYear) {
					//Process the months
					while ($startMonthPeriod <= 12) {
						$timePeriod = new stdClass();
						$timePeriod->month = $startMonthPeriod;
						$timePeriod->year = $startYearPeriod;
						$timePeriods[] = $timePeriod;
						$startMonthPeriod++;
					}
					//First month of following year
					$startMonthPeriod = 1;
					$startYearPeriod++;
				}
			}
			$dataRowItems = array();

			foreach ($timePeriods as $timePeriod) {
				$dataRowItem = new stdClass();
				$month_id = $timePeriod->month;
				$year_name = $timePeriod->year;
				$query = "SELECT i.indicator_business_name, AVG(price) as price ";
				$query .= "FROM market_data m JOIN indicators i on i.id = m.indicator_id ";
				$query .= "WHERE market_id = $marketId ";
				$query .= "AND m.year_name = $year_name AND m.month_id = $month_id ";
				$query .= "GROUP BY i.indicator_business_name ";
				$results = DB::SELECT(DB::raw($query));


				$dateObject = DateTime::createFromFormat('!m', $month_id);
				$monthName = $dateObject->format('F');

				//If there is data
				if (count($results) > 0) {
					/*Order indicators to follow a pre-defined sequence ASC */
					$indicators = $this->getIndicatorList();

					foreach ($indicators as $indicator) {
						$indicator_business_name = $indicator->indicator_business_name;
						$indicator_present = false;
						$cellData = new stdClass();
						foreach ($results as $row) {
							if (strcasecmp($row->indicator_business_name, $indicator_business_name) == 0) {
								$indicator_present = true;
								$cellData->indicator_business_name = $row->indicator_business_name;
								$cellData->price = $row->price;
								break;
							}
						}

						if (!$indicator_present) {
							//If indicator is absent
							$cellData->indicator_business_name = $indicator_business_name;
							$cellData->price = "";
						}

						$rowCellItems[] = $cellData;
					}

					$dataRowItem->region = $market->region_name;
					$dataRowItem->district = $market->district_name;
					$dataRowItem->market = $market->market_name;
					$dataRowItem->marketId = $marketId;
					$dataRowItem->year = $year_name;
					$dataRowItem->month = $monthName;
					$dataRowItem->rowCellItems = $rowCellItems;
					$dataRowItems[] = $dataRowItem;
				}
			}

			return $dataRowItems;
		}

		function getIndicatorList() {
			$query = "SELECT i.indicator_business_name FROM indicators i ORDER BY i.indicator_business_name ";
			$indicators = DB::SELECT(DB::raw($query));
			return $indicators;
		}


		public function show($id) {
			//
		}


		public function edit($id) {
			//
		}


		public function update(Request $request, $id) {
			//
		}


		public function destroy($id) {
			//
		}

	}