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

Auth::routes();

Route::get('/', function () {
    return view('welcome');
});
Route::get('/home', 'HomeController@index')->name('home');

Route::get('admin/product', 'Admin\ProductController@index')->name('admin.product.index');
Route::post('admin/product/{id}/view', 'Admin\ProductController@view')->name('admin.product.view');
Route::get('admin/product/add', 'Admin\ProductController@add')->name('admin.product.add');
Route::get('admin/product/{id}/edit', 'Admin\ProductController@edit')->name('admin.product.edit');
Route::post('admin/product/store', 'Admin\ProductController@store')->name('admin.product.store');
Route::put('admin/product/{id}/store', 'Admin\ProductController@store')->name('admin.product.update');
Route::delete('admin/product/delete', 'Admin\ProductController@delete')->name('admin.product.delete');

Route::post('/discount/store', 'DiscountController@store')->name('discount.store');

Route::post('/review/store', 'ReviewController@store')->name('review.store');
