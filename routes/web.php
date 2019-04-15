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
    return redirect()->route('product.index');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('product', 'ProductController@index')->name('product.index');
Route::get('orders', 'OrdersController@index')->name('orders.index');
Route::post('orders', 'OrdersController@store')->name('orders.store');
Route::get('orders/{order}', 'OrdersController@show')->name('orders.show');
Route::get('orders/{order}/payments/', 'PayIntentController@create')->name('orders.payments.create');
Route::post('orders/{order}/payments/', 'PayIntentController@store')->name('orders.payments.store');
