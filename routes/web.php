<?php

Route::get('/', 'AuthController@index');
Route::resource("login", "AuthController");
Route::resource("user", "UserAdminController");
Route::resource("user.markets", "UserMarkets");
Route::get("data-entry", "DataUpdates@data_entry");
Route::get("data-cleaning", "DataUpdates@data_cleaning");
Route::get("monthly-analysis", "MarketAnalysis@monthly_analysis");
Route::get("tot", "ToTController@tot");
Route::get('weekly-data', "WeeklyData@weekly_data");
Route::get('weekly-data-entry', "WeeklyData@data_entry");
Route::resource('export', 'ExportsController');
Route::resource('analyst', 'UserAnalystController');





Route::group([
    'prefix' => 'data'
], function () {
  Route::get("filter", "EnumeratorMarketData@filter");
  Route::post("fetch", "EnumeratorMarketData@fetch");
  //Route::get("display", "EnumeratorMarketData@display")->name('display.data');
});

Route::get('logout', 'AuthController@logout');