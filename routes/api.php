<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
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


Route::group(['middleware' => ['jwt.verify']], function () {

    Route::get('refresh', [\App\Http\Controllers\Api\Auth\LoginController::class, 'refresh']);
    Route::post('country', [\App\Http\Controllers\Api\Country\CountryController::class, 'countrySave']);
    Route::put('country/{id}', [\App\Http\Controllers\Api\Country\CountryController::class,
        'countryEdit']);
    Route::delete('country/{id}', [\App\Http\Controllers\Api\Country\CountryController::class,
        'countryDelete']);
});

Route::controller(AuthController::class)->group(function () {
    Route::post('login', 'login');
    Route::post('register', 'register');
    Route::post('logout', 'logout');
    Route::post('refresh', 'refresh');
    Route::put('update/{id}', 'update');
    Route::get('me', 'me');

});

Route::group(['middleware' => ['auth', 'admin']], function() {
    Route::get('/admin', [\App\Http\Controllers\AdminController::class, 'index']);
});


