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

Route::view('/','welcome');


Route::get('chat', 'ChatController@chat')->name('chat');
Route::post('send', 'ChatController@send');
Route::post('getOldMessages', 'ChatController@getOldMessages');
Route::post('saveMessage', 'ChatController@saveMessage');
Auth::routes();

Route::get('/home', 'ChatController@chat')->name('home');

Auth::routes();
