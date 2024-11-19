<?php

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

Route::name('api.')->namespace('Api')->middleware('api.disable')->group(function () {
    Route::name('items.')->prefix('items')->group(function () {
        Route::get('all', 'ItemController@all')->name('all');
        Route::get('single', 'ItemController@single')->name('single');
    });
    Route::name('purchases.')->prefix('purchases')->group(function () {
        Route::post('validation', 'PurchaseController@validation')->name('validation');
    });
});
