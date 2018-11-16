<?php

Route::get('/', 'AuthController@index');
Route::resource("login", "AuthController");
Route::resource("user", "UserManagementController");
Route::resource("user.markets", "UserMarkets");

Route::get('logout', 'AuthController@logout');