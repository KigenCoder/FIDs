<?php

namespace App\Http\Controllers;

use App\Classes\AnalysisData;
use App\Classes\MonthlyData;
use App\Market;
use App\MarketData;
use DB;
use App\Region;
use App\Zone;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;


class APIController extends Controller
{

  public function zones()
  {
    return json_encode(Zone::orderBy('ipc_zone_name')->get());
  }

  public function regions(Request $request)
  {
    $zoneRegions = NULL;

    if ($request->has('zone_id')) {
      $zone_id = $request->all()['zone_id'];
      $zoneRegions = Region::where('ipc_zone_id', $zone_id)->get();
    }

    return json_encode($zoneRegions);
  }

  public function years()
  {
    $query = "select distinct(year_name) from market_data ";
    $query .= "ORDER BY year_name DESC";
    $year_list = DB::select(DB::raw($query));
    return json_encode($year_list);
  }

  public function markets(Request $request)
  {
    $markets = NULL;
    if ($request->has('region_id')) {
      $region_id = $request->all()['region_id'];
      $query = "SELECT m.* FROM markets m ";
      $query .= "JOIN district d ON d.id = m.district_id ";
      $query .= "WHERE d.region_id = $region_id";
      $markets = DB::select(DB::raw($query));
    }

    return json_encode($markets);
  }

  public function indicators(Request $request)
  {
    $market_indicators = NULL;
    $query = "SELECT * FROM indicators i ";
    $where_clause = "";

    if ($request->has('market_id')) {
      $market_id = $request->all()['market_id'];
      $market = Market::where('id', $market_id)->first();
      $system_id = $market->system_id;


      //SLIMS = 2 Main Markets = 1
      switch ($system_id) {
        case 1:
          //Main markets
          $where_clause = "WHERE i.application_id IN (1,3) ";
          break;
        case 2:
          //SLIMS
          $where_clause = "WHERE i.application_id IN (2,4) ";
          break;
      }
    }

    $orderBy = $where_clause . "ORDER by indicator_business_name ASC";
    $query .= $orderBy;
    $market_indicators = DB::select(DB::raw($query));

    return json_encode($market_indicators);
  }


