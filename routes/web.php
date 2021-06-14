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

Route::get('/', 'WelcomeController@index')->name('welcome');

Auth::routes();

Route::middleware(['auth', 'is.admin'])->group(function () { 
    Route::prefix('admin')->group(function () {
        Route::prefix('products')->group(function () {
            Route::get('read', 'ProductController@index')->name('products');
            Route::get('edit/{productId}', 'ProductController@edit')->name('products-edit');
            Route::post('update', 'ProductController@update')->name('products-update');
            Route::get('create', 'ProductController@create')->name('products-create');
            Route::post('store', 'ProductController@store')->name('products-store');
            Route::post('destroy/{id}', 'ProductController@destroy')->name('products-destroy');
            Route::get('search', 'ProductController@search')->name('products-search');
        });

        Route::prefix('requests')->group(function () {
            Route::get('read', 'RequestController@index')->name('admin-requests-read');
            Route::get('manage/{id}', 'RequestController@manage')->name('admin-requests-manage');
            Route::get('update-status/{id}/{status}', 'RequestController@updateStatus')->name('update-status');
        });
    });
});


Route::middleware(['auth'])->group(function () { 
    Route::prefix('carts')->group(function () {
        Route::get('read', 'CartController@index')->name('carts');
        Route::get('add-address', 'CartController@addAddress')->name('carts-add-address');
        Route::post('create', 'CartController@create')->name('carts-create');
        Route::delete('destroy/{id}', 'CartController@destroy')->name('carts-delete');
        Route::get('status', 'CartController@status')->name('carts-status');
        Route::put('update-amount', 'CartController@amountProduct')->name('update-amount');
    });
    
    
    Route::prefix('user')->group(function () {
        Route::prefix('address')->group(function () {
            Route::get('verify', 'UserController@verifyAddress')->name('verifyAddress');
            Route::get('reset-password', 'UserController@resetPassword')->name('reset-password');
            Route::post('reset-password', 'UserController@actionResetPassword')->name('post-reset-password');
            Route::get('create', 'AddressController@create')->name('address-create');
            Route::post('store', 'AddressController@store')->name('address-store');
        });
    
        Route::prefix('card')->group(function () {
            Route::get('verify', 'UserController@verifyCard')->name('verifyCard');
            Route::get('read', 'CardController@index')->name('cards');
            Route::get('create', 'CardController@create')->name('card-create');
            Route::post('store', 'CardController@store')->name('card-store');
        });

        Route::prefix('address')->group(function () {
            Route::get('verify', 'UserController@verifyAddress')->name('verifyAddress');
        });

        Route::prefix('requests')->group(function () {
            Route::get('read', 'RequestController@index')->name('request-read');
            Route::post('store', 'RequestController@store')->name('request-store');
            Route::get('review', 'RequestController@review')->name('request-review');
            Route::put('checkout', 'RequestController@checkout')->name('request-checkout');
            Route::get('status', 'RequestController@status')->name('request-status');
        });
    });
});

