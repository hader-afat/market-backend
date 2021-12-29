<?php

use Illuminate\Support\Facades\Input;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers;
use App\Http\Controllers\API\AuthController;
use App\Http\Middleware\ModifyTokenTable;
use App\Models\Product;

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
//path for routes in this file has prefix -> api

Route::post('test', 'App\Http\Controllers\MyController@test')->name('test');

Route::post('login',[App\Http\Controllers\API\AuthController::class,'login']);
Route::post('register',[App\Http\Controllers\API\AuthController::class,'register']);

Route::get('all-products', 'App\Http\Controllers\Controller@index');


Route::get('test', 'App\Http\Controllers\ProductController@tt');
Route::post('search','App\Http\Controllers\Controller@search');

Route::middleware(['auth:sanctum'])->group(function ()
{
    Route::post('logout',[App\Http\Controllers\API\AuthController::class,'logout']);

    //Route::post('search','App\Http\Controllers\Controller@search');

    Route::get('purchase-product/{id}',[App\Http\Controllers\UserController::class,'purchase']);
    Route::post('add_cash',[App\Http\Controllers\UserController::class,'add_cash']);
    Route::get('profile',[App\Http\Controllers\UserController::class,'profile']);
    Route::resource('products',App\Http\Controllers\ProductController::class);
});

Route::resource('main','App\Http\Controllers\MyController');