<?php

Route::group(['prefix' => 'auth'], function ()
{
    Route::post('login', 'AppAuthController@login');
    Route::post('signup', 'AppAuthController@signup');
  
    Route::group([
      'middleware' => 'auth:api'
    ], function() {
        Route::get('logout', 'AppAuthController@logout');
        Route::get('user', 'AppAuthController@user');
        Route::post('upload', 'AppAuthController@uploadMarketData');
    });
});

//Monthly analysis
Route::get('zones', 'APIController@zones');
Route::post('regions', 'APIController@regions');
Route::get('years', 'APIController@years');
Route::post('markets', 'APIController@markets');
Route::post('indicators', 'APIController@indicators');
Route::post('analysis_data', 'APIController@analysis_data');
Route::post('meta_data', 'APIController@marketMetaData');
Route::post('tot_data', 'ToTController@tot_data');
Route::post('tot_meta_data', 'ToTController@tot_meta_data');
Route::post('cleaning_markets', 'DataUpdates@markets');
Route::post('cleaning_data', 'DataUpdates@market_data');
Route::post('update_data', 'DataUpdates@updateData');
Route::post('market_indicators', 'DataUpdates@market_indicators');
Route::post('save_data', 'DataEntry@save_data');
Route::post('supply_update', 'DataEntry@supply_update');
Route::post("save_weekly", "WeeklyData@save_weekly");

//Route::get("scratch-pad", "ScratchPadController@index");
//Route::get('test', 'APIController@twelveMonthMinMax');
