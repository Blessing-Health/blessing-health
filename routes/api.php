<?php

use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\NewsController;
use App\Http\Controllers\Admin\RegisterController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum'])->group(function () {
    Route::apiResource('news', NewsController::class);
});

Route::post('login', [AuthController::class, 'login'])->name('login');
Route::post('logout', [AuthController::class, 'logout'])->name('logout');
Route::post('register', [RegisterController::class, 'register'])->name('register');
