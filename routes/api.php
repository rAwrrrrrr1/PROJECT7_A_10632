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

Route::post('register', 'Api\AuthController@register');
Route::post('login', 'Api\AuthController@login');

Route::group(['middleware' => 'auth:api'], function(){
    Route::get('product', 'Api\ProductController@index');
    Route::get('product/{id}', 'Api\ProductController@show');
    Route::post('product', 'Api\ProductController@store');
    Route::put('product/{id}', 'Api\ProductController@update');
    Route::delete('product{id}', 'Api\ProductController@destroy');
});

Route::group(['middleware' => 'auth:api'], function(){
    Route::get('employee', 'Api\EmployeeController@index');
    Route::get('employee/{id}', 'Api\EmployeeController@show');
    Route::post('employee', 'Api\EmployeeController@store');
    Route::put('employee/{id}', 'Api\EmployeeController@update');
    Route::delete('employee{id}', 'Api\EmployeeController@destroy');
});