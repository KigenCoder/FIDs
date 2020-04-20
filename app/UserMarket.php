<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserMarket extends Model{
    //protected $table = "user_markets";
    protected $fillable = [
        'user_id',
        'market_id'
    ];

    protected function market(){
        return $this->belongsTo('App\Market');
    }

    protected function user(){
        return $this->belongsTo('App\User');
    }

}
