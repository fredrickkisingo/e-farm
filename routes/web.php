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
//for customized routes

Route::get('/', 'PagesController@index');
Route::get('/about', 'PagesController@about');
Route::get('/services', 'PagesController@services');

Route::resource('posts', 'PostsController');
Route::resource('carts','CartsController');
Route::resource('maps','MapsController');
Route::resource('directions','DirectionsController');
Route::resource('harvestlosses','HarvestlossesController');
Route::resource('purchases', 'PurchasesController');

//Route::get('/',function(){
   




Auth::routes();

Route::get('/dashboard', 'DashboardController@index');


Route::group(['prefix' => 'admin'], function () {
    Voyager::routes();
});
