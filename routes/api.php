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

Route::get('country', [\App\Http\Controllers\Api\Country\CountryController::class,
 'country']);

Route::get('country/{id}', [\App\Http\Controllers\Api\Country\CountryController
::class, 'countryById']);

//Route::post('country', [\App\Http\Controllers\Api\Country\CountryController::class,
// 'countrySave']);

/*Route::put('country/{id}', [\App\Http\Controllers\Api\Country\CountryController::class,
    'countryEdit']);*/
/*Route::delete('country/{id}', [\App\Http\Controllers\Api\Country\CountryController::class,
    'countryDelete']);*/

Route::post('login', [\App\Http\Controllers\Api\Auth\LoginController::class, 'login']);

//Route::get('refresh', [\App\Http\Controllers\Api\Auth\LoginController::class,
// 'refresh']);


Route::group(['middleware' => ['jwt.verify']], function () {

    Route::get('refresh', [\App\Http\Controllers\Api\Auth\LoginController::class, 'refresh']);
    Route::post('country', [\App\Http\Controllers\Api\Country\CountryController::class, 'countrySave']);
    Route::put('country/{id}', [\App\Http\Controllers\Api\Country\CountryController::class,
        'countryEdit']);
    Route::delete('country/{id}', [\App\Http\Controllers\Api\Country\CountryController::class,
        'countryDelete']);


});