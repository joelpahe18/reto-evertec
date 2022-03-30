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
    return view('shop');
});

Route::post('/pago', 'App\Http\Controllers\OrdersController@createTransaction');
Route::get('/listado', 'App\Http\Controllers\OrdersController@listTransactions');
Route::get('/verificar/{requestId}', 'App\Http\Controllers\OrdersController@verifyTransaction');
Route::get('/procesar/{requestId}', 'App\Http\Controllers\OrdersController@processTransaction');