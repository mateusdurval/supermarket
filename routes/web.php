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


Route::get('/', 'ProductController@index')->name('welcome');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::middleware(['auth', 'is.admin'])->group(function () { 
    Route::prefix('admin')->group(function () {
        Route::prefix('products')->group(function () {
            Route::get('read', 'ProductController@index2')->name('products');
            Route::get('edit/{id}', 'ProductController@edit')->name('products-edit');
            Route::post('update', 'ProductController@update')->name('products-update');
            Route::get('create', 'ProductController@create')->name('products-create');
            Route::post('store', 'ProductController@store')->name('products-store');
            Route::post('destroy/{id}', 'ProductController@destroy')->name('products-destroy');
            Route::get('search', 'ProductController@search')->name('products-search');
        });

        Route::prefix('requests')->group(function () {
            Route::get('read', 'RequestController@index')->name('requests');
            Route::post('create', 'RequestController@create')->name('requests-create');
            Route::post('destroy/{id}', 'RequestController@destroy')->name('requests-delete');
        });
    });
});
