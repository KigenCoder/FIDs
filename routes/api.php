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

Route::get('indicators', 'APIController@indicators');
Route::get('zones', 'APIController@zones');
Route::get('regions', 'APIController@regions');
Route::get('years', 'APIController@years');
Route::get('markets', 'APIController@markets');
