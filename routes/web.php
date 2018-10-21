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
Route::get('login/{provider}', 'Auth\LoginController@redirectToProvider');
Route::get('login/{provider}/callback', 'Auth\LoginController@handleProviderCallback');


Route::get('profile/edit', 'ProfileController@edit');
Route::put('profile/update', 'ProfileController@update')->name('profile.update');
Route::group(['middleware' => ['gender']], function () {
    Route::get('/home', 'HomeController@index')->name('home');
    Route::get('/posts', 'PostController@index')->name('posts');
    Route::post('post/store', 'PostController@store')->name('post.store');
    Route::get ('/post/{id}/edit', 'PostController@edit')->name('post.edit');
    Route::put ('/post/{id}', 'PostController@edit' )->name('post.update');
    Route::delete ('/post/destroy', 'PostController@destroy' )->name('post.destroy');
});

