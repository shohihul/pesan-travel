<?php

use Illuminate\Support\Facades\Route;

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

Auth::routes();

Route::get('/', 'HomeController@index')->name('home');

Route::get('/getRegencieByProvince', 'AreaController@getRegencieByProvince')
    ->name('getRegencieByProvince');

Route::group(['middleware' => ['web', 'auth', 'roles']],function(){
    Route::group(['roles'=>'admin'],function(){
        Route::namespace('Admin')->group(function () {

            Route::get('/admin', 'DashboardController@index')
            ->name('admin.dashboard');

            // User
            Route::get('/admin/driver', 'UserController@driverIndex')
                ->name('admin.driver.index'); // route('admin.driver.index')
            Route::get('/admin/customer', 'UserController@customerIndex')
                ->name('admin.customer.index'); // route('admin.customer.index')
            Route::get('/admin/user/create', 'UserController@create')
                ->name('admin.user.create'); // route('admin.user.create')
            Route::post('/admin/user/store', 'UserController@store')
                ->name('admin.user.store'); // route('admin.user.store')
            Route::delete('/admin/user/{user}/delete', 'UserController@delete')
                ->name('admin.user.delete'); // route('admin.user.delete')

            // Door To Door Order
            Route::get('/admin/doorToDoor_order/{service_id}/create', 'DoorToDoorOrderController@create')
                ->name('admin.doorToDoor_order.create'); // route('admin.doorToDoor_order.create')
            Route::post('/admin/doorToDoor_order/store', 'DoorToDoorOrderController@store')
                ->name('admin.doorToDoor_order.store'); // route('admin.doorToDoor_order.store')


            // Door To Door Service
            Route::get('/admin/doorToDoor_service/scheduled_index', 'DoorToDoorServiceController@scheduled_index')
                ->name('admin.doorToDoor_service.scheduled_index'); // route('admin.doorToDoor_service.scheduled_index')

            Route::get('/admin/doorToDoor_service/create', 'DoorToDoorServiceController@create')
                ->name('admin.doorToDoor_service.create'); // route('admin.doorToDoor_service.create')
            Route::post('/admin/doorToDoor_service/store', 'DoorToDoorServiceController@store')
                ->name('admin.doorToDoor_service.store'); // route('admin.doorToDoor_service.store')
            Route::get('/admin/doorToDoor_service/{id}/show', 'DoorToDoorServiceController@show')
                ->name('admin.doorToDoor_service.show'); // route('admin.doorToDoor_service.show')
            Route::get('/admin/doorToDoor_service/{id}/route', 'DoorToDoorServiceController@route')
                ->name('admin.doorToDoor_service.route'); // route('admin.doorToDoor_service.route')
            Route::get('/admin/doorToDoor_service/{id}/search_route', 'DoorToDoorServiceController@search_route')
                ->name('admin.doorToDoor_service.search_route'); // route('admin.doorToDoor_service.search_route')

            // Cars
            Route::get('/admin/cars', 'CarController@index')
                ->name('admin.car.index'); // route('admin.car.index')
            Route::get('/admin/cars/create', 'CarController@create')
                ->name('admin.car.create'); // route('admin.car.create')
            Route::post('/admin/cars/store', 'CarController@store')
                ->name('admin.car.store'); // route('admin.car.store')

            // Saving Accountd
            Route::get('/admin/saving_account', 'SavingAccountsController@index')
                ->name('admin.saving_account.index'); // route('admin.saving_account.index')
            Route::get('/admin/saving_account/create', 'SavingAccountsController@create')
                ->name('admin.saving_account.create'); // route('admin.saving_account.create')
            Route::post('/admin/saving_account/store', 'SavingAccountsController@store')
                ->name('admin.saving_account.store'); // route('admin.saving_account.store')
            Route::delete('/admin/saving_account/{id}/destroy', 'SavingAccountsController@destroy')
                ->name('admin.saving_account.destroy'); // route('admin.saving_account.destroy')

        });
        
    });

    Route::group(['roles'=>'driver'],function(){
        Route::namespace('Driver')->group(function () {

        Route::get('/driver', 'HomeController@index')
            ->name('driver.home');
            
        });
    });

    Route::group(['roles'=>'customer'],function(){
        Route::namespace('Customer')->group(function () {

            Route::get('/customer', 'HomeController@index')
                ->name('customer.home');
            Route::get('/customer/profile', 'HomeController@profile')
            ->name('customer.profile');

        });
    });
});
