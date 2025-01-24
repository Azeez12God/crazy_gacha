<?php

use App\Http\Controllers\API\ShopApiController;
use App\Http\Controllers\API\UserApiController;
use App\Http\Controllers\API\LoginUserApiController;
use App\Http\Controllers\API\PrizeApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');*/

//Route::controller(UserApiController::class)->group(function () {
//    Route::get('/users', 'index');
//    Route::get('/users/{user}', 'show');
//    Route::post('/users', 'store');
//    Route::put('/users/{user}', 'update');
//    Route::delete('/users/{user}', 'destroy');
//});

Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('users', UserApiController::class);
    Route::apiResource('shop', ShopApiController::class);
    Route::apiResource('/prizes', PrizeApiController::class);
});


Route::get('/users/{user}/prizes', [UserApiController::class, 'prizes']);

Route::post('/register',[\App\Http\Controllers\API\RegisterUserApiController::class,'register']);
Route::post('/login',[LoginUserApiController::class,'login']);
Route::post('/logout',[LoginUserApiController::class,'logout'])->middleware('auth:sanctum');
