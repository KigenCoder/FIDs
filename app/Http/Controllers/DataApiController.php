<?php

namespace App\Http\Controllers;

use App\Classes\IndicatorDataset;
use App\Classes\IndicatorList;
use App\MarketData;
use App\SlimsPart2Details;
use App\SlimsPart2Comments;
use Illuminate\Http\Request;
use DB;

class DataApiController extends Controller
{
    public function markets(Request $request)
    {
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

    public function market_data(Request $request)
    {
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
                    //SLIMS II
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
                    $dataQuery .= "LEFT JOIN supply s ON s.id = m.supply_id ";
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


    public function market_indicators(Request $request)
    {
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


    public function updateData(Request $request)
    {
        $marketData = json_decode($request->all()["market_data"]);
        $updated = 0;
        $deleted = 0;

        foreach ($marketData as $priceObject) {

            try {
                $price_id = $priceObject->price_id;
                $newPrice = $priceObject->price;
                $numeric_price = intval($newPrice);

                $marketData = MarketData::findOrFail($price_id);
                if (strcasecmp("", $newPrice) == 0 || $numeric_price == 0) {
                    //Check if Price is blank/zero if so delete
                    MarketData::destroy($price_id);
                    $deleted++;
                } else {
                    //Update record
                    $marketData->price = $newPrice;
                    $response = $marketData->save();
                    $updated++;

                }
            } catch (\Exception $exception) {

            }

        }

        $message = "Updated: $updated, Deleted: $deleted ";

        return json_encode($message);

    }


    public function save_data(Request $request)
    {

        $marketData = json_decode($request->all()["market_data"]);

        $savedRecords = 0;
        $existingRecords = 0;

        for ($i = 0; $i < count($marketData); $i++) {
            $priceObject = $marketData[$i];
            $data['market_id'] = $priceObject->market_id;
            $data['year_name'] = $priceObject->year_name;
            $data['month_id'] = $priceObject->month_id;
            $data['week'] = $priceObject->week_id;
            $data['indicator_id'] = $priceObject->indicator_id;
            $data['price'] = $priceObject->price;
            $data['supply_id'] = $priceObject->supply_id;

            //Check for saved data
            $savedPrice = $this->savedPrice($data);

            if (!$savedPrice) {
                MarketData::create($data); //Price does not exist so save it
                $savedRecords++;
            } else {
                $existingRecords++; //Price exists so notify user
            }
        }

        return json_encode("Saved: $savedRecords Existing: $existingRecords");


    }


    public function save_slims_data(Request $request)
    {
        $marketData = json_decode($request->all()["market_data"]);
        $comments = json_decode($request->all()["comments"]);

        $savedRecords = 0;
        $existingRecords = 0;


        for ($i = 0; $i < count($marketData); $i++) {
            $priceObject = $marketData[$i];
            $data['market_id'] = $priceObject->market_id;
            $data['year_name'] = $priceObject->year_name;
            $data['month_id'] = $priceObject->month_id;
            $data['week'] = $priceObject->week_id;
            $data['indicator_id'] = $priceObject->indicator_id;
            $data['price'] = $priceObject->price;
            $data['supply_id'] = $priceObject->supply_id;

            //Check for saved data
            $savedPrice = $this->savedPrice($data);

            if (!$savedPrice) {
                //MarketData::create($data); //Price does not exist so save it
                $savedRecords++;
            } else {
                $existingRecords++; //Price exists so notify user
            }

            $slimData = array();

            if (!$this->emptyString($priceObject->location_name)) {
                $slimData['location_name'] = $priceObject->location_name;
            }

            if (!$this->emptyString($priceObject->key_informant)) {
                $slimData['key_informant'] = $priceObject->key_informant;
            }

            if (!$this->emptyString($priceObject->triangulation)) {
                $slimData['triangulation'] = $priceObject->triangulation;
            }

            if (!$this->emptyString($priceObject->data_trust_level)) {
                $slimData['data_trust_level'] = $priceObject->data_trust_level;
            }

            if (count($slimData) > 0) {
                //Save data
                $slimData['year'] = $priceObject->year_name;
                $slimData['month_id'] = $priceObject->month_id;
                $slimData['market_id'] = $priceObject->market_id;
                $slimData['indicator_id'] = $priceObject->indicator_id;
                SlimsPart2Details::create($slimData);
            }

        }

        if (!$this->emptyString($comments->comments)) {

            $commentsData['year_name'] = $comments->year_name;
            $commentsData['month_id'] = $comments->month_id;
            $commentsData['market_id'] = $comments->market_id;
            $commentsData['comments'] = $comments->comments;
            SlimsPart2Comments::create($commentsData);

        }

        return json_encode("Saved: $savedRecords Existing: $existingRecords");

    }

    public function save_slims(Request $request)
    {

    }


    public function supply_update(Request $request)
    {
        $response = null;
        if ($request->has('year_name') && $request->has('month_id')
            && $request->has('market_id') && $request->has('indicator_id')
            && $request->has('supply_id')) {
            $input = $request->all();
            $data = array();
            $data['year_name'] = $input['year_name'];
            $data['month_id'] = $input['month_id'];
            $data['week'] = "";
            $data['market_id'] = $input['market_id'];
            $data['indicator_id'] = $input['indicator_id'];
            $savedData = $this->savedPrice($data);
            $updated = 0;
            //$update_ids = array();
            for ($i = 0; $i < count($savedData); $i++) {
                $fetched = MarketData::findOrFail($savedData[$i]->id);
                $fetched->supply_id = $input['supply_id'];
                $fetched->save();
                $updated++;
            }
            $response = array("Message" => "Records updated: $updated");
        }
        return json_encode($response);

    }


    public function save_weekly(Request $request)
    {

        $marketData = json_decode($request->all()["market_data"]);
        $savedRecords = 0;
        $existingRecords = 0;

        for ($i = 0; $i < count($marketData); $i++) {
            $priceObject = $marketData[$i];
            $data['market_id'] = $priceObject->market_id;
            $data['year_name'] = $priceObject->year_name;
            $data['month_id'] = $priceObject->month_id;
            $data['week'] = $priceObject->week_id;
            $data['indicator_id'] = $priceObject->indicator_id;
            $data['price'] = $priceObject->price;

            //Check for saved data
            $savedPrice = $this->savedPrice($data);

            if (!$savedPrice) {
                MarketData::create($data); //Price does not exist so save it
                $savedRecords++;
            } else {
                $existingRecords++; //Price exists so notify user
            }
        }

        return json_encode(array("saved" => $savedRecords, "existing" => $existingRecords));


    }


    public function savedPrice(array $data)
    {
        $year_name = $data['year_name'];
        $month_id = $data['month_id'];
        $market_id = $data['market_id'];
        $indicator_id = $data['indicator_id'];
        $week = $data['week'];

        $query = "SELECT * FROM market_data m ";
        $query .= "WHERE m.year_name = $year_name AND m.month_id = $month_id ";
        $query .= "AND m.market_id = $market_id AND m.indicator_id = $indicator_id ";
        $query .= "AND week = $week ";
        return DB::select(DB::raw($query));

    }

    function emptyString($stringVar): bool
    {
        if (strcasecmp("", $stringVar) == 0) {
            return true;
        } else {
            return false;
        }
    }


}
