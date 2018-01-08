<?php
/**
 * Authenticated routes for Api
 * Prefix 'api/v1', middleware 'auth:api'
 * Namespace 'App\Http\Controllers\Api\v1'
 */

Route::get('/me', 'UsersController@me');
