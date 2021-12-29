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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::get('/test', function () {
    return "test";
});

Route::resource('cars',\App\Http\Controllers\API\CarAPIController::class);
//Route::resource('cars', \App\Http\Controllers\API\CarAPIController::class);
//    App\Htstp\Controllers\API\CarAPIController::class);


Route::resource('shops', App\Http\Controllers\API\ShopAPIController::class);
