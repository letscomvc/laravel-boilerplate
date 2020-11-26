<?php
/**
 * Authenticated routes
 * Middleware 'auth'
 */

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])
    ->name('home');

Route::resource('users', App\Http\Controllers\UserController::class);
Route::get('pagination/users', [App\Http\Controllers\UserController::class, 'pagination'])
    ->name('pagination.users');
