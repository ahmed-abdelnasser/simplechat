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
    $ttn_code = \DB::select('select name from users');
    $ttn_number = \DB::select('select id from users');
    $ttn_code  = json_decode(json_encode($ttn_code), true);
    $ttn_number  = json_decode(json_encode($ttn_number), true);
    dd($ttn_number);
    $diff = array_diff_key($ttn_code, $ttn_number);


});


Route::get('chat', 'ChatController@chat');
Route::post('send', 'ChatController@send');
Route::post('getOldMessages', 'ChatController@getOldMessages');
Route::post('saveMessage', 'ChatController@saveMessage');
Auth::routes();

Route::get('/home', 'ChatController@chat')->name('home');

Auth::routes();