  public function analysis_data(Request $request)
  {
    if ($request->has('market_id') && $request->has('indicator_id')
      && $request->has('start_year') && $request->has('end_year')) {
      $input = $request->all();
      $market_id = $input['market_id'];
      $indicator_id = $input['indicator_id'];
      $start_year = $input['start_year'];
      $end_year = $input['end_year'];

      $diff = $end_year - $start_year;
      $index = 0;
      $data = array();

      while ($index <= $diff) {
        $year = $start_year + $index;
        $query = "SELECT ROUND(AVG(price),0) as price, month_id ";
        $query .= "FROM market_data m ";
        $query .= "WHERE m.year_name = $year ";
        $query .= "AND m.market_id = $market_id ";
        $query .= "AND m.indicator_id = $indicator_id ";
        $query .= "GROUP by m.month_id ";
        $temp = DB::select(DB::raw($query));

        $month_ids = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12];
        $distinct_months_query = "SELECT DISTINCT(month_id) ";
        $distinct_months_query .= "FROM market_data m ";
        $distinct_months_query .= "WHERE m.year_name = $year. ";
        $distinct_months_query .= "AND m.indicator_id = $indicator_id ";
        $distinct_months_query .= "AND m.market_id = $market_id ";
        $distinct_months = DB::select(DB::raw($distinct_months_query));
        $distinct_month_ids = array();

        for ($i = 0; $i < count($distinct_months); $i++) {
          $distinct_month_ids[] = $distinct_months[$i]->month_id;
        }

        $yearData = array();
        $missing_months = array_diff($month_ids, $distinct_month_ids);


        /*For purposes of Front end rendering on vue.js/Javascript
        Months without data will be populated with default MonthlyData
        instances

        */
        for ($i = 0; $i < count($month_ids); $i++) {
          $currentMonthID = $month_ids[$i];
          if (in_array($currentMonthID, $missing_months)) {
            //Create empty object and place in array
            $monthlyData = new MonthlyData("$currentMonthID", " ");
            $yearData[] = $monthlyData;
          } else {
            //Get data
            for ($k = 0; $k < count($temp); $k++) {
              if ($temp[$k]->month_id == $currentMonthID)
                $yearData[] = $temp[$k];
            }
          }
        }

        $analysisData = new AnalysisData($year, $yearData);

        //return $analysisData->getYear();
        $data[] = $analysisData;
        $index++;
      }
      return json_encode($data);
    }

  }

  function marketMetaData(Request $request)
  {
    $metaData = array();
    if ($request->has('year') && $request->has('indicator_id')
      && $request->has('market_id')) {
      $input = $request->all();
      $thisYear = $input['year'];
      $indicator_id = $input['indicator_id'];
      $market_id = $input['market_id'];
      $metaData['averages'] = $this->ltm($thisYear, $indicator_id, $market_id);
      $metaData['preceding_months'] = $this->precedingMonths($thisYear, $indicator_id, $market_id);
      $metaData["same_months"] = $this->sameMonthComparison($thisYear, $indicator_id, $market_id);
      $metaData["percentage_of_average"] = $this->percentageOfLTM($thisYear, $indicator_id, $market_id);
      $metaData["twelve_months_min_max"] = $this->twelveMonthMinMax($thisYear, $indicator_id, $market_id);
      $metaData['six_months_min_max'] = $this->sixMonthMaxMin($thisYear, $indicator_id, $market_id);
      $metaData['six_months_diff'] = $this->sixMonthsDiff($thisYear, $indicator_id, $market_id);
    }
    return $metaData;
  }


  //Long Term Mean
  function ltm($currentYear, $indicator_id, $market_id)
  {
    $numberOfYears = 5;
    $averages = array();

    for ($month_id = 1; $month_id <= 12; $month_id++) {
      $prices = array();
      for ($i = 1; $i <= $numberOfYears; $i++) {
        $year = $currentYear - $i;
        $query = "SELECT AVG(m.price) as average ";
        $query .= "FROM market_data m ";
        $query .= "WHERE m.indicator_id = $indicator_id ";
        $query .= "AND m.month_id = $month_id ";
        $query .= "AND m.market_id = $market_id ";
        $query .= "AND m.year_name = $year ";
        $priceData = DB::select(DB::raw($query));

        $avg_price = $priceData[0]->average;
        $prices[] = $avg_price;
      }

      if (count($prices)) {
        $ltm = array_sum($prices) / count($prices);
        $averages[] = new MonthlyData($month_id, $ltm);
        //array_push($averages, array("month_id" => $month_id, "ltm" => $ltm));
      }
    }

    return $averages;
  }

  //Preceding month %
  function precedingMonths($year, $indicator_id, $market_id)
  {
    $this_year_months = $this->distinctMonthIds($year, $indicator_id, $market_id);
    $monthlyData = [];
    $comparisons = [];

    foreach ($this_year_months as $month_id) {
      $currentMonthId = $month_id->month_id;
      $query = "SELECT AVG(m.price) as price FROM market_data m ";
      $query .= "WHERE m.market_id = $market_id  ";
      $query .= "AND m.indicator_id = $indicator_id ";
      if ($currentMonthId == 1) {
        //Fetch last year, last month data
        $last_year = $year - 1;
        $dec_id = 12;
        $last_years_query = $query;
        $last_years_query .= "AND m.month_id = 12 ";
        $last_years_query .= "AND m.year_name = $last_year ";
        $last_year_result = DB::select(DB::raw($last_years_query));
        array_push($monthlyData, array("month_id" => "$dec_id", "price" => $last_year_result[0]->price));
      }
      //This years data
      $query .= "AND m.month_id = $currentMonthId ";
      $query .= "AND m.year_name = $year ";
      $this_year_result = DB::select(DB::raw($query));
      $priceData = $this_year_result[0];
      array_push($monthlyData, array(
        "month_id" => "$month_id->month_id", "price" => $priceData->price));
    }

    for ($i = 0; $i < count($monthlyData); $i++) {
      $priceData = $monthlyData[$i];

      if ($priceData['month_id'] == 12) {
        //do nothing
      } else {
        $prevMonthData = $monthlyData[$i - 1];
        $currentMonthData = $monthlyData[$i];
        $compared = round(($currentMonthData['price'] / $prevMonthData['price']) * 100);

        $comparisons[] = new MonthlyData($currentMonthData['month_id'], $compared);
      }

    }

    $latestMonthId = count($comparisons) + 1;
    for ($i = $latestMonthId; $i <= 12; $i++) {
      $comparisons[] = new MonthlyData($i, "");
    }
    return $comparisons;
  }

  function sameMonthComparison($thisYear, $indicator_id, $market_id)
  {
    $month_ids = $this->distinctMonthIds($thisYear, $indicator_id, $market_id);
    $lastYear = $thisYear - 1;
    $comparisons = array();

    $baseQuery = "SELECT AVG(m.price) as price FROM market_data m ";
    $baseQuery .= "WHERE m.market_id = $market_id  ";
    $baseQuery .= "AND m.indicator_id = $indicator_id ";

    foreach ($month_ids as $month_id) {
      //This year data
      $thisYearQuery = $baseQuery;
      $lastYearQuery = $baseQuery;

      $thisYearQuery .= "AND m.year_name = $thisYear ";
      $thisYearQuery .= "AND m.month_id = $month_id->month_id ";
      $lastYearQuery .= "AND m.year_name = $lastYear ";
      $lastYearQuery .= "AND m.month_id = $month_id->month_id ";

      $thisYearResult = DB::select(DB::raw($thisYearQuery));
      $lastYearResult = DB::select(DB::raw($lastYearQuery));
      $compared = round(($thisYearResult[0]->price / $lastYearResult[0]->price) * 100);
      $comparisons[] = new MonthlyData($month_id->month_id, $compared);
    }


    $latestMonthId = count($comparisons) + 1;
    for ($i = $latestMonthId; $i <= 12; $i++) {
      $comparisons[] = new MonthlyData($i, "");
    }
    return $comparisons;
  }

  //Comparison between current price with LTM
  function percentageOfLTM($thisYear, $indicator_id, $market_id)
  {
    $ltm = $this->ltm($thisYear, $indicator_id, $market_id);
    $distinctIds = $this->distinctMonthIds($thisYear, $indicator_id, $market_id);
    $query = "SELECT AVG(m.price) as price FROM market_data m ";
    $query .= "WHERE m.market_id = $market_id  ";
    $query .= "AND m.indicator_id = $indicator_id ";
    $query .= "AND m.year_name = $thisYear ";
    $data = array();

    foreach ($distinctIds as $monthData) {
      $finalQuery = $query;
      $finalQuery .= "AND m.month_id = $monthData->month_id ";
      $result = DB::select(DB::raw($finalQuery));
      $data[$monthData->month_id] = $result[0]->price;
    }

    $index = 0;
    $comparisons = array();
    foreach ($data as $month_id => $price) {
      //Get its equivalent LTM, compare it to current price
      $ltmObject = $ltm[$index];
      $currentAverage = $ltmObject->data_value;
      $compared = round(($price / $currentAverage) * 100);
      $comparisons[] = new MonthlyData($month_id, $compared);
      $index++;
    }
    $latestMonthId = count($comparisons) + 1;
    for ($i = $latestMonthId; $i <= 12; $i++) {
      $comparisons[] = new MonthlyData($i, "");
    }
    return $comparisons;

  }

  function twelveMonthMinMax($thisYear, $indicator_id, $market_id)
  {
    $data = array();
    $lastYear = $thisYear - 1;
    for ($month_id = 1; $month_id <= 12; $month_id++) {
      $query = "SELECT m.year_name, m.month_id, AVG(price) as monthly_average ";
      $query .= "FROM market_data m ";
      $query .= "WHERE ((year_name = $lastYear AND month_id > $month_id) OR (year_name = $thisYear AND month_id <= $month_id)) ";
      $query .= "AND m.market_id = $market_id AND m.indicator_id = $indicator_id  ";
      $query .= "GROUP BY m.year_name, m.month_id ";
      $result = DB::select(DB::raw($query));
      $temp = array();
      for ($row = 0; $row < count($result); $row++) {
        if (!is_null($result[$row]->monthly_average)) {
          $temp[] = $result[$row]->monthly_average;
        }
      }

      $maxValues = $temp;
      $minValues = $temp;
      sort($minValues); //Sort in ascending order
      rsort($maxValues);// Sort array in descending order

      $max = new MonthlyData($month_id, round($maxValues[0]));
      $min = new MonthlyData($month_id, round($minValues[0]));
      $maxMin = array("max" => $max, "min" => $min);
      $data[] = $maxMin;
    }

    return $data;
  }

  function sixMonthMaxMin($thisYear, $indicator_id, $market_id)
  {
    /*
    $result = $this->distinctMonthIds($thisYear, $indicator_id, $market_id);
    */
    $lastYear = $thisYear - 1;
    $monthYearObjects = array();
    $data = array();

    for ($i = 1; $i <= 12; $i++) {
      $month_id = $i;
      $temp = array();
      if ($month_id < 6) {

        //Get this years monthYear objects
        for ($k = 1; $k <= $month_id; $k++) {
          $temp[] = array("month_id" => $k, "year_name" => $thisYear);
        }
        $lastMonthId = (12 - (6 - $month_id));

        //Get last years monthYearObjects
        for ($j = 12; $j > $lastMonthId; $j--) {
          $temp[] = array("month_id" => $j, "year_name" => $lastYear);
        }
        $monthYearObjects[$month_id] = $temp;
      } else {
        //Get this years monthYear objects
        for ($k = 1; $k <= $month_id; $k++) {
          $temp[] = array("month_id" => $k, "year_name" => $thisYear);
        }
        $monthYearObjects[$month_id] = $temp;
      }
    }
    foreach ($monthYearObjects as $monthId => $sixMonthObjects) {

      $monthTemp = array();
      foreach ($sixMonthObjects as $monthYearObject) {
        $currentMonthId = $monthYearObject['month_id'];
        $year_name = $monthYearObject['year_name'];
        $query = "SELECT m.month_id, AVG(price) as monthly_average ";
        $query .= "FROM market_data m ";
        $query .= "WHERE m.market_id = $market_id AND m.indicator_id = $indicator_id ";
        $query .= "AND m.year_name = $year_name and m.month_id = $currentMonthId ";
        $result = DB::select(DB::raw($query));
        $monthTemp [] = $result[0]->monthly_average;
      }

      $minValues = $monthTemp;
      $maxValues = $monthTemp;
      sort($minValues);
      rsort($maxValues);

      $max = new MonthlyData($monthId, round($maxValues[0])>0 ?round($maxValues[0]): "" );
      $min = new MonthlyData($monthId, round($minValues[0])>0 ?round($minValues[0]) : "");

      $maxMin = array("max" => $max, "min" => $min);
      $data[] = $maxMin;
    }
    return $data;

  }

  function sixMonthsDiff($thisYear, $indicator_id, $market_id)
  {
    $lastYear = $thisYear - 1;
    $thisYearMonths = $this->distinctMonthIds($thisYear, $indicator_id, $market_id);
    $comparisons = array();

    for ($i = 0; $i < count($thisYearMonths); $i++) {
      $currentMonthId = $thisYearMonths[$i]->month_id;
      if ($currentMonthId > 6) {
        //Compare to a month this year
        $sixMonthID = $currentMonthId - 6;
        $query = "SELECT m.month_id, AVG(price) as monthly_average ";
        $query .= "FROM market_data m ";
        $query .= "WHERE m.market_id = $market_id ";
        $query .= "AND m.indicator_id = $indicator_id ";
        $query .= "AND m.year_name = $thisYear ";
        $query .= "AND ((m.month_id = $currentMonthId ) ||  (m.month_id = $sixMonthID)) ";
        $query .= "GROUP BY m.month_id ";
        $result = DB::select(DB::raw($query));

        $denominator = 0;
        $numerator = 0;

        foreach ($result as $dataRow) {
          if ($dataRow->month_id == $currentMonthId) {
            $numerator = $dataRow->monthly_average;
          } else {
            $denominator = $dataRow->monthly_average;
          }
        }
        //Make the comparison
        if ($numerator > 0 && $denominator > 0) {
          $compared = round(($numerator / $denominator) * 100);
          $comparisons[] = new MonthlyData($currentMonthId, $compared);
        }

      } else {
        //Compare to a month last year
        $sixMonthID = $currentMonthId + 6;
        $query = "SELECT m.year_name, m.month_id, AVG(price) as monthly_average ";
        $query .= "FROM market_data m ";
        $query .= "WHERE m.market_id = $market_id ";
        $query .= "AND m.indicator_id = $indicator_id ";
        $query .= "AND ((m.year_name = $lastYear and m.month_id = $sixMonthID) ";
        $query .= "|| (m.year_name = $thisYear and m.month_id = $currentMonthId)) ";
        $query .= "GROUP BY  m.year_name, m.month_id ";
        $result = DB::select(DB::raw($query));

        $denominator = 0;
        $numerator = 0;

        foreach ($result as $dataRow) {
          if ($dataRow->year_name == $thisYear) {
            $numerator = $dataRow->monthly_average;
          } else {
            $denominator = $dataRow->monthly_average;
          }

        }
        //Make the comparison
        if ($numerator > 0 && $denominator > 0) {
          $compared = round(($numerator / $denominator) * 100);
          $comparisons[] = new MonthlyData($currentMonthId, $compared);
        }

      }
    }

    $latestMonthId = count($comparisons) + 1;
    for ($i = $latestMonthId; $i <= 12; $i++) {
      $comparisons[] = new MonthlyData($i, "");
    }

    return $comparisons;


  }


  function distinctMonthIds($year, $indicator_id, $market_id)
  {
    $distinct_month_ids = "SELECT DISTINCT(month_id) FROM market_data ";
    $distinct_month_ids .= "WHERE year_name = $year AND indicator_id = $indicator_id ";
    $distinct_month_ids .= "AND market_id = $market_id ";
    $month_ids = DB::select(DB::raw($distinct_month_ids));
    return $month_ids;
  }


}
