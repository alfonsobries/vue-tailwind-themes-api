<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Auth::routes();

Route::get('/css-autocomplete', 'CssAutocompleteController')->name('cssautocomplete');

Route::middleware('auth:sanctum')->get('/user', 'AccountController@show');
