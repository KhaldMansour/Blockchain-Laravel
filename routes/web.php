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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::group(['namespace' => 'App\Http\Controllers'], function ($router) {

    Route::get('/home', 'BlockChainController@index')->name('home');
    
    Route::get('/profile' , 'UserController@getProfile')->name('profile');

    Route::group(['prefix' => 'transactions'] , function ($router) {

        Route::get('create', 'TransactionController@create')->name('transactions.create');

        Route::post('add-transaction', 'TransactionController@addTransaction')->name('transactions.add');
    });

    Route::get('/blocks/{id}', 'BlockController@show')->name('home');
});
