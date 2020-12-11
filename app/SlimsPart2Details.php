<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SlimsPart2Details extends Model
{
    protected $table = "slims_part2_details";
    public function usesTimestamps() : bool{
        return false;
    }

    protected $fillable = [
        "year",
        "month_id",
        "market_id",
        "indicator_id",
        "location_name",
        "key_informant",
        "triangulation",
        "data_trust_level",
    ];


}
