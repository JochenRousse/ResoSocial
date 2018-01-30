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


Route::get('user/profil', function() {
    return redirect()->route('user.profil', ['id' => Auth::user()->id]);
});
Route::get('user/{id}/profil', 'UserController@index')->name('user.profil');
Route::get('user/{id}/params', 'UserController@params')->name('user.params');
Route::delete('/user/{id}', 'UserController@destroy')->name('delete');
Route::post('/search', 'UserController@search')->name('search');

/**
 * Friend-requests
 */
Route::post('friend-requests', 'FriendRequestController@store')->name('friend.requests.store');
Route::delete('friend-requests', 'FriendRequestController@destroy')->name('friend.requests.delete');


/**
 * Friends
 */
Route::get('user/{id}/friends', 'FriendController@index')->name('user.friends');
Route::post('friends', 'FriendController@create')->name('friend.create');
Route::delete('friends', 'FriendController@destroy')->name('friend.destroy');
