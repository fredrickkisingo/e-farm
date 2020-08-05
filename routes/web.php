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


    Route::get('/json', function(){
        $json = file_get_contents(storage_path('CallbackResponse.json'));
        $CallbackMetadata = json_decode($json,true);
       

          foreach ($CallbackMetadata as $obj)  {
          
            $res = $obj["Body"]["stkCallback"];
            // dd($res);
           
            foreach ($res as $key => $value) {
                // dd($res);
                $insertArr[str_slug($key,'_')] = $value;

                // $Amount = $value['0']->Value;// Payment Amount..
                // $mpesaRef = $value['1']->Value;// Payment Referrence MPESA
                // $mpesaPhoneNumber = $value['4']->Value;// Payment Phone Number
            } 
        }
        DB::table('mpesa_pay')->insert($res);
        // return views();
        dd("Finished adding data in examples table");
    });

   




Auth::routes();





Route::get('/dashboard', 'DashboardController@index');






































