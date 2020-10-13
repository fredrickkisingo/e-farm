<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group.
|
*/
//for customized routes




Route::get('/', 'PagesController@index');
Route::get('/about', 'PagesController@about');
Route::get('/services', 'PagesController@services');
Auth::routes();

Route::get('/dashboard', 'DashboardController@index');



Route::resource('posts', 'PostsController');
Route::resource('carts','CartsController');
Route::resource('maps','MapsController');
Route::resource('directions','DirectionsController');
Route::resource('harvestlosses','HarvestlossesController');
Route::resource('purchases', 'PurchasesController');



//mpesa functions routes
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




//admin dashboard routes

Route::group(['middleware'=>['auth','admin']],function(){

Route::get('/admin/dashboard',function(){
    return view('admin.dashboard');
});

Route::get('admin/role-register','Admin\DashboardController@register');
Route::get('/role-edit/{id}','Admin\DashboardController@registeredit');
Route::put('/role-register-update/{id}','Admin\DashboardController@registerupdate');
Route::delete('/role-delete/{id}','Admin\DashboardController@registerdelete');



});



   
















































