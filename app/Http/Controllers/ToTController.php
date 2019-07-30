<?php

	namespace App\Http\Controllers;

	use App\Classes\AnalysisData;
	use App\Classes\MonthlyData;
	use App\Classes\SameMonthData;
	use App\Classes\TimePeriod;
	use Illuminate\Database\Eloquent\Relations\MorphOne;
	use Illuminate\Http\Request;
	use Illuminate\Support\Facades\Log;

	class ToTController extends Controller {

		public function tot() {
			$data = array();
			return view("analyst.tot-analysis", $data);
		}


		public function tot_data(Request $request) {
			//{"first_indicator":"20","second_indicator":"3","start_year":"2010","end_year":"2019","market_ids":"3,4"}
			if ($request->has('first_indicator') && $request->has('second_indicator')
				&& $request->has('start_year') && $request->has('end_year')
				&& $request->has('market_ids')) {

				$input = $request->all();

				$market_ids = $input['market_ids'];
				$first_indicator = $input['first_indicator'];
				$second_indicator = $input['second_indicator'];
				$start_year = $input['start_year'];
				$end_year = $input['end_year'];

				$data = $this->calculateToT($start_year, $end_year, $first_indicator, $second_indicator, $market_ids);
				return json_encode($data);
			}
		}

		function calculateToT($start_year, $end_year, $first_indicator, $second_indicator, $market_ids) {
			$apiController = new APIController();
			$firstDataSet = $apiController->getData($market_ids, $first_indicator, $start_year, $end_year);
			$secondDataSet = $apiController->getData($market_ids, $second_indicator, $start_year, $end_year);
			$data = array();
			for ($i = 0; $i < count($firstDataSet); $i++) {
				$currentYear = $firstDataSet[$i]->year;
				$numerators = $firstDataSet[$i]->marketPrices;
				$denominators = $secondDataSet[$i]->marketPrices;
				$yearData = array();

				for ($k = 0; $k < count($numerators); $k++) {
					try {
						$month_id = $numerators[$k]->month_id;
						$numerator = $numerators[$k]->data_value;
						$denominator = $denominators[$k]->data_value;

						if (!is_numeric($denominator) || !is_numeric($numerator)) {
							$monthlyData = new MonthlyData($month_id, "");
						} else {
							$current_tot = round($numerator / $denominator);
							$monthlyData = new MonthlyData($month_id, $current_tot);
						}
						$yearData[] = $monthlyData;
					} catch (\Exception $exception) {
						$error_message = "Error code: " . $exception->getMessage();
						$error_message .= " Error: " . $exception->getCode();
						Log::error($error_message);
					}
				}

				$totData = new AnalysisData($currentYear, $yearData);

				//return $analysisData->getYear();
				$data[] = $totData;

			}

			return $data;

		}


		public function tot_meta_data(Request $request) {
			$metaData = array();
			if ($request->has('first_indicator') && $request->has('second_indicator')
				&& $request->has('start_year') && $request->has('end_year')
				&& $request->has('market_ids')) {
				$input = $request->all();

				$market_ids = $input['market_ids'];
				$first_indicator = $input['first_indicator'];
				$second_indicator = $input['second_indicator'];
				//$start_year = $input['start_year'];
				$end_year = $input['end_year'];

				$tot_end_year = $end_year - 1;
				$tot_start_year = $end_year - 5;

				$metaData['averages'] = $this->ltm($tot_start_year, $tot_end_year, $first_indicator, $second_indicator, $market_ids);
				$metaData['preceding_months'] = $this->precedingMonth($end_year, $first_indicator, $second_indicator, $market_ids);
				$metaData['same_months'] = $this->sameMonth($end_year, $first_indicator, $second_indicator, $market_ids);
				$metaData["percentage_of_average"] = $this->percentageOfLTM($end_year, $first_indicator, $second_indicator, $market_ids);
				$metaData["twelve_months_min_max"] = $this->oneYearMinMax($end_year, $first_indicator, $second_indicator, $market_ids);
				$metaData["six_months_min_max"] = $this->sixMonthsMinMax($end_year, $first_indicator, $second_indicator, $market_ids);
				$metaData["six_months_diff"] = $this->sixMonthsDiff($end_year, $first_indicator, $second_indicator, $market_ids);

				return $metaData;
			}


		}

		//Long Term Mean
		function ltm($start_year, $end_year, $first_indicator, $second_indicator, $market_ids) {
			$data = array();
			$sameMonthData = array();
			$tot_data = $this->calculateToT($start_year, $end_year, $first_indicator, $second_indicator, $market_ids);

			for ($i = 0; $i < count($tot_data); $i++) {
				//$year = $tot_data[$i]->year;
				$marketPrices = $tot_data[$i]->marketPrices;
				//return $tot_data[$i];

				for ($k = 0; $k < count($marketPrices); $k++) {
					$monthId = $marketPrices[$k]->month_id;
					$monthValue = $marketPrices[$k]->data_value;

					if (isset($sameMonthData[$k])) {
						$currentMonthValues = $sameMonthData[$k]->monthValues;
						array_push($currentMonthValues, $monthValue);
						$sameMonthData[$k] = new SameMonthData($monthId, $currentMonthValues);
					} else {
						//Months data does not exist, create it
						$sameMonthData[$k] = new SameMonthData($monthId, [$monthValue]);
					}
				}

			}
			//Calculate average
			foreach ($sameMonthData as $monthDataItem) {
				$monthId = $monthDataItem->monthId;
				$monthValues = $monthDataItem->monthValues;
				$average = round(floor(array_sum($monthValues) / count($monthValues)));

				$data[] = new MonthlyData($monthId, $average);

			}

			return $data;

		}

		//Preceding month comparison
		function precedingMonth($currentYear, $first_indicator, $second_indicator, $market_ids) {
			//Get ToT for current Year and past year
			$lastYear = $currentYear - 1;
			$tot_data = $this->calculateToT($lastYear, $currentYear, $first_indicator, $second_indicator, $market_ids);

			//Get data for the last month of the previous year
			$lastYearDecData = null;
			$currentYearData = array();
			$comparisons = array();

			foreach ($tot_data as $data_item) {
				$year = $data_item->year;
				$market_prices = $data_item->marketPrices;

				for ($i = 0; $i < count($market_prices); $i++) {
					if ($year == $lastYear && $market_prices[$i]->month_id == 12) {
						$lastYearDecData = $market_prices[$i];
					}

					if ($year == $currentYear && is_numeric($market_prices[$i]->data_value)) {
						$currentYearData[] = $market_prices[$i];
					}
				}
			}

			for ($i = 0; $i < count($currentYearData); $i++) {
				$month_id = $currentYearData[$i]->month_id;

				if ($month_id == 1) {
					//compare with last year, last month
					$compared = (($currentYearData[$i]->data_value / $lastYearDecData->data_value) * 100);
					$comparisons[] = new MonthlyData($month_id, round($compared));
				} else {
					$compared = (($currentYearData[$i]->data_value / $currentYearData[$i - 1]->data_value) * 100);
					$comparisons[] = new MonthlyData($month_id, round($compared));

				}
			}
			$latestMonthId = count($comparisons) + 1;

			for ($i = $latestMonthId; $i <= 12; $i++) {
				$comparisons[] = new MonthlyData($i, "");
			}
			return $comparisons;

		}

		//Same month comparison
		function sameMonth($currentYear, $first_indicator, $second_indicator, $market_ids) {
			$comparisons = array();
			//Get ToT for current Year and past year
			$lastYear = $currentYear - 1;
			$tot_data = $this->calculateToT($lastYear, $currentYear, $first_indicator, $second_indicator, $market_ids);

			$lastYearMonthData = array();
			$thisYearMonthData = array();

			foreach ($tot_data as $yearData) {
				//Last year data
				if ($yearData->year == $lastYear) {
					$lastYearMonthData = $yearData->marketPrices;
				}

				//This Year data
				if ($yearData->year == $currentYear) {
					$thisYearMonthData = $yearData->marketPrices;
				}
			}

			for ($i = 0; $i < count($thisYearMonthData); $i++) {
				$month_id = $thisYearMonthData[$i]->month_id;
				if (is_numeric($thisYearMonthData[$i]->data_value) && is_numeric($lastYearMonthData[$i]->data_value)) {

					$compared = round(($thisYearMonthData[$i]->data_value / $lastYearMonthData[$i]->data_value) * 100);

					$comparisons[] = new MonthlyData($month_id, $compared);
				} else {
					$comparisons[] = new MonthlyData($month_id, "");
				}
			}

			return $comparisons;
		}

		//Comparison with LTM or Average
		function percentageOfLTM($currentYear, $first_indicator, $second_indicator, $market_ids) {
			$comparisons = array();
			$tot_data = $this->calculateToT($currentYear, $currentYear, $first_indicator, $second_indicator, $market_ids);
			$ltm = $this->ltm($currentYear - 5, $currentYear - 1, $first_indicator, $second_indicator, $market_ids);

			foreach ($tot_data as $tot_data_item) {

				$year = $tot_data_item->year;
				$marketPrices = $tot_data_item->marketPrices;

				if ($year == $currentYear) {
					for ($i = 0; $i < count($marketPrices); $i++) {
						$month_id = $marketPrices[$i]->month_id;
						$marketPrice = $marketPrices[$i]->data_value;
						$ltm_value = $ltm[$i]->data_value;

						if (is_numeric($marketPrice) && is_numeric($ltm_value)) {
							$compared = round(($marketPrice / $ltm_value) * 100);
							$comparisons[] = new MonthlyData($month_id, $compared);

						} else {
							$comparisons[] = new MonthlyData($month_id, "");
						}

					}
				}
			}

			return $comparisons;
		}

		//Min Max for the last one year
		function oneYearMinMax($currentYear, $first_indicator, $second_indicator, $market_ids) {
			$lastYear = $currentYear - 1;
			$tot_data = $this->calculateToT($lastYear, $currentYear, $first_indicator, $second_indicator, $market_ids);

			$time_periods = array();
			for ($month_id = 1; $month_id <= 12; $month_id++) {
				$time_periods[] = new TimePeriod($currentYear, $month_id);
			}

			$periodic_data = array();

			foreach ($time_periods as $time_period) {
				$currentYear = $time_period->year;
				$past_twelve_months = array();
				//Create arrays with past month_ids (Inclusive)
				if ($time_period->month_id == 12) {
					//All periods fall in the current year
					for ($i = 1; $i <= 12; $i++) {
						$past_twelve_months[] = new TimePeriod($currentYear, $i);

					}

					$time_period_key = $time_period->year . "_" . $time_period->month_id;
					$periodic_data[] = array($time_period_key => $past_twelve_months);


				} else {
					//some month_ids fall under previous year

					$monthNumber = $time_period->month_id;  //Current year past months
					while ($monthNumber != 0) {
						$past_twelve_months[] = new TimePeriod($currentYear, $monthNumber);
						$monthNumber--;
					}

					//Past year months
					$firstMonth = $time_period->month_id + 1;
					$lastMonth = 12;
					while ($lastMonth >= $firstMonth) {
						$past_twelve_months[] = new TimePeriod($currentYear - 1, $lastMonth);
						$lastMonth--;
					}

					$time_period_key = $time_period->year . "_" . $time_period->month_id;

					$periodic_data[] = array($time_period_key => $past_twelve_months);

				}
			}

			$data_values = array();
			foreach ($periodic_data as $period) {

				foreach ($period as $period_key => $time_periods) {
					$period_values = array();
					foreach ($time_periods as $time_period) {
						$time_period_year = $time_period->year;
						$time_period_month_id = $time_period->month_id;

						//loop through ToT values
						foreach ($tot_data as $tot_data_item) {
							$tot_year = $tot_data_item->year;
							if ($tot_year == $time_period_year) {
								$marketPrices = $tot_data_item->marketPrices;
								foreach ($marketPrices as $marketPrice) {
									if ($time_period_month_id == $marketPrice->month_id) {
										$period_values[] = $marketPrice->data_value;
									}
								}
							}

						}
					}
					$data_values[$period_key] = $period_values;
				}

				$data = array();
				foreach ($data_values as $time_key => $data_value) {
					$split_time_key = explode("_", $time_key);
					$month_id = $split_time_key[1];
					$minValues = $data_value;
					$maxValues = $data_value;
					sort($minValues);
					rsort($maxValues);
					$minValue = round($minValues[0]) > 0 ? round($minValues[0]) : "";
					$maxValue = round($maxValues[0]) > 0 ? round($maxValues[0]) : "";
					$max = new MonthlyData($month_id, $maxValue);
					$min = new MonthlyData($month_id, $minValue);
					$maxMin = array("max" => $max, "min" => $min);
					$data[] = $maxMin;

				}

			}

			return $data;


		}

		function sixMonthsMinMax($currentYear, $first_indicator, $second_indicator, $market_ids) {
			$lastYear = $currentYear - 1;
			$tot_data = $this->calculateToT($lastYear, $currentYear, $first_indicator, $second_indicator, $market_ids);

			//Six month periods
			$timePeriods = array();

			for ($month_id = 1; $month_id <= 12; $month_id++) {
				$temp = array();
				$time_period = $currentYear . "_" . $month_id;
				if ($month_id < 6) {

					//This year time periods
					$thisYearMonthId = $month_id;
					while ($thisYearMonthId != 0) {
						$temp[] = new TimePeriod($currentYear, $thisYearMonthId);
						$thisYearMonthId--;
					}

					//last year time periods
					$lastYearMonthId = 7 + $month_id;
					$yearEndMonthId = 12;

					while ($yearEndMonthId >= $lastYearMonthId) {

						$temp[] = new TimePeriod($currentYear - 1, $yearEndMonthId);

						$yearEndMonthId--;
					}

					$timePeriods[$time_period] = $temp;
				} else {
					$monthMaxId = $month_id;
					$monthMinId = $month_id - 6;
					while ($monthMinId < $monthMaxId) {
						$temp[] = new TimePeriod($currentYear, $monthMinId);
						$monthMinId++;
					}
					$timePeriods[$time_period] = $temp;

				}

			}
			$data_values = array();

			foreach ($timePeriods as $time_period => $sixMonthSet) {

				$temp = array();
				foreach ($sixMonthSet as $monthYear) {
					$current_month_id = $monthYear->month_id;
					$current_year = $monthYear->year;

					foreach ($tot_data as $tot_data_item) {
						if ($tot_data_item->year == $current_year) {
							$marketPrices = $tot_data_item->marketPrices;

							foreach ($marketPrices as $marketPrice) {
								if ($marketPrice->month_id == $current_month_id) {
									if (is_numeric($marketPrice->data_value)) {
										$temp[] = $marketPrice->data_value;
									}
								}
							}
						}
					}
				}
				if (count($temp) > 0) {
					$data_values[$time_period] = $temp;
				}
			}


			$comparisons = array();
			foreach ($data_values as $time_key => $data_value) {
				$split_time_key = explode("_", $time_key);
				$month_id = $split_time_key[1];
				$minValues = $data_value;
				$maxValues = $data_value;
				sort($minValues);
				rsort($maxValues);
				$minValue = round($minValues[0]) > 0 ? round($minValues[0]) : "";
				$maxValue = round($maxValues[0]) > 0 ? round($maxValues[0]) : "";
				$max = new MonthlyData($month_id, $maxValue);
				$min = new MonthlyData($month_id, $minValue);
				$maxMin = array("max" => $max, "min" => $min);
				$comparisons[] = $maxMin;

			}


			$latestMonthId = count($comparisons) + 1;
			for ($i = $latestMonthId; $i <= 12; $i++) {
				$max = new MonthlyData($latestMonthId, "");
				$min = new MonthlyData($latestMonthId, "");
				$maxMin = array("max" => $max, "min" => $min);
				$comparisons[] = $maxMin;
			}
			return $comparisons;
		}

		function sixMonthsDiff($currentYear, $first_indicator, $second_indicator, $market_ids) {
			$comparisons = array();
			$lastYear = $currentYear - 1;
			$tot_data = $this->calculateToT($lastYear, $currentYear, $first_indicator, $second_indicator, $market_ids);
			$thisYearData = null;
			$lastYearData = null;

			foreach ($tot_data as $tot_data_item) {

				if ($tot_data_item->year == $currentYear) {
					$thisYearData = $tot_data_item;
				}

				if ($tot_data_item->year == ($currentYear - 1)) {
					$lastYearData = $tot_data_item;
				}
			}

			$thisYearMarketPrices = $thisYearData->marketPrices;
			$lastYearMarketPrices = $lastYearData->marketPrices;

			for ($i = 0; $i < count($thisYearMarketPrices); $i++) {
				$marketPrice = $thisYearMarketPrices[$i];
				$numerator = $marketPrice->data_value;
				$denominator = '';

				if ($marketPrice->month_id >= 6) {

					$denominator = $thisYearMarketPrices[$i - 5]->data_value;

				} else {
					//data value to compare falls in the previous year
					$denominatorMonthId = $marketPrice->month_id + 7;
					foreach ($lastYearMarketPrices as $lastYearPrice) {
						if ($lastYearPrice->month_id == $denominatorMonthId) {
							$denominator = $lastYearPrice->data_value;

						}
					}
				}


				if ($numerator > 0 && $denominator > 0) {

					$ratio = round(($numerator / $denominator) * 100);


					$comparisons [] = new MonthlyData($marketPrice->month_id, $ratio);

				}

			}

			$latestMonthId = count($comparisons) + 1;
			for ($i = $latestMonthId; $i <= 12; $i++) {
				$comparisons[] = new MonthlyData($i, "");
			}
			return $comparisons;

		}


	}
