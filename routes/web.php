<?php

use App\Http\Controllers\AdController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('pages/home');
});

Route::get('/home', function () {
    return view('pages/home');
})->middleware(['auth'])->name('home');

Route::middleware('auth')->group(function () {

    Route::get    ('my-ads',       [AdController::class, 'index']);
    Route::get    ('create-ad',    [AdController::class, 'create']);
    Route::get    ('edit-ad/{id}', [AdController::class, 'edit']);
    Route::post   ('ad',           [AdController::class, 'insert']);
    Route::put    ('ad',           [AdController::class, 'update']);
    // TODO remover anúncio
    Route::delete ('ad/{id}',      [AdController::class, 'delete']);
    Route::delete ('ad-info/{id}',      [AdController::class, 'delete']);


});


require __DIR__.'/auth.php';
