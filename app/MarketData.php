<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MarketData extends Model{

protected $table = 'market_data';
public $timestamps = false;
protected $fillable = [
    'year_name',
    'week',
    'market_id',
    'indicator_id',
    'price',
    'month_id'
];

}