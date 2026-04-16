<?php

use App\Domains\User\Http\Controllers\UserDeactivateController;
use Illuminate\Support\Facades\Route;




Route::middleware('auth:api')->group(function () {
    Route::post('/{id}/deactivate', [UserDeactivateController::class, 'deactivate']);
});
