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

Auth::routes();

Route::get('profile/edit', 'ProfileController@edit');
Route::put('profile/update', 'ProfileController@update')->name('profile.update');
Route::group(['middleware' => ['gender']], function () {
    Route::get('/home', 'HomeController@index')->name('home');
});

