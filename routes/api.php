<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Auth::routes();

Route::get('/css-autocomplete', 'CssAutocompleteController')->name('cssautocomplete');

Route::get('themes', 'ThemeController@index')->name('themes.index');
Route::get('themes/{theme}', 'ThemeController@show')->name('themes.show');

Route::post('newsletter/subscribe', 'NewsletterController@subscribe')->name('newsletter.subscribe');
Route::post('newsletter/unsubscribe', 'NewsletterController@unsubscribe')->name('newsletter.unsubscribe');

Route::group(['middleware' => 'auth:sanctum'], function () {
  Route::get('/user', 'AccountController@show');

  Route::post('themes', 'ThemeController@store')->name('themes.store');
  Route::delete('themes/{theme}', 'ThemeController@destroy')->name('themes.destroy');
  Route::put('themes/{theme}', 'ThemeController@update')->name('themes.update');
});

