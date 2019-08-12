<?php

	namespace App\Http\Controllers;

	use App\Classes\IndicatorDataset;
	use App\Classes\IndicatorList;
	use App\Classes\MarketDataset;
	use App\MarketData;
	use DB;
	use Illuminate\Http\Request;


	class DataUpdates extends Controller {

		public function __construct() {
			//$this->middleware("dataAnalyst");
		}

		public function data_cleaning() {
			$data = array();
			return view("analyst.data-cleaning", $data);
		}

		public function data_entry() {
			$data = array();
			return view("analyst.data-entry", $data);
		}

		public function markets(Request $request) {
			$markets = NULL;
			if ($request->has('market_type_id')) {
				$market_type_id = $request->all()['market_type_id'];
				$system_id = $market_type_id == 1 ? 1 : 2;

				$query = "SELECT m.* FROM markets m ";
				$query .= "WHERE m.system_id = $system_id ";
				$query .= "ORDER BY m.market_name ";
				$markets = DB::select(DB::raw($query));
			}

			return json_encode($markets);

		}

		public function market_data(Request $request) {
			if ($request->has('market_type_id') && $request->has('month_id')
				&& $request->has('year_name') && $request->has('market_id')) {
				$input = $request->all();
				$market_type_id = $input['market_type_id'];
				$month_id = $input['month_id'];
				$year_name = $input['year_name'];
				$market_id = $input['market_id'];
				$application_id_filter = NULL;
				switch ($market_type_id) {
					case 1:
						//Main markets
						$application_id_filter = "(1,3)";
						break;
					case 2:
						//SLIMS 1
						$application_id_filter = "(2,3)";
						break;
					case 3:
						$application_id_filter = "(4)";
						break;
					default:
						$application_id_filter = "(1)";
						break;
				}

				$categoryType = 'category';
				$indicatorType = 'indicator';

				$categoryQuery = "SELECT * FROM indicator_categories";
				$indicatorCategories = DB::select(DB::raw($categoryQuery));
				//Create IndicatorDataSet objects
				$indicatorDataset = array();

				foreach ($indicatorCategories as $category) {
					$categoryId = $category->id;
					$categoryName = $category->category_name;
					$lastMonthAverage = '';

					$indicatorQuery = "SELECT i.id, i.indicator_business_name FROM indicators i ";
					$indicatorQuery .= "WHERE i.indicator_category_id = $categoryId ";
					$indicatorQuery .= "AND i.application_id IN $application_id_filter ";
					$categoryIndicators = DB::select(DB::raw($indicatorQuery));

					$indicatorDataset[] = new IndicatorDataset($categoryId, $categoryName, $categoryType, [], $lastMonthAverage);

					foreach ($categoryIndicators as $indicator) {
						$indicator_id = $indicator->id;
						$indicator_business_name = $indicator->indicator_business_name;
						//get data values
						$dataQuery = "SELECT m.id, m.week, m.price, m.supply_id, s.supply ";
						$dataQuery .= "FROM market_data m ";
						$dataQuery .= "JOIN supply s ON s.id = m.supply_id ";
						$dataQuery .= "WHERE m.month_id =$month_id ";
						$dataQuery .= "AND m.year_name = $year_name AND m.indicator_id = $indicator_id ";
						$dataQuery .= "AND m.market_id = $market_id ";
						$dataSet = DB::select(DB::raw($dataQuery));

						//Get last months average price
						if ($month_id == 1) {
							$lastMonthId = 12;
							$averageYear = $year_name - 1;
							//Get data from last year, December
						} else {
							//Get data from previous month this year
							$lastMonthId = $month_id - 1;
							$averageYear = $year_name;
						}
						$averageQuery = "SELECT m.market_id, AVG(m.price) as lastMonthAverage ";
						$averageQuery .= "FROM market_data m ";
						$averageQuery .= "WHERE m.year_name = $averageYear AND m.month_id = $lastMonthId ";
						$averageQuery .= "AND m.indicator_id = $indicator_id AND m.market_id = $market_id ";
						$averageQuery .= "GROUP BY m.market_id ";
						$averageDataSet = DB::select(DB::raw($averageQuery));

						if (count($averageDataSet) > 0) {
							$lastMonthAverage = round($averageDataSet[0]->lastMonthAverage);
						}

						$indicatorDataset[] = new IndicatorDataset($indicator_id, $indicator_business_name, $indicatorType, $dataSet, $lastMonthAverage);
					}

					//Check if previous category has indicators
					if (count($indicatorDataset) > 0) {
						$lastEntry = $indicatorDataset[count($indicatorDataset) - 1];

						if (strcasecmp($lastEntry->type, $categoryType) == 0) {
							//No indicators for previous category
							array_pop($indicatorDataset);
						}
					}
				}
				return $indicatorDataset;
			}
		}


		public function market_indicators(Request $request) {
			if ($request->has('market_type_id') && $request->has('month_id')
				&& $request->has('year_name') && $request->has('market_id')) {
				$input = $request->all();
				$market_type_id = $input['market_type_id'];
				$application_ids = NULL;
				switch ($market_type_id) {
					case 1:
						//Main markets
						$application_ids = "(1,3)";
						break;
					case 2:
						//SLIMS 1
						$application_ids = "(2, 3)";
						break;
					case 3:
						$application_ids = "(4)";
						break;
					default:
						$application_ids = "(1,3)";
						break;
				}

				$categoryQuery = "SELECT * FROM indicator_categories";
				$indicatorCategories = DB::select(DB::raw($categoryQuery));

				//Create MarketDataset objects
				$indicatorList = array();
				$categoryType = 'category';
				$indicatorType = 'indicator';

				foreach ($indicatorCategories as $category) {
					$categoryId = $category->id;
					$categoryName = $category->category_name;
					$indicatorList[] = new IndicatorList($categoryId, $categoryType, $categoryName);

					$indicatorQuery = "SELECT i.id, i.indicator_business_name FROM indicators i ";
					$indicatorQuery .= "WHERE i.indicator_category_id = $categoryId ";
					$indicatorQuery .= "AND i.application_id IN $application_ids ";
					$categoryIndicators = DB::select(DB::raw($indicatorQuery));

					foreach ($categoryIndicators as $indicator) {
						$indicator_id = $indicator->id;
						$indicator_business_name = $indicator->indicator_business_name;
						$indicatorList[] = new IndicatorList($indicator_id, $indicatorType, $indicator_business_name);
					}

					//Check if previous category has indicators
					if (count($indicatorList) > 0) {
						$lastEntry = $indicatorList[count($indicatorList) - 1];

						if (strcasecmp($lastEntry->type, $categoryType) == 0) {
							//No indicators for previous category, so remove it
							array_pop($indicatorList);
						}
					}
				}
				return $indicatorList;
			}
		}


		public function updateData(Request $request) {
			if ($request->has('price_id') && $request->has('price')) {
				$price_id = $request->all()['price_id'];
				$newPrice = $request->all()['price'];
				$marketData = MarketData::findOrFail($price_id);
				$marketData->price = $newPrice;
				$response = $marketData->save();
				$message = "";
				if ($response) {
					$message = "Success id: $price_id -> Price: $newPrice updated";
				} else {
					$message = "Error updating id: $price_id -> Price: $newPrice";
				}
				return json_encode(["response" => $message]);

			}
		}

	}
