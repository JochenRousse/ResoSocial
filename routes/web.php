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


/**
 * User
 */
Route::get('user/profil', function() {
    return redirect()->route('user.profil', ['id' => Auth::user()->id]);
});
Route::get('user/{id}/profil', 'UserController@index')->name('user.profil');
Route::delete('/user/{id}', 'UserController@destroy')->name('delete');
Route::put('/user/{id}', 'UserController@update')->name('update');
Route::match(['get', 'post'], '/search', 'UserController@search')->name('search');

/**
 * Friend-requests
 */
Route::post('friend-requests', 'FriendRequestController@store')->name('friend.requests.store');
Route::delete('friend-requests/decline', 'FriendRequestController@decline')->name('friend.requests.decline');
Route::delete('friend-requests/erase', 'FriendRequestController@erase')->name('friend.requests.erase');


/**
 * Friends
 */
Route::get('user/{id}/friends', 'FriendController@index')->name('user.friends');
Route::post('friends', 'FriendController@create')->name('friend.create');
Route::delete('friends', 'FriendController@destroy')->name('friend.delete');


/**
 * Group-requests
 */
Route::post('group-requests', 'GroupRequestController@store')->name('group.requests.store');
Route::delete('group-requests', 'GroupRequestController@decline')->name('group.requests.decline');


/**
 * Groups
 */
Route::get('user/{id}/groups', 'GroupController@index')->name('user.groups');
Route::get('group/{id}/page', 'GroupController@page')->name('group.page');
Route::post('group', 'GroupController@create')->name('group.create');
Route::post('group/join', 'GroupController@join')->name('group.join');
Route::post('group/leave', 'GroupController@leave')->name('group.leave');
Route::delete('group', 'GroupController@destroy')->name('group.delete');


/**
 * Params
 */
Route::get('user/{id}/params', 'ParamsController@index')->name('user.params');
Route::post('params/update', 'ParamsController@update')->name('user.update');
Route::post('params/preferences1', 'ParamsController@preferences1')->name('user.bg');
Route::post('params/preferences2', 'ParamsController@preferences2')->name('user.text');