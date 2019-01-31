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
    return view('home');
});

Route::get('/api/getCountry', 'gameController@getCountry');
Route::post('/api/putScore', 'gameController@putScore');
Route::get('/api/getScoreByCountry/{country_code}', 'gameController@getScoreByCountry');
Route::get('/api/getScoreByUser/{user_id}', 'gameController@getScoreByUser');
