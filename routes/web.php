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

Route::get('/', function () {
    return view('welcome');
});

Route::get('concert/{id}', 'ConcertsController@show')->name('concerts.show');
Route::post('concerts/{id}/orders', 'ConcertOrdersController@store')->name('concert.orders.store');
