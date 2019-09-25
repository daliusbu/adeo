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

Route::get('product', 'ProductController@index')->name('product.index');
Route::post('product/{id}/view', 'ProductController@view')->name('product.view');
Route::get('product/add', 'ProductController@add')->name('product.add');
Route::put('product/{id}/edit', 'ProductController@edit')->name('product.edit');
Route::post('product/store', 'ProductController@store')->name('product.store');
Route::delete('product/delete', 'ProductController@delete')->name('product.delete');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::post('/discount/store', 'DiscountController@store')->name('discount.store');
