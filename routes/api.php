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

Route::group(['namespace' => 'App\Http\Controllers\API'], function ($router) {

    Route::group(['prefix' => 'blockchain'] , function ($router) {
        
        Route::get('', 'BlockChainController@index');

        Route::post('add-block', 'BlockChainController@addBlock');
    });

    Route::group(['prefix' => 'transactions'] , function ($router) {
        
        // Route::get('', 'BlockChainController@index');

        // Route::post('add-transaction', 'TransactionController@addTransaction')->name('transactions.add');
    });
});