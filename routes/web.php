<?php

Route::get('/', 'AuthController@index');
Route::resource("login", "AuthController");
Route::resource("user", "UserAdminController");
Route::resource("user.markets", "UserMarkets");
Route::group([
    'prefix' => 'data'
], function () {
  Route::get("filter", "EnumeratorMarketData@filter");
  Route::post("fetch", "EnumeratorMarketData@fetch");
  //Route::get("display", "EnumeratorMarketData@display")->name('display.data');
});

Route::get('logout', 'AuthController@logout');