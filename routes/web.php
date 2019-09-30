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
    return view('home');
})->name('home');

Route::get('product', 'ProductController@index')->name('product.index');
Route::post('/discount/store', 'DiscountController@store')->name('discount.store');
Route::get('/review/{product}/add', 'ReviewController@add')->name('review.add');
Route::post('/review/store', 'ReviewController@store')->name('review.store');

Route::group(['middleware' => 'auth'], function () {
    Route::get('admin/product', 'Admin\ProductController@index')->name('admin.product.index');
    Route::post('admin/product/{id}/view', 'Admin\ProductController@view')->name('admin.product.view');
    Route::get('admin/product/add', 'Admin\ProductController@add')->name('admin.product.add');
    Route::get('admin/product/{id}/edit', 'Admin\ProductController@edit')->name('admin.product.edit');
    Route::post('admin/product/store', 'Admin\ProductController@store')->name('admin.product.store');
    Route::put('admin/product/{id}/store', 'Admin\ProductController@store')->name('admin.product.update');
    Route::delete('admin/product/delete', 'Admin\ProductController@delete')->name('admin.product.delete');

    Route::get('admin/reviews', 'ReviewController@index')->name('admin.review.index');
    Route::get('admin/review/{id}/edit', 'ReviewController@edit')->name('admin.review.edit');
    Route::put('admin/review/{review}/store', 'ReviewController@store')->name('admin.review.update');
    Route::delete('admin/review/delete', 'ReviewController@delete')->name('admin.review.delete');
});
