<?php

use App\Http\Controllers\Api\AdController as ApiAdController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\RentController;
use App\Http\Controllers\Auth\RegisteredUserController;
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
Route::post ("auth/login",    [AuthController::class, 'login']);
Route::post ("auth/register/{fromApi}", [RegisteredUserController::class, 'store']);

Route::middleware(['auth.jwt'])->group(function () {

    Route::get   ("ads",      [ApiAdController::class, 'get']);
    Route::post  ("ads",      [ApiAdController::class, 'insert']);
    Route::put   ("ads",      [ApiAdController::class, 'update']); // Mandar POST com um campo _method = "PUT"
    Route::delete("ads/{id}", [ApiAdController::class, 'delete']);

    Route::get   ("rents",      [RentController::class, 'get']);
    Route::post  ("rents",      [RentController::class, 'insert']);
    Route::put   ("rents",      [RentController::class, 'update']); // Mandar POST com um campo _method = "PUT"
    Route::delete("rents/{id}", [RentController::class, 'delete']);

});

