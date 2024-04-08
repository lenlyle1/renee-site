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
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Route::controller(AuthController::class)->group(function(){
//     Route::post('register','register');
//     Route::post('login','login');
//     Route::get('userdetail','userDetails'); //->middleware('auth:sanctum');
// });


Route::post('register',[AuthController::class,'register']);
Route::post('login',[AuthController::class,'login']);
Route::post('logout',[AuthController::class,'logout']);
Route::get('userdetail',[AuthController::class,'userDetails'])
    ->middleware('auth:sanctum');

// api/v1
Route::group(['prefix' => 'v1', 'namespace' => 'App\Http\Controllers\Api\V1', 'middleware' => 'auth:sanctum'], function () {
    Route::apiResource('/providers', ProviderController::class);
    Route::apiResource('/services', ServiceController::class);
    Route::apiResource('/customers', CustomerController::class);
    Route::apiResource('/companies', CompanyController::class);

});


// Route::prefix('v1')->namespace('App\Http\Controllers\Api\V1')->group(function () {
//     Route::apiResource('/providers', ProviderController::class);
//     Route::apiResource('/services', ServiceController::class);
//     Route::apiResource('/customers', CustomerController::class);
//     Route::apiResource('/companies', CompanyController::class);
// });

// Route::apiResource('providers', 'ProviderController');

