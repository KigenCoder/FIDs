<?php

use Illuminate\Http\Request;
Route::group([
    'prefix' => 'auth'
], function () {
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
