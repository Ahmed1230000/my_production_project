<?php

use App\Domains\Organizations\Http\Controllers\OrganizationControllers\OrganizationController;
use Illuminate\Support\Facades\Route;


Route::middleware('auth:api')->group(function () {
    Route::apiResource('organizations', OrganizationController::class);
});