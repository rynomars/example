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

/*
Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
*/


Route::get('items-working', 'ItemController@getWorkingItems');
Route::get('items/{id}', 'ItemController@getItem');
Route::post('items', 'ItemController@createItem');
Route::put('items/{id}', 'ItemController@updateItem');

Route::get('part-number-lookup', 'ItemController@partNumberLookup');
