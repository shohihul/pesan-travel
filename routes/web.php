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

    Route::get('logout', 'Auth\LoginController@logout')
        ->name('admin.logout');

Route::group(['middleware' => ['web', 'auth', 'roles']],function(){
    Route::group(['roles'=>'admin'],function(){
        Route::namespace('Admin')->group(function () {

            Route::get('/admin', 'DashboardController@index')
                ->name('admin.dashboard');

            // Ajax
            Route::post('/ajax/invoice/{invoice}/update', 'InvoiceController@ajax_update');
            Route::post('/ajax/doorToDoor_order/{doorToDoorOrder}/update', 'DoorToDoorOrderController@ajax_update');
            Route::post('/ajax/doorToDoor_service/{doorToDoorService}/update', 'DoorToDoorServiceController@ajax_update');
            
            // User
            Route::get('/admin/driver', 'UserController@driverIndex')
                ->name('admin.driver.index'); // route('admin.driver.index')
            Route::get('/admin/customer', 'UserController@customerIndex')
                ->name('admin.customer.index'); // route('admin.customer.index')
            Route::get('/admin/user/create', 'UserController@create')
                ->name('admin.user.create'); // route('admin.user.create')
            Route::post('/admin/user/store', 'UserController@store')
                ->name('admin.user.store'); // route('admin.user.store')
            Route::delete('/admin/customer/{user}/delete', 'UserController@deleteCustomer')
                ->name('admin.customer.delete'); // route('admin.customer.delete')
            Route::delete('/admin/user/{user}/delete', 'UserController@delete')
                ->name('admin.user.delete'); // route('admin.user.delete')
            Route::get('/admin/user/{user}/edit', 'UserController@edit')
                ->name('admin.user.edit');
            Route::put('/admin/user/{user}/update', 'UserController@update')
                ->name('admin.user.update');
                
            // Door To Door Order
            Route::get('/admin/doorToDoor_order/index', 'DoorToDoorOrderController@index')
                ->name('admin.doorToDoor_order.index'); // route('admin.doorToDoor_order.index')
            Route::get('/admin/doorToDoor_order/{service_id}/create', 'DoorToDoorOrderController@create')
                ->name('admin.doorToDoor_order.create'); // route('admin.doorToDoor_order.create')
            Route::post('/admin/doorToDoor_order/store', 'DoorToDoorOrderController@store')
                ->name('admin.doorToDoor_order.store'); // route('admin.doorToDoor_order.store')
            Route::get('/admin/doorToDoor_order/{doorToDoorOrder}/location_edit', 'DoorToDoorOrderController@location_edit')
                ->name('admin.doorToDoor_order.location_edit'); // route('admin.doorToDoor_order.location_edit')
            Route::put('/admin/doorToDoor_order/{doorToDoorOrder}/update', 'DoorToDoorOrderController@update')
                ->name('admin.doorToDoor_order.update'); // route('admin.doorToDoor_order.update')
            Route::get('/admin/doorToDoor_order/{doorToDoorOrder}/show', 'DoorToDoorOrderController@show')
                ->name('admin.doorToDoor_order.show'); // route('admin.doorToDoor_order.show')
            Route::delete('/admin/doorToDoor_order/{doorToDoorOrder}/delete', 'DoorToDoorOrderController@delete')
                ->name('admin.doorToDoor_order.delete'); // route('admin.doorToDoor_order.delete')

            // Door To Door Service
            Route::get('/admin/doorToDoor_service/scheduled_index', 'DoorToDoorServiceController@scheduled_index')
                ->name('admin.doorToDoor_service.scheduled_index'); // route('admin.doorToDoor_service.scheduled_index')

            Route::get('/admin/doorToDoor_service/create', 'DoorToDoorServiceController@create')
                ->name('admin.doorToDoor_service.create'); // route('admin.doorToDoor_service.create')
            Route::post('/admin/doorToDoor_service/store', 'DoorToDoorServiceController@store')
                ->name('admin.doorToDoor_service.store'); // route('admin.doorToDoor_service.store')
            Route::get('/admin/doorToDoor_service/{doorToDoorService}/show', 'DoorToDoorServiceController@show')
                ->name('admin.doorToDoor_service.show'); // route('admin.doorToDoor_service.show')
            Route::get('/admin/doorToDoor_service/{doorToDoorService}/route', 'DoorToDoorServiceController@route')
                ->name('admin.doorToDoor_service.route'); // route('admin.doorToDoor_service.route')
            Route::get('/admin/doorToDoor_service/{doorToDoorService}/search_route', 'DoorToDoorServiceController@search_route')
                ->name('admin.doorToDoor_service.search_route'); // route('admin.doorToDoor_service.search_route')

            Route::get('/admin/doorToDoor_service/{doorToDoorService}/permutation_route', 'DoorToDoorServiceController@permutation_route')
                ->name('admin.doorToDoor_service.permutation_route'); // route('admin.doorToDoor_service.permutation_route')

            // Cars
            Route::get('/admin/cars', 'CarController@index')
                ->name('admin.car.index'); // route('admin.car.index')
            Route::get('/admin/cars/create', 'CarController@create')
                ->name('admin.car.create'); // route('admin.car.create')
            Route::post('/admin/cars/store', 'CarController@store')
                ->name('admin.car.store'); // route('admin.car.store')
            Route::get('/admin/cars/{car}/edit', 'CarController@edit')
                ->name('admin.car.edit'); // route('admin.car.edit')
            Route::put('/admin/cars/{car}/update', 'CarController@update')
                ->name('admin.car.update'); // route('admin.car.update')
            Route::delete('/admin/cars/{car}/delete', 'CarController@delete')
                ->name('admin.car.delete'); // route('admin.car.delete')

            // Saving Accountd
            Route::get('/admin/saving_account', 'SavingAccountsController@index')
                ->name('admin.saving_account.index'); // route('admin.saving_account.index')
            Route::get('/admin/saving_account/create', 'SavingAccountsController@create')
                ->name('admin.saving_account.create'); // route('admin.saving_account.create')
            Route::post('/admin/saving_account/store', 'SavingAccountsController@store')
                ->name('admin.saving_account.store'); // route('admin.saving_account.store')
            Route::delete('/admin/saving_account/{id}/destroy', 'SavingAccountsController@destroy')
                ->name('admin.saving_account.destroy'); // route('admin.saving_account.destroy')
            Route::get('/admin/saving_account/{id}/edit', 'SavingAccountsController@edit')
                ->name('admin.saving_account.edit');
            Route::put('/admin/saving_account/{savingAccount}/update', 'SavingAccountsController@update')
                ->name('admin.saving_account.update');

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
