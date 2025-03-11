<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('login', [AuthController::class, 'login'])->name('login');

Route::middleware('auth:sanctum')->prefix('user')->group( function () {
    Route::get('/profile', [UserController::class, 'getProfile']);
    Route::put('/update', [UserController::class, 'updateProfile']);
});
