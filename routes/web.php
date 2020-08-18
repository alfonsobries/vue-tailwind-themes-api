<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/allgood', 'AllgoodController');

Route::get('/newsletter-admin/login', 'Auth\LoginController@showNewsletterAdminLoginForm')->name('newsletter_admin.login.show');
Route::post('/newsletter-admin/login', 'Auth\LoginController@newsletterAdminLogin')->name('newsletter_admin.login');
Route::post('/newsletter-admin/logout', 'Auth\LoginController@newsletterAdminLogout')->name('newsletter_admin.logout');
