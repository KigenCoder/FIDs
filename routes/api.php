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

Route::get('zones', 'APIController@zones');
Route::post('regions', 'APIController@regions');
Route::get('years', 'APIController@years');
Route::post('markets', 'APIController@markets');
Route::post('indicators', 'APIController@indicators');
Route::post('analysis_data', 'APIController@analysis_data');
Route::post('meta_data', 'APIController@marketMetaData');

Route::get("scratch-pad", "ScratchPadController@index");

//Route::get('test', 'APIController@sixMonthsDiff');
