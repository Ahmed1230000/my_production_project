<?php

use App\Domains\Authorization\Http\Controllers\PermissionController;
use App\Domains\Authorization\Http\Controllers\RoleController;
use App\Domains\Authorization\Http\Controllers\RolePermissionController;
use App\Domains\Authorization\Http\Controllers\UserPermissionController;
use App\Domains\Authorization\Http\Controllers\UserRoleController;
use Illuminate\Support\Facades\Route;





Route::middleware('auth:api')->group(function () {
    Route::apiResource('roles', RoleController::class);
    Route::apiResource('permissions', PermissionController::class);


    Route::prefix('roles/{roleId}/permissions')->group(function () {
        Route::post('/', [RolePermissionController::class, 'add']);
        Route::delete('/', [RolePermissionController::class, 'remove']);
    });

    Route::prefix('users/{userId}/roles')->group(function () {
        Route::post('/', [UserRoleController::class, 'assign']);
        Route::delete('/', [UserRoleController::class, 'remove']);
    });

    Route::prefix('users/{userId}/permissions')->group(function () {
        Route::post('/', [UserPermissionController::class, 'assign']);
        Route::delete('/', [UserPermissionController::class, 'remove']);
    });
});
