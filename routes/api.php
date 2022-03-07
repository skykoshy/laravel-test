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
Route::post('register', 'App\Http\Controllers\UserController@register');
Route::post('auth', 'App\Http\Controllers\UserController@authenticate');

Route::group(['middleware' => ['jwt.verify']], function() {
    Route::resource('factura', App\Http\Controllers\FacturaController::class)
    ->only(['index','store','update','show','destroy']);
    Route::resource('item', App\Http\Controllers\ItemController::class)
    ->only(['index','store','update','show','destroy']);

});


