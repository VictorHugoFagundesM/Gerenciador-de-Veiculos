<?php

use App\Http\Controllers\AdController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\RentController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;


Route::get('/',     [HomeController::class, 'index']);
Route::get('/home', [HomeController::class, 'index']);

Route::middleware('auth')->group(function () {

    Route::get    ('my-ads',       [AdController::class, 'index']);
    Route::get    ('ad-info/{id}', [AdController::class, 'info']);
    Route::get    ('create-ad',    [AdController::class, 'create']);
    Route::get    ('edit-ad/{id}', [AdController::class, 'edit']);
    Route::post   ('ad',           [AdController::class, 'insert']);
    Route::put    ('ad',           [AdController::class, 'update']);
    Route::delete ('ad/{id}',      [AdController::class, 'delete']);

    Route::get  ('my-rents', [RentController::class, 'index']);
    Route::post ('rent', [RentController::class, 'insert']);
    Route::put  ('rent', [RentController::class, 'update']);

    Route::get  ('profile', [UserController::class, 'index']);
    Route::put  ('profile', [UserController::class, 'update']);

});


require __DIR__.'/auth.php';
