<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/login','logincontroller@index');

route::get('/logout','logincontroller@logout');

route::post('/register','logincontroller@register');

route::get('/inventory','InvController@give');
route::get('/inventory/{id}','InvController@one');
//takes data for a new inventory record
route::post('/inventory','InvController@new');
//updates/deletes an inventory record
route::put('/inventory','InvController@update');
//gives data about sales
route::get('/myorders','SalesController@mine');
route::get('/sales','SalesController@give');
//when a purchase is successful
route::post('/sales','SalesController@new');

//cart data
route::get('/cart','CartController@mycart');
//add item to a cart
route::post('/cart','CartController@addtocart');
//prompt sale/edit cart
route::put('/cart','CartController@update');


//get user's username basically lol
route::get('/account','logincontroller@username');

//update account info
route::put('/account','logincontroller@update');

//keist kieki inventoriaus iraso
route::put('/plusminus/{id}','InvController@plusminus');
//isimti itema is shopo
route::put('/remove/{id}','InvController@remove');

//update store settings
route::put('/settings','settingscontroller@save');

route::get('/settings','settingscontroller@load');

//PAYPAL
route::post('/paystart','paypalcontroller@start');
route::get('/payconfirm','paypalcontroller@confirm');


//cart update routes
route::put('/cartplus','CartController@plus');
route::put('/cartminus','CartController@minus');

//cart delete route
route::delete('/cartdel/{id}','CartController@delete');

//Route to get stats about sales for stats chart basically
route::post('/stats','SalesController@stats');

//non paginated full list of items

route::get('/inventoryfull','InvController@full');