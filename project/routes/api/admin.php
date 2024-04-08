<?php

use App\Http\Api\Controllers\Admin\Permission\PermissionController;
use App\Http\Api\Controllers\Admin\Role\RoleController;
use App\Http\Api\Controllers\Admin\User\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/permissions', PermissionController::class);

Route::apiResources([
    'roles' => RoleController::class,
    'users' => UserController::class,
]);
