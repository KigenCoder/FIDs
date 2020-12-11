<?php

namespace App\Http\Controllers;
use App\SlimsPart2Details;
use App\MarketData;
use Illuminate\Http\Request;

class ScratchPadController extends Controller
{

    public function index()
    {
        $integerArrays = [-1, 1, 3, 3, 3, 2, 3, 2, 1, 0];
        $answer = $this->stableVelocity($integerArrays);

        return json_encode(["Answer" => $answer]);

    }


    function dedup_market_data()
    {
        $whereClause = ["year_name" => 2020, "month_id" => 11];
        $dataItems = MarketData::where($whereClause)->orderBy('id', 'ASC')->get();

        $deleted = 0;

        for($i = 0; $i < count($dataItems); $i++) {
            $dataItem = $dataItems[$i];
            for ($k = ($i + 1); $k < (count($dataItems) - $i); $k++) {
                $compare = $dataItems[$k];
                if (strcasecmp($dataItem->market_id, $compare->market_id) == 0
                    && strcasecmp($dataItem->indicator_id, $compare->indicator_id) == 0
                    && strcasecmp($dataItem->week, $compare->week) == 0
                    && strcasecmp($dataItem->id, $compare->id) !== 0) {
                    //MarketData::where('id', $compare->id)->delete();
                    $deleted++;
                }


            }

            return "$deleted Duplicates removed";


        }


    }


    function stableVelocity(array $integers)
    {

        $stableVelocities = 0;

        for ($i = 0; $i < count($integers); $i++) {

            if ($i < count($integers) - 2) {
                //Compare 3 subsequent elements
                //Compare first two
                $firstAndSecond = $integers[$i] - $integers[$i + 1];
                $secondAndThird = $integers[$i + 1] - $integers[$i + 2];
                if ($firstAndSecond == $secondAndThird) {
                    $stableVelocities++;
                }
            }
        }
        return $stableVelocities;

    }


    function siblings($integer)
    {

        //return   $d = array_pad(array(), 30, 0);
        $arrayOfDigits = str_split($integer);

        return -1 - 3;


        rsort($arrayOfDigits);

        $largestNumber = join($arrayOfDigits);


        if (intVal($largestNumber) > 100000000) {
            return -1;
        }

        return intval($largestNumber);
    }

    function frogRiverOne($x, array $integersArray)
    {
        $check = -1;

        for ($i = 0; $i < count($integersArray); $i++) {
            if ($i == $x) {
                $check = $integersArray[$i];
                break;
            }

        }

        return $check;
    }

    function permCheck(array $integersArray)
    {
        $check = 1;
        sort($integersArray);

        for ($i = 0; $i < count($integersArray); $i++) {

            if ($i != count($integersArray) - 1) {

                //Check the difference
                if (($integersArray[$i + 1] - $integersArray[$i]) != 1) {

                    $check = 0;
                    break;
                }
            }
        }
        return $check;
    }


    function tapeEquilibrium(array $integersArray)
    {
        $absoluteSums = array();
        for ($i = 0; $i < count($integersArray); $i++) {

            if ($i == 0) {
                $firstArray = array_slice($integersArray, $i, $i + 1);
                $lastArray = array_slice($integersArray, $i + 1, count($integersArray) - 1);

            } else {
                $firstArray = array_slice($integersArray, 0, $i + 1);

                $lastArray = array_slice($integersArray, $i + 1, count($integersArray) - 1);

            }

            $absoluteSums[] = abs(array_sum($firstArray) - array_sum($lastArray));

        }

        sort($absoluteSums);

        return $absoluteSums;

    }

    function permMissingElem(array $integerValues)
    {
        //First sort the array in ascending order
        sort($integerValues);

        for ($i = 0; $i < count($integerValues); $i++) {

            if ($i < (count($integerValues) - 1)) {
                //compare subsequent elements
                if ($integerValues[$i + 1] - $integerValues[$i] > 1) {
                    //There is the missing number
                    return $integerValues[$i] + 1;
                    //break;
                }
            }
        }
    }

    function frogJump($start, $end, $jump)
    {

        $distance = $end - $start;

        $jumps = intVal(ceil($distance / $jump));

        return $jumps;
    }

    function cyclicRotation(array $integersArray, $k)
    {

        if ($k < count($integersArray)) {

            //shift array elements k times to the right
            $numbersAndIndexes = array();
            for ($i = 0; $i < count($integersArray); $i++) {
                $newIndex = $i + $k;

                if ($newIndex < count($integersArray)) {

                    $numbersAndIndexes[$newIndex] = $integersArray[$i];
                } else {
                    $revisedIndex = ($i + $k) - count($integersArray);
                    $numbersAndIndexes[$revisedIndex] = $integersArray[$i];

                }

            }

            ksort($numbersAndIndexes, 1);
            return $numbersAndIndexes;
        }
    }


    function oddOccurrences(array $integersArray)
    {

        $oddOneOut = 0;
        $elementOccurrences = array_count_values($integersArray);

        foreach ($elementOccurrences as $element => $occurrence) {

            if ($occurrence == 1) {
                $oddOneOut = $element;
                break;
            }
        }
        return $oddOneOut;
    }


    function binaryGap($integer)
    {
        $binaryNumber = decbin($integer);
        $split = str_split($binaryNumber);
        $maxGap = 0;
        $currentGap = 0;

        $i = 0;
        while ($i < count($split)) {

            if ($split[$i] == 0) {
                //begin count
                $currentGap++;
            } else {
                //Stop count and check if $currentGap >$maxGap
                if ($currentGap > $maxGap) {
                    $maxGap = $currentGap;
                }
                //Reset current Gap
                $currentGap = 0;
            }
            $i++;
        }

        return $maxGap;

    }


}
