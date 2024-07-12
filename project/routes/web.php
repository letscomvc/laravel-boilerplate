<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/metrics', \App\Http\Shared\Controllers\MetricsController::class);
