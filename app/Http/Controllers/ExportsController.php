<?php

	namespace App\Http\Controllers;

	use App\Exports\MarketDataExport;
	use DB;

	use Illuminate\Support\Facades\Session;
	use stdClass;
	use DateTime;
	use Illuminate\Http\Request;
	use Maatwebsite\Excel\Facades\Excel;
	use App\Http\Requests\ExportRequest;
	use Symfony\Component\Process\Process;


	class ExportsController extends Controller {


        public function __construct() {
            $this->middleware("dataAnalyst");
        }

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
			$marketTypeId = NULL;
			if ($request->has('marketType')) {
				$marketTypeId = $input['marketType'];
				switch ($marketTypeId) {
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
				$marketData = $this->getMarketData($market, $startMonth, $startYear, $endMonth, $endYear, $marketTypeId);
				if (count($marketData) > 0) {
					$rowItems[] = $marketData;
				}
			}

			$columnHeaders = array("Region", "District", "Market", "Market Type", "Year", "Month");
			$indicators = $this->getIndicatorList($marketTypeId);
			foreach ($indicators as $indicator) {
				array_push($columnHeaders, $indicator->indicator_business_name);
			}

			$process = new Process('Exporting market data....!');
			$process->start();
			//Session::flash('message', 'Hold on tight. Your file is being processed');

			Session::flush('This is going down bruh....!!!');

			//dd($rowItems);
			//	$data = array();
			//$data['rowItems'] = $rowItems;
			//$data['columnHeaders'] = $columnHeaders;
			//dd($data);
			//return view('exports.table', $data);
			return Excel::download(new MarketDataExport($columnHeaders, $rowItems), 'market_data.xlsx');

		}


		function getMarkets($system_id = NULL) {
			$query = "select r.region_name, d.district_name, m.market_name, m.id as market_id, m.system_id ";
			$query .= "FROM markets m ";
			$query .= "JOIN district d on d.id = m.district_id ";
			$query .= "JOIN region r ON r.id = d.region_id ";
			$query .= !is_null($system_id) ? "WHERE m.system_id = $system_id " : " ";
			$markets = DB::SELECT(DB::raw($query));
			return $markets;
		}

		function getMarketData($market, $startMonth, $startYear, $endMonth = NULL, $endYear = NULL, $marketTypeId = NULL) {
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
					$indicators = $this->getIndicatorList($marketTypeId);

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
					$dataRowItem->marketType = $market->system_id == 1 ? "Main market" : "SLIM";
					$dataRowItem->marketId = $marketId;
					$dataRowItem->year = $year_name;
					$dataRowItem->month = $monthName;
					$dataRowItem->rowCellItems = $rowCellItems;
					$dataRowItems[] = $dataRowItem;
				}
			}

			return $dataRowItems;
		}

		function getIndicatorList($marketTypeId = NULL) {
			$whereClause = "";
			switch ($marketTypeId) {
				case 1:
					//Main Markets
					$whereClause = "WHERE i.application_id IN (1,3) ";
					break;
				case 2:
					//SLIM I
					$whereClause = "WHERE i.application_id IN (2,3) ";
					break;
				case 3:
					//SLIM II
					$whereClause = "WHERE i.application_id IN (4) ";
					break;
			}
			$query = "SELECT i.indicator_business_name FROM indicators i ";
			$query .= $whereClause;
			$query .= "ORDER BY i.indicator_business_name ";
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
