<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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
Route::post('login', 'Api\AuthController@login');
Route::post('register', 'Api\AuthController@register');
Route::get('route', 'Api\DoorToDoorServiceController@route_index');
Route::get('route_schedule/{origin_id}/{destination_id}', 'Api\DoorToDoorServiceController@route_schedule_index');
// Route::get('schedule/{doorToDoorService}/show', 'Api\DoorToDoorServiceController@schedule_show');
Route::get('saving_account', 'Api\SavingAccountsController@get_bank');
Route::get('get_image/{fileeName}', 'Api\ImageController@getImage');

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

// Route::middleware('auth:api')->post('order_ticket', 'Api\DoorToDoorOrderController@store');

Route::group(['middleware' => ['auth:api']], function() {
    Route::namespace('Api')->group(function () {
        Route::post('order_ticket', 'DoorToDoorOrderController@store');
        Route::get('get_invoice', 'InvoiceController@get_invoice');
        Route::post('invoice/{invoice}/update', 'InvoiceController@update');
        Route::get('get_orders', 'DoorToDoorOrderController@get_orders');
        Route::get('get_orders/history', 'DoorToDoorOrderController@get_history');
        Route::get('orders/{doorToDoorOrder}/show', 'DoorToDoorOrderController@show');
        Route::post('orders/{doorToDoorOrder}/update', 'DoorToDoorOrderController@update');

        Route::get('task_driver', 'DoorToDoorServiceController@task_driver');
        Route::get('passenger/{doorToDoorService}', 'DoorToDoorServiceController@passenger');
        Route::get('passenger_orderBy_pickup/{doorToDoorService}', 'DoorToDoorServiceController@passenger_orderBy_pickup');
        Route::get('passenger_orderBy_dropoff/{doorToDoorService}', 'DoorToDoorServiceController@passenger_orderBy_dropoff');
    });
});