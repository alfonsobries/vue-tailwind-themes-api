<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Auth::routes();

Route::get('/css-autocomplete', 'CssAutocompleteController')->name('cssautocomplete');

Route::group(['middleware' => 'auth:sanctum'], function () {
  Route::get('/user', 'AccountController@show');

  Route::resource('themes', 'ThemeController');
});

