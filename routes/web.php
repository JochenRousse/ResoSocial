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
    return redirect('/login');
});

Auth::routes();

Route::delete('/delete/{id}', 'UserController@destroy')->name('delete');


Route::get('user/profil', function() {
    return redirect()->route('user.profil', ['id' => Auth::user()->id]);
});

Route::get('user/params', function() {
    return redirect()->route('user.params', ['id' => Auth::user()->id]);
});

Route::get('user/{id}/profil', 'UserController@index')->name('user.profil');
Route::get('user/{id}/params', 'UserController@params')->name('user.params');