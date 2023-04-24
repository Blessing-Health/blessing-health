<?php

use App\Helpers\AppHelpers;
use App\Http\Controllers\AuthController;
use App\Models\User;
use Illuminate\Support\Facades\Route;

// We use laravel as an API backend for our SPA - check routes/spa.php
Route::prefix('auth')->group(function () {
    Route::get('login', [AuthController::class, 'login'])->name('login');
    Route::get('callback', [AuthController::class, 'oauthCallback']);
    Route::post('logout', [AuthController::class, 'logout']);
    Route::post('impersonate/{user}', [AuthController::class, 'impersonate']);
});

// Dev only backend testing routes
Route::middleware('devOnly')->group(function () {
    //
});

Route::middleware('auth:sanctum')
    ->get('/{catchall?}', function () {
        if (AppHelpers::isDev()) {
            // Special catch-all while on development (tell user to run the vite devserver)
            abort(422, 'Run `yarn dev` to get started. For more information refer to the README.md');
        } else {
            // On prod we can simply jump straight to the SPA folder (requires yarn build to have been run)
            return redirect('/spa');
        }
    });
