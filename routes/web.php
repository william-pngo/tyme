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

Route::get('/about', function () {
    return view('about');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/catalog', 'ItemController@showItems');
Route::post('/catalog', 'GenreController@filterByGenre');
Route::post('/catalog-country', 'CountryController@filterByCountry');

Route::middleware('admin')->group(function(){
	Route::get('/admin/showAddItemForm', 'ItemController@showAddItemForm');
	Route::post('/admin/addItem', 'ItemController@addItem');
	Route::post('/admin/editItem/{id}', 'ItemController@editItem');
	Route::delete('/admin/deleteItem/{id}', 'ItemController@deleteItem');
	Route::get('/admin/showAllUsers', 'ItemController@showAllUsers');
	Route::post('/admin/filterByUser', 'ItemController@filterByUser');
	Route::post('/admin/filterByStatus', 'ItemController@filterByStatus');
	Route::patch('/admin/userDetails/{id}', 'ItemController@userDetails');
	Route::post('/admin/editDetails/{id}', 'ItemController@editDetails');
	Route::patch('/admin/demoteUserRole/{id}', 'ItemController@demoteUserRole');
	Route::patch('/admin/promoteUserRole/{id}', 'ItemController@promoteUserRole');
	Route::delete('/admin/removeUser/{id}', 'ItemController@removeUser');
	Route::get('/admin/showAllOrders', 'ItemController@showAllOrders');
	Route::patch('/admin/approveOrderStatus/{id}', 'ItemController@approveOrderStatus');
	Route::patch('/admin/rejectOrderStatus/{id}', 'ItemController@rejectOrderStatus');
	Route::delete('/admin/deleteOrder/{id}', 'ItemController@deleteOrder');
});

Route::middleware('user')->group(function(){
	Route::patch('/cancelOrderStatus/{id}', 'ItemController@cancelOrderStatus');
	Route::post('/editDetails/{id}', 'ItemController@editDetails');
	Route::post('/reserve/{id}', 'ItemController@reserveItem');
	Route::post('/return/{id}', 'ItemController@returnItem');
	Route::get('/myOrders', 'ItemController@showOrders');
	Route::get('/myProfile/{id}', 'ItemController@showProfile');
	Route::delete('/deleteProfile/{id}', 'ItemController@deleteProfile');
});


