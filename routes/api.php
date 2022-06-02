<?php

use App\Http\Controllers\Api\ApiController;
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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });
Route::namespace('App\Http\Controllers\Api')->group(function () {

Route::post('login', 'ApiController@login');
Route::middleware('auth:api')->group(function () {
    Route::get('logout', 'ApiController@logout');
    Route::get('user-info', 'ApiController@userInfo');

});
});
