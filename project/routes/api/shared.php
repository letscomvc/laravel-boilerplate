<?php

use App\Http\Api\Controllers\Auth\LoginController;
use App\Http\Api\Controllers\Auth\LogoutController;
use App\Http\Api\Controllers\Auth\MeController;
use App\Http\Api\Controllers\Auth\UpdateMeController;
use Illuminate\Support\Facades\Route;

Route::post('/login', LoginController::class);

Route::middleware(['auth:sanctum'])
    ->group(function () {
        Route::get('/me', MeController::class);
        Route::put('/me', UpdateMeController::class);

        Route::post('/logout', LogoutController::class)->name('logout');
    });
