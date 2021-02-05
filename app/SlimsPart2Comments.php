<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SlimsPart2Comments extends Model
{
    protected $table='slims_part2_comments';

    public $timestamps = false;

    protected $fillable=[
        'year_name',
        'month_id',
        'market_id',
        'comments'

        ];
}
