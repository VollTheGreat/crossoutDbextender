<?php

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

Route::get('/', 'MainController@index');
Route::get('/api/stats', 'MainController@stats');
Route::get('/api/rares', 'MainController@rares');
Route::get('/api/epics', 'MainController@epics');
Route::get('/dashboard/{RarityType}', 'MainController@dashboard');
