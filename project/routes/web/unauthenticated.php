<?php
/**
 * Unauthenticated routes
 */

Auth::routes();

Route::get('/', App\Http\Controllers\WelcomeController::class);
