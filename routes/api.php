<?php

use Illuminate\Http\Request;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('accounts','AccountsController@index');
Route::get('account/{id}','AccountsController@show');
Route::post('createaccount','AccountsController@store');
Route::post('savecont','PaymentsController@store');
Route::post('upaccount','AccountsController@update');
Route::delete('deletecont/{id}','PaymentsController@destroy');
