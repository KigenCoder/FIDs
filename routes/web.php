<?php

Route::get('/', 'AuthController@index');
Route::resource("login", "AuthController");
Route::resource("user", "UserAdminController");
Route::resource("user.markets", "UserMarkets");
Route::get("data-entry", "DataEntryController@data_entry");
Route::get("data-cleaning", "DataCleaningController@data_entry");
Route::get("monthly-analysis", "MarketAnalysis@monthly_analysis");


Route::group([
    'prefix' => 'data'
], function () {
  Route::get("filter", "EnumeratorMarketData@filter");
  Route::post("fetch", "EnumeratorMarketData@fetch");
  //Route::get("display", "EnumeratorMarketData@display")->name('display.data');
});

Route::get('logout', 'AuthController@logout');